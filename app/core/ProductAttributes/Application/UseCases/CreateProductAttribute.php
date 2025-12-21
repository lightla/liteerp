<?php

namespace Core\ProductAttributes\Application\UseCases;

use Core\ProductAttributes\Application\DTOs\CreateProductAttributeRequest;
use Core\ProductAttributes\Domain\Services\ProductAttributeService;

class CreateProductAttribute
{
    public function __construct(private ProductAttributeService $service) {}

    public function handle(CreateProductAttributeRequest $dto)
    {
        return $this->service->create($dto->toArray());
    }
}