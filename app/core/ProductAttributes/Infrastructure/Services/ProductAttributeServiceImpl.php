<?php

namespace Core\ProductAttributes\Infrastructure\Services;

use Carbon\Carbon;
use Core\ProductAttributes\Domain\Entities\ProductAttribute;
use Core\ProductAttributes\Domain\Services\ProductAttributeService;
use Core\ProductAttributes\Domain\Repositories\ProductAttributeRepositoryInterface;
use Illuminate\Support\Facades\Log;

class ProductAttributeServiceImpl implements ProductAttributeService
{
    public function __construct(private ProductAttributeRepositoryInterface $repo) {}

    public function create(array $data): array
    {
        $this->repo->deleteByCategory($data['category_id']);
        $inserts = [];
        foreach($data['attributes'] as $key => $value) {
            $entity = ProductAttribute::fromArray([
                ...$value,
                'category_id' => $data['category_id']
            ]);
            $inserts[$key] = $entity->toArray();
        }
        return $this->repo->create($inserts);
    }
}