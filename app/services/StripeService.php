<?php

require_once __DIR__ . '/../../config/stripe.php';

class StripeService
{
    private string $secretKey;
    private string $currency;

    public function __construct(?string $secretKey = null)
    {
        $config = getStripeConfig();
        $this->secretKey = $secretKey ?? (string) ($config['secretKey'] ?? '');
        $this->currency = (string) ($config['currency'] ?? 'eur');
    }

    /**
     * @param array<int, array{name:string,unit_amount:int,quantity:int,image?:string,description?:string}> $items
     */
    public function createCheckoutSession(array $items, string $successUrl, string $cancelUrl, ?string $customerEmail = null): array
    {
        $payload = [
            'mode' => 'payment',
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
        ];

        if ($customerEmail !== null && $customerEmail !== '') {
            $payload['customer_email'] = $customerEmail;
        }

        foreach ($items as $index => $item) {
            if (empty($item['name']) || !isset($item['unit_amount'], $item['quantity'])) {
                throw new InvalidArgumentException('Ogni item deve contenere name, unit_amount e quantity.');
            }

            $linePrefix = 'line_items[' . $index . ']';
            $payload[$linePrefix . '[quantity]'] = max(1, (int) $item['quantity']);
            $payload[$linePrefix . '[price_data][currency]'] = $this->currency;
            $payload[$linePrefix . '[price_data][unit_amount]'] = (int) $item['unit_amount'];
            $payload[$linePrefix . '[price_data][product_data][name]'] = (string) $item['name'];

            if (!empty($item['description'])) {
                $payload[$linePrefix . '[price_data][product_data][description]'] = (string) $item['description'];
            }

            if (!empty($item['image'])) {
                $payload[$linePrefix . '[price_data][product_data][images][0]'] = (string) $item['image'];
            }
        }

        return $this->request('POST', 'https://api.stripe.com/v1/checkout/sessions', $payload);
    }

    public function retrieveCheckoutSessionLineItems(string $sessionId): array
    {
        if ($sessionId === '') {
            throw new InvalidArgumentException('Session id non valido.');
        }

        return $this->request('GET', 'https://api.stripe.com/v1/checkout/sessions/' . rawurlencode($sessionId) . '/line_items', [
            'limit' => 100,
        ]);
    }

    /**
     * @param array<string, mixed> $payload
     */
    private function request(string $method, string $url, array $payload = []): array
    {
        if ($this->secretKey === '') {
            throw new RuntimeException('Configurazione Stripe mancante: imposta STRIPE_SECRET_KEY.');
        }

        $ch = curl_init();

        if ($ch === false) {
            throw new RuntimeException('Impossibile inizializzare cURL.');
        }

        $headers = [
            'Authorization: Bearer ' . $this->secretKey,
            'Content-Type: application/x-www-form-urlencoded',
        ];

        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ];

        if ($method !== 'GET') {
            $options[CURLOPT_POSTFIELDS] = http_build_query($payload);
        } elseif (!empty($payload)) {
            $url .= (str_contains($url, '?') ? '&' : '?') . http_build_query($payload);
        }

        $options[CURLOPT_URL] = $url;
        curl_setopt_array($ch, $options);

        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('Errore di rete con Stripe: ' . $error);
        }

        curl_close($ch);

        $decoded = json_decode($raw, true);

        if (!is_array($decoded)) {
            throw new RuntimeException('Risposta Stripe non valida.');
        }

        if ($status < 200 || $status >= 300) {
            $message = $decoded['error']['message'] ?? 'Richiesta Stripe fallita.';
            throw new RuntimeException($message);
        }

        return $decoded;
    }
}
