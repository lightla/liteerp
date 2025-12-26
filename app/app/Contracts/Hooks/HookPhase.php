<?php 
namespace App\Contracts\Hooks;

final class HookPhase
{
    public const VALIDATE = 'validate';
    public const RESPONSE = 'response';
    public const UI = 'ui';
}
