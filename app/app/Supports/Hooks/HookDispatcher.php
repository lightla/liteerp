<?php

namespace App\Supports\Hooks;

use App\Contracts\Hooks\HookContext;
use App\Contracts\Hooks\HookInterface;
use App\Contracts\Hooks\HookResult;
use Illuminate\Contracts\Container\Container;

class HookDispatcher
{
    protected iterable $hooks;

    public function __construct(Container $container)
    {
        $this->hooks = $container->tagged('liteerp.hooks');
    }

    /**
     * Dispatch hook theo context
     */
    public function dispatch(HookContext $context): array
    {
        foreach ($this->hooks as $hook) {
            if (! $hook instanceof HookInterface) {
                continue;
            }
            if (! $hook::supports($context)) {
                continue;
            }
            $result = $hook->handle($context);
            if ($result->stop) {
                return $result->payload ?? [];
            }
            if ($result->payload !== null) {
                $context->payload = $result->payload;
            }
        }

        return $context->payload;
    }
}
