<?php 
namespace App\Contracts\Hooks;

interface HookInterface
{
    public static function supports(HookContext $context): bool;

    public function handle(HookContext $context): HookResult;
}
