<?php

namespace Core\Ordershipping\Infrastructure\Services;

use App\Exceptions\BadException;
use Core\Ordershipping\Domain\Services\OrderShippingService;
use Core\Ordershipping\Domain\Repositories\OrderShippingRepositoryInterface;
use Core\Ordershipping\Domain\Entities\OrderShipping;
use Illuminate\Support\Facades\Log;

class OrderShippingServiceImpl implements OrderShippingService
{
    public function __construct(private OrderShippingRepositoryInterface $repo) {}

    public function create(array $data): OrderShipping | BadException
    {
        $row = $this->repo->findByOrderId($data);
        if($row) {
            throw new BadException(__("Order shipping used"));
        }
        $entity = OrderShipping::fromArray($data);
        return $this->repo->create($entity);
    }
    public function index(array $data) : array {
        return $this->repo->index($data);
    }
    public function show(array $data): array | BadException
    {
        return $this->repo->findByIdWithFullData($data) ?? throw new BadException(__("Not found data"));
    }
    public function update(array $data): OrderShipping|BadException
    {
        $entity = $this->repo->findById($data);
        if(!$entity) {
            throw new BadException(__("Not found data"));
        }
        $entity->receiver_name = $data['receiver_name'] ?? null;
        $entity->receiver_phone = $data['receiver_phone'] ?? null;
        $entity->receiver_address = $data['receiver_address'] ?? null;
        $entity->receiver_note = $data['receiver_note'] ?? null;
        $entity->preferred_unit  = $data['preferred_unit'] ?? null;
        $entity->shipping_fee_estimated = $data['shipping_fee_estimated'] ?? null;
        $entity->shipping_fee_actual = $data['shipping_fee_actual'] ?? null;
        $entity->shipping_code = $data['shipping_code'] ?? null;
        $entity->shipped_at = $data['shipped_at'] ?? null;
        $entity->delivered_at = $data['delivered_at'] ?? null;
        return $this->repo->update($entity);
    }
    public function findByOrderId(array $data): OrderShipping|BadException
    {
        return $this->repo->findByOrderId($data) 
            ?? throw new BadException(__("Not found data"));
    }
}