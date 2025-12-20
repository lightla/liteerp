<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::routes([
    'middleware' => ['auth:sanctum'],
]);
Broadcast::channel(
    'user.{user_id}.{business_id}',
    function ($user, $user_id, $business_id) {
        return true;
    }
);
