<?php 
namespace App\Contracts\Hooks;

final class HookAction
{
    public const CREATE = 'create';
    public const UPDATE = 'update';
    public const DELETE = 'delete';
    public const SHOW = 'show';
    public const INDEX  = 'index';
}
