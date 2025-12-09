<?php

namespace Core\ProductAttributes\Infrastructure\Services;

use Core\ProductAttributes\Domain\Services\ProductAttributeService;
use Core\ProductAttributes\Domain\Repositories\ProductAttributeRepositoryInterface;
use Core\ProductAttributes\Domain\Entities\ProductAttribute;
use Illuminate\Support\Facades\Log;

class ProductAttributeServiceImpl implements ProductAttributeService
{
    public function __construct(private ProductAttributeRepositoryInterface $repo) {}

    public function create(array $data): ?ProductAttribute
    {
        $allowed = [
            'length',
            'width',
            'height',
            'color',
            'expiration_date',
            'weight'
        ];

        $attr = [];
        $i = 0;
        foreach ($data as $key => $value) {
            if (in_array($key, $allowed, true) && $value) {
                $attr[$i] = [
                    'key' => $key,
                    'value' => $value 
                ];
                $i++;
            }
        }
        Log::info(json_encode($attr));
        if(count($attr) === 0 ) {
            return null;
        }
        $entity = new ProductAttribute(
            product_id: $data['product_id'],
            data: $attr
        );
        return $this->repo->create($entity);
    }
}