<?php

namespace Core\ProductAttributes\Application\DTOs;

class CreateProductAttributeRequest
{
    public function __construct(
        public int $product_id,
        public array $data
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            product_id: $data['product_id'],
            data: $data['data']
        );
    }
    public function toArray(){
        return [
            'product_id' => $this->data['product_id'],
            'data' => $this->data 
        ];
    }
}