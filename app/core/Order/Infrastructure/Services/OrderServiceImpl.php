<?php

namespace Core\Order\Infrastructure\Services;

use App\Exceptions\BadException;
use App\Models\OrderModel;
use Core\Order\Domain\Services\OrderService;
use Core\Order\Domain\Repositories\OrderRepositoryInterface;
use Core\Order\Domain\Entities\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderServiceImpl implements OrderService
{
    public function __construct(private OrderRepositoryInterface $repo) {}

    public function create(array $data): Order
    {
        $entity = Order::fromArray($data);
        if ($entity->order_no) {
            if ($this->repo->findByOrderNo($data)) {
                throw new BadException(__("Order no has been used"));
            }
        } 
        $entity->makeOrderNo();
        return $this->repo->create($entity);
    }
    public function show(array $data): array | BadException
    {
        $row = $this->repo->findByIdWithData($data);
        if (!$row) {
            throw new BadException(__("Not found data"));
        }
        return $row;
    }
    public function index(array $data): array
    {
        return $this->repo->index($data);
    }
    public function findOneById(array $data): Order | BadException
    {
        return $this->repo->findById($data) ?? throw new BadException(__("Not found data"));
    }
    public function update(array $data): Order | BadException
    {
        /**
         * With status: invoiced, shipped, completed
         * This logic update from Invoice, Stock. So if it keep status 
         * mean only data Invoice and Stock is changing. 
         * But logic check order is exists keep implement to sure everything is correctly
         */
        $entity = $this->repo->findById($data);
        if (!$entity) {
            throw new BadException(__("Not found data"));
        }
        /**
         * Check order no exists
         */
        if($entity->order_no !== $data['order_no']) {
            if ($this->repo->findByOrderNo($data)) {
                throw new BadException(__("Order no has been used"));
            }    
        }
        switch ($data['status']) {
            case "pending":
                if (!$entity->isPending()) {
                    throw new BadException(__("Status invalid"));
                }
                $entity->order_no = $data['order_no'] ?? $entity->order_no;
                $entity->note = $data['note'] ?? $entity->note;
                $entity->type = $data['type'] ?? $entity->type;
                $entity->markPending();
                $entity->order_date = $data['order_date'] ?? $entity->order_date;
                $entity->expected_delivery_date = $data['expected_delivery_date'] ?? $entity->expected_delivery_date;
                break;
            case "approved":
                if (!$entity->isPending()) {
                    throw new BadException(__("Status invalid"));
                }
                $entity->markApprove();
                break;
            case "cancelled":
                if (!$entity->isApproved()) {
                    throw new BadException(__("Status invalid"));
                }
                $entity->markCancelled();
                break;
        }
        return $this->repo->update($entity);
    }
}
