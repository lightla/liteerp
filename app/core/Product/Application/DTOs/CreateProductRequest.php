<?php

namespace Core\Product\Application\DTOs;

class CreateProductRequest
{
    
    public function __construct(
        public int $business_id,
        public ?int $category_id = 0,
        public string $sku,
        public string $name,
        public string $unit = 'pcs',
        public ?string $description = null,
        public ?string $image = null,
        public int $created_by,
        public ?int $id = null,
        // attr
        public ?string $color = null,
        public ?int $length = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $expiration_date = null,
        public ?int $weight = null
        
    ) {}
    public static function fromArray(array $data): self
    {
        return new self(
            business_id: (int) $data['business_id'],
            category_id: $data['category_id'] ?? 0,
            sku: $data['sku'],
            name: $data['name'],
            unit: $data['unit'] ?? 'pcs',
            description: $data['description'] ?? null,
            image: $data['image'] ?? null,
            id: $data['id'] ?? null,
            // attr
            color: $data['color'] ?? null,
            length: isset($data['length']) ? (int) $data['length'] : null,
            width: isset($data['width']) ? (int) $data['width'] : null,
            height: isset($data['height']) ? (int) $data['height'] : null,
            expiration_date: $data['expiration_date'] ?? null,
            created_by: $data['user_id'],
        );
    }
    public function toArray(): array
    {
        return [
            'business_id'            => $this->business_id,
            'category_id'            => $this->category_id ?? 0,
            'sku'                    => $this->sku,
            'name'                   => $this->name,
            'unit'                   => $this->unit,
            'description'            => $this->description,
            'image'                  => $this->image,
            'created_by'             => $this->created_by,
            // attr
            'color'                  => $this->color,
            'length'                 => $this->length,
            'width'                  => $this->width,
            'height'                 => $this->height,
            'expiration_date'        => $this->expiration_date,
            'weight'                 => $this->weight,
            'id'    => $this->id
        ];
    }
}
