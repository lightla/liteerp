<?php

namespace Core\ProductAttributes\Application\DTOs;

class CreateProductAttributeRequest
{
    public function __construct(
        public int $category_id,
        public array $attributes
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            category_id: $data['category_id'],
            attributes: $data['attributes']
        );
    }
    public function toArray(){
        return [
            'category_id' => $this->category_id,
            'attributes' => $this->attributes 
        ];
    }
}