<?php

namespace Core\Product\Application\UseCases;

use App\Supports\Hooks\HookAction;
use App\Supports\Hooks\HookContext;
use App\Supports\Hooks\HookDispatcher;
use App\Supports\Hooks\HookPhase;
use App\Supports\Hooks\HookTiming;
use Core\Product\Application\DTOs\CreateProductRequest;
use Core\Product\Application\DTOs\ShowProductRequest;
use Core\Product\Domain\Services\ProductService;
use Illuminate\Support\Facades\Event;

class ShowProduct
{
    public function __construct(private ProductService $service,
    private HookDispatcher $hooks) {}

    public function handle(array $data)
    {
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::BEFORE,
                payload: $data,
                module: 'Product'
            )
        );
        $dto = ShowProductRequest::fromArray($data);
        $show = $this->service->show($dto->toArray());
        $data = $this->hooks->dispatch(
            new HookContext(
                action: HookAction::SHOW,
                phase: HookPhase::RESPONSE,
                timing: HookTiming::AFTER,
                payload: [
                    ...$data,
                    ...$show
                ],
                module: 'Product'
            )
        );
        Event::dispatch("erp.product.show", [
            ...$show,
            'user_id' => $dto->created_by,
            'business_id' => $dto->business_id
        ]);
        return $data;
    }
}