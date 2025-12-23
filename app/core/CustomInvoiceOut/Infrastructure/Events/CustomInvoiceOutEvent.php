<?php

    namespace Core\CustomInvoiceOut\Infrastructure\Events;

use Illuminate\Support\Facades\Event;

    class CustomInvoiceOutEvent
    {
        public function __construct()
        {
            //
        }

        public static function handle(string $event, array $data)
        {
            Event::dispatch('erp.custominvoiceout.' . $event,[
                'user_id' => $data['created_by'],
                ...$data
            ]);
        }
    }
