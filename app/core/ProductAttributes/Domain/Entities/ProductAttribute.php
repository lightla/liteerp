<?php

namespace Core\ProductAttributes\Domain\Entities;

use Carbon\Carbon;

class ProductAttribute
{
    public ?int $id;
    public function __construct(
        public int $category_id,
        public string $key,
        public string $type,
        public string $value,
        public ?string $created_at = null,
        public ?string $updated_at = null
    ) {

    }
    public function toArray(){
        return [
            'key' => $this->key,
            'value' => $this->value,
            'type'  => $this->type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category_id' => $this->category_id
        ];
    }
    public static function fromArray(array $data) : self{
        return new self(

            key: $data['key'],
            type: $data['type'],
            value: $data['value'],
            created_at:  Carbon::now()->toDateTimeString(),
            updated_at: Carbon::now()->toDateTimeString(),
            category_id: $data['category_id']
        );
    }
}