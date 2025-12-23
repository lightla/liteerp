<?php

    namespace Core\CustomInvoiceIn\Infrastructure\Events;

use Illuminate\Support\Facades\Event;

    class CustomInvoiceInEvent
    {
        public function __construct()
        {
            //
        }

        public static function handle(string $event, array $data)
        {
            Event::dispatch('erp.custominvoicein.' . $event,[
                ...$data,
                'user_id' => $data['created_by']
            ]);
        }
    }
