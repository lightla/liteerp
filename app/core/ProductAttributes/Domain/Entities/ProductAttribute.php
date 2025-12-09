<?php

namespace Core\ProductAttributes\Domain\Entities;

class ProductAttribute
{
    public ?int $id;
    public function __construct(
        public int $product_id,
        public array $data
    ) {

    }
    public function toArray(){
        return [
            'product_id' => $this->product_id,
            'data' => $this->data
        ];
    }
}