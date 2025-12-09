<?php

namespace Core\Product\Application\UseCases;

use App\Exceptions\BadException;
use App\Jobs\CreateNotificationJob;
use Core\ActivityLog\Application\DTOs\CreateActivityLogRequest;
use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\CategoryProduct\Application\DTOs\CreateCategoryProductRequest;
use Core\CategoryProduct\Application\UseCases\CreateOrFindCategoryProduct;
use Core\Notifications\Application\DTOs\InsertManyNotificationRequest;
use Core\ProductAttributes\Application\UseCases\CreateProductAttribute;
use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Domain\Services\ProductService;
use Core\PurchaseItem\Application\UseCases\CreatePurchaseItem;
use Core\Purchase\Application\UseCases\FindByIdPurchase;
use Core\Purchase\Application\UseCases\ShowPurchase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class CreateProduct
{
    public function __construct(private ProductService $service, 
    private CreateProductAttribute $createAttribute) {}

    public function handle(CreateProductRequest $dto)
    {
        DB::beginTransaction();
        $create = $this->service->create($dto->toArray());
        Event::dispatch("erp.product.create", [
            ...$create->toArray(),
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        DB::commit();
        return $create;
    }
}
