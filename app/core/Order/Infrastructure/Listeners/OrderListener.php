<?php

namespace Core\Order\Infrastructure\Listeners;

use Core\Order\Application\DTOs\CheckAddOrderItemRequest;
use Core\Order\Application\DTOs\CheckOrderCancelledRequest;
use Core\Order\Application\DTOs\CheckUpdateShippingOrderRequest;
use Core\Order\Application\UseCases\CheckAddOrderItem;
use Core\Order\Application\UseCases\CheckOrderCancelled;
use Core\Order\Application\UseCases\CheckUpdateShippingOrder;
use Illuminate\Support\Facades\Event;

class OrderListener
{
    public function handle(CheckAddOrderItem $CheckAddOrderItem,
        CheckUpdateShippingOrder $CheckUpdateShippingOrder,
        CheckOrderCancelled $CheckOrderCancelled)
    {
        Event::listen(
            'erp.orderitem.*',
            function (string $eventName, array $data) use ($CheckAddOrderItem) {
                if ($eventName === 'erp.orderitem.create') {
                    $CheckAddOrderItem->handle(
                        CheckAddOrderItemRequest::fromArray([
                            'id' => $data['order_id'],
                            'business_id' => $data['business_id'],
                            'user_id' => $data['user_id']
                        ])
                    );
                }
            }
        );
        Event::listen(
            'erp.ordershipping.*',
            function (string $eventName, array $data) use ($CheckUpdateShippingOrder) {
                if ($eventName === 'erp.ordershipping.update') {
                    $CheckUpdateShippingOrder->handle(
                        CheckUpdateShippingOrderRequest::fromArray([
                            'id' => $data['order_id'],
                            'business_id' => $data['business_id'],
                            'user_id' => $data['user_id']
                        ])
                    );
                }
            }
        );
        /**
         * Check order cancelled 
         */
        Event::listen(
            'erp.invoiceout.*',
            function (string $eventName, array $data) use ($CheckOrderCancelled) {
                if ($eventName === 'erp.invoiceout.update'
                    || $eventName === 'erp.invoiceout.create') {
                    $CheckOrderCancelled->handle(
                        CheckOrderCancelledRequest::fromArray([
                            'id' => $data['order_id'],
                            'business_id' => $data['business_id'],
                            'user_id' => $data['user_id']
                        ])
                    );
                }
            }
        );
        Event::listen(
            'erp.invoiceout.*',
            function (string $eventName, array $data) use ($CheckOrderCancelled) {
                if ($eventName === 'erp.invoiceout.update'
                    || $eventName === 'erp.invoiceout.create') {
                    $CheckOrderCancelled->handle(
                        CheckOrderCancelledRequest::fromArray([
                            'id' => $data['order_id'],
                            'business_id' => $data['business_id'],
                            'user_id' => $data['user_id']
                        ])
                    );
                }
            }
        );
        Event::listen(
            'erp.stockmovementout.*',
            function (string $eventName, array $data) use ($CheckOrderCancelled) {
                if ($eventName === 'erp.stockmovementout.update'
                    || $eventName === 'erp.stockmovementout.create') {
                    $CheckOrderCancelled->handle(
                        CheckOrderCancelledRequest::fromArray([
                            'id' => $data['order_id'],
                            'business_id' => $data['business_id'],
                            'user_id' => $data['user_id']
                        ])
                    );
                }
            }
        );
    }
}
