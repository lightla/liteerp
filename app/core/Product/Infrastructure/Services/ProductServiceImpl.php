<?php

namespace Core\Product\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Product\Domain\Services\ProductService;
use Core\Product\Domain\Repositories\ProductRepositoryInterface;
use Core\Product\Domain\Entities\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductServiceImpl implements ProductService
{
    public function __construct(private ProductRepositoryInterface $repo) {}

    public function create(array $data): Product
    {
        $entity = Product::fromArray($data);
        if ($this->repo->checkExists($entity)) {
            throw new BadException(__("You have a product same sku,warehouse on this ticket. If you wanna update quantity please select option"));
        }
        return $this->repo->create($entity);
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function show(array $data): array | BadException
    {
        return $this->repo->findOneWithFullData($data) ?? throw new BadException(__("Not found product"));
    }
    public function update(array $data): Product
    {
        $entity = $this->repo->findById($data);
        if (!$entity) {
            throw new BadException(__("Not found data for update"));
        }
        $entity->description = $data['description'];
        $entity->image     = $data['image	'] ?? null;
        return $this->repo->update($entity);
    }
}
