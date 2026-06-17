<?php

require_once __DIR__ . '/../../config/resend.php';

class EmailService
{
    private string $apiKey;
    private string $from;

    public function __construct()
    {
        $config = getResendConfig();
        $this->apiKey = (string) ($config['apiKey'] ?? '');
        $this->from = (string) ($config['from'] ?? '');
    }

    public function sendVerificationCodeEmail(string $to, string $code): void
    {
        $this->sendEmail(
            $to,
            'Codice di verifica registrazione',
            '<p>Il tuo codice di verifica e&#39; <strong>' . htmlspecialchars($code, ENT_QUOTES, 'UTF-8') . '</strong>.</p><p>Scade tra 10 minuti.</p>',
            'Impossibile inviare il codice di verifica'
        );
    }

    public function sendOrderRecapEmail(string $to, string $sessionId, array $lineItems): void
    {
        $rows = '';
        $total = 0;
        $currency = 'eur';

        foreach ($lineItems as $item) {
            $name = (string) ($item['description'] ?? 'Prodotto');
            $quantity = (int) ($item['quantity'] ?? 1);
            $amount = (int) ($item['amount_total'] ?? 0);
            $currency = (string) ($item['currency'] ?? $currency);
            $total += $amount;
            
            $rows .= '<tr>'
                . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;">' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '</td>'
                . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;text-align:center;">' . $quantity . '</td>'
                . '<td style="padding:10px;border-bottom:1px solid #e5e5e5;text-align:right;">' . htmlspecialchars($this->formatStripeAmount($amount, $currency), ENT_QUOTES, 'UTF-8') . '</td>'
                . '</tr>';
        }

        if ($rows === '') {
            $rows = '<tr><td colspan="3" style="padding:10px;border-bottom:1px solid #e5e5e5;">Ordine completato</td></tr>';
        }

        $html = '<div style="font-family:Arial,sans-serif;color:#171717;line-height:1.5;">'
            . '<h1 style="margin:0 0 12px;">Grazie per il tuo ordine</h1>'
            . '<p>Il pagamento e&#39; stato completato correttamente. Qui sotto trovi il riepilogo del tuo ordine.</p>'
            . '<table style="width:100%;border-collapse:collapse;margin-top:18px;">'
            . '<thead><tr>'
            . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:left;">Prodotto</th>'
            . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:center;">Quantita&#39;</th>'
            . '<th style="padding:10px;border-bottom:2px solid #171717;text-align:right;">Totale</th>'
            . '</tr></thead>'
            . '<tbody>' . $rows . '</tbody>'
            . '<tfoot><tr><td colspan="2" style="padding:14px 10px;text-align:right;font-weight:bold;">Totale ordine</td>'
            . '<td style="padding:14px 10px;text-align:right;font-weight:bold;">' . htmlspecialchars($this->formatStripeAmount($total, $currency), ENT_QUOTES, 'UTF-8') . '</td></tr></tfoot>'
            . '</table>'
            . '<p style="margin-top:18px;color:#666;">ID sessione Stripe: ' . htmlspecialchars($sessionId, ENT_QUOTES, 'UTF-8') . '</p>'
            . '</div>';

        $this->sendEmail($to, 'Riepilogo del tuo ordine', $html, 'Impossibile inviare il recap ordine');
    }

    private function sendEmail(string $to, string $subject, string $html, string $errorPrefix): void
    {
        if ($this->apiKey === '') {
            throw new RuntimeException('Configurazione Resend mancante: imposta RESEND_API_KEY.');
        }

        $payload = json_encode([
            'from' => $this->from,
            'to' => [$to],
            'subject' => $subject,
            'html' => $html,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        if ($payload === false) {
            throw new RuntimeException('Impossibile preparare il payload e-mail.');
        }

        $ch = curl_init('https://api.resend.com/emails');
        if ($ch === false) {
            throw new RuntimeException('Impossibile inizializzare cURL.');
        }

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json',
            ],
            CURLOPT_TIMEOUT => 20,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => 0,
        ]);

        $raw = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($raw === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('Errore di rete con Resend: ' . $error);
        }

        curl_close($ch);

        if ($status < 200 || $status >= 300) {
            $body = json_decode($raw, true);
            $message = $body['message'] ?? ($raw ?: 'Invio e-mail fallito.');
            throw new RuntimeException($errorPrefix . ': ' . $message);
        }
    }

    private function formatStripeAmount(int $amount, string $currency): string
    {
        return number_format($amount / 100, 2, ',', '.') . ' ' . strtoupper($currency);
    }
}
