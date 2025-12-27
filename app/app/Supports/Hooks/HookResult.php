<?php 
namespace App\Supports\Hooks;

final class HookResult
{
    public function __construct(
        public bool $stop = false,
        public ?array $payload = null
    ) {}

    public static function pass(array $payload): self
    {
        return new self(false, $payload);
    }

    public static function abort(array $payload = []): self
    {
        return new self(true, $payload);
    }
}
