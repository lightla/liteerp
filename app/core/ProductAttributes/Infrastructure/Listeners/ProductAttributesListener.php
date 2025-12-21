<?php

namespace Core\ProductAttributes\Infrastructure\Listeners;

use Core\ProductAttributes\Application\DTOs\CreateProductAttributeRequest;
use Core\ProductAttributes\Application\UseCases\CreateProductAttribute;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class ProductAttributesListener
{
    public function __construct()
    {
        //
    }

    public function handle(CreateProductAttribute $CreateProductAttribute)
    {
        Event::listen('erp.categoryproduct.*', function (string $eventname, array $data)
        use ($CreateProductAttribute) {
            if($eventname === 'erp.categoryproduct.create'
                || $eventname === 'erp.categoryproduct.update') {
                $CreateProductAttribute->handle(CreateProductAttributeRequest::fromArray($data));
            }
        });
    }
}
