<?php

namespace Core\Business\Infrastructure\Services;

use App\Exceptions\BadException;
use Carbon\Carbon;
use Core\Business\Application\DTOs\CreateBusinessRequest;
use Core\Business\Domain\Services\BusinessService;
use Core\Business\Domain\Repositories\BusinessRepositoryInterface;
use Core\Business\Domain\Entities\Business;

class BusinessServiceImpl implements BusinessService
{
    public function __construct(private BusinessRepositoryInterface $repo) {}

    public function create(array $data): Business
    {
        $entity = Business::fromArray($data);
        if($this->repo->checkExists($entity)) {
            throw new \App\Exceptions\BadException(__("Name and address has been used"));
        }
        return $this->repo->create($entity);
    }
    public function index(int $user_id): array
    {
        return $this->repo->index($user_id);
    }
    public function show(array $data): array | BadException
    {
        return $this->repo->findByIdWithFullData($data) ?? throw new BadException(__("Not found business"));
    }
}