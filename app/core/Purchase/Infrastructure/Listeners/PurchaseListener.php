<?php

namespace Core\Purchase\Infrastructure\Listeners;

use Core\Purchase\Application\UseCases\CheckForPurchaseCancelled;
use Core\Purchase\Application\UseCases\CheckForPurchaseItem;
use Illuminate\Support\Facades\Event;

class PurchaseListener
{
    public function handle(
        CheckForPurchaseItem $checkForPurchaseItem,
        CheckForPurchaseCancelled $checkForPurchaseCancelled
    ) {
        Event::listen(
            'erp.purchaseitem.*',
            function (string $eventName, array $data) use ($checkForPurchaseItem) {
                if (
                    $eventName === 'erp.purchaseitem.create'
                    || $eventName === 'erp.purchaseitem.update'
                    || $eventName === 'erp.purchaseitem.delete'
                ) {
                    $checkForPurchaseItem->handle([
                        'business_id' => $data['business_id'],
                        'user_id' => $data['user_id'],
                        'id' => $data['purchase_id']
                    ]);
                }
            }
        );
        Event::listen(
            'erp.invoicein.*',
            function (string $eventName, array $data) use ($checkForPurchaseCancelled) {
                if (
                    $eventName === 'erp.invoicein.create'
                    || $eventName === 'erp.invoicein.update'
                ) {
                    $checkForPurchaseCancelled->handle([
                        'business_id' => $data['business_id'],
                        'user_id' => $data['user_id'],
                        'id' => $data['purchase_id']
                    ]);
                }
            }
        );
    }
}
