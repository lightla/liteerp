<?php

namespace Core\Inventory\Console;

use Core\OrderItem\Application\UseCases\IndexOrderItem;
use Illuminate\Console\Command;

class CreateStockMovementOutByStockOutId extends Command
{
    protected $signature = 'module:inventory-create-stock-movement-out-by-stock-out-id {id} {business_id}';
    protected $description = 'Command CreateStockMovementOutByStockOutId in module Inventory';

    public function handle(IndexOrderItem $useCase )
    {
        // TODO: Implement logic
        //$this->info("Command CreateStockMovementOutByStockOutId executed successfully.");
        //$this->info($this->argument('id'));
        $data = $useCase->handle([
            'order_id' => $this->argument('id'),
            'business_id' => $this->argument('business_id')
        ]);
        foreach($data['data'] as $key => $value) {
            //echo $value['name'];
            print_r($value);
        }
    }
}