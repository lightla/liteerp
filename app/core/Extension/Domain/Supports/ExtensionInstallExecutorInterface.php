<?php 
namespace Core\Extension\Domain\Supports;

use Core\Extension\Application\DTOs\ExtensionInstallPlan;

interface ExtensionInstallExecutorInterface {
    function execute(ExtensionInstallPlan $plan);
}