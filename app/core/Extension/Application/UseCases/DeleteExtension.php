<?php

namespace Core\Extension\Application\UseCases;

use App\Jobs\RunCommandJob;
use Core\Extension\Application\DTOs\DeleteExtensionRequest;
use Core\Extension\Domain\Services\ExtensionService;
use Illuminate\Support\Facades\Event;

class DeleteExtension
{
    public function __construct(private ExtensionService $service) {}

    public function handle(array $data)
    {
        Event::dispatch('erp.extension.delete',$data);
        RunCommandJob::dispatch('app:npmbuild');
        $dto = DeleteExtensionRequest::fromArray($data);
        return $this->service->delete($dto->toArray());
    }
}