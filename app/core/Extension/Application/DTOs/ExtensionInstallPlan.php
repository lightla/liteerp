<?php 
namespace Core\Extension\Application\DTOs;

class ExtensionInstallPlan
{
    public function __construct(
        public array $commands, 
        public array $migrations, 
        public array $warnings, 
        public string $directory,
        public bool $install) {
            
        }
}
