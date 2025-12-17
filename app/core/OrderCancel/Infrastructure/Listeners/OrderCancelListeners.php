<?php 
namespace Core\OrderCancel\Infrastructure\Listeners;

use Core\OrderCancel\Application\DTOs\CreateOrderCancelRequest;
use Core\OrderCancel\Application\UseCases\CreateOrderCancel;
use Illuminate\Support\Facades\Event;

class OrderCancelListeners {
    public function handle(CreateOrderCancel $CreateOrderCancel){
        Event::listen('erp.order.*',function(string $eventName, array $data) use($CreateOrderCancel) {
            if($eventName === 'erp.order.cancelled') {
                $CreateOrderCancel->handle(CreateOrderCancelRequest::fromArray($data));
            }
        });
    }
}