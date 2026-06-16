<?php

class Product
{
    private ?int $id;
    private string $name;
    private string $subtitle;
    private float $price;
    private string $imagePath;
    private int $type;

    public function __construct(
        ?int $id = null,
        string $name = '',
        string $subtitle = '',
        float $price = 0.0,
        string $imagePath = '',
        int $type = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->subtitle = $subtitle;
        $this->price = $price;
        $this->imagePath = $imagePath;
        $this->type = $type;
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): void { $this->name = $name; }
    public function getSubtitle(): string { return $this->subtitle; }
    public function setSubtitle(string $subtitle): void { $this->subtitle = $subtitle; }
    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): void { $this->price = $price; }
    public function getImagePath(): string { return $this->imagePath; }
    public function setImagePath(string $imagePath): void { $this->imagePath = $imagePath; }
    public function getType(): int { return $this->type; }
    public function setType(int $type): void { $this->type = $type; }

    public static function fromArray(array $data): self
    {
        return new self(
            isset($data['id']) ? (int) $data['id'] : null,
            (string) ($data['name'] ?? ''),
            (string) ($data['subtitle'] ?? ''),
            isset($data['price']) ? (float) $data['price'] : 0.0,
            (string) ($data['image_path'] ?? ''),
            isset($data['type']) ? (int) $data['type'] : 0
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'price' => $this->price,
            'image_path' => $this->imagePath,
            'type' => $this->type,
        ];
    }
}
