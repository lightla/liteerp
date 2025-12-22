<?php

namespace Core\ActivityLog\Infrastructure\Repositories;

use App\Models\ActivityLogModel;
use Core\ActivityLog\Domain\Repositories\ActivityLogRepositoryInterface;
use Core\ActivityLog\Domain\Entities\ActivityLog;

class EloquentActivityLogRepository implements ActivityLogRepositoryInterface
{
    public function create(ActivityLog $entity): ActivityLog
    {
        $create = ActivityLogModel::create($entity->toArray());
        $entity->id = $create['id'];
        return $entity;
    }
    public function index(array $data): array
    {
        return ActivityLogModel::select("activity_logs.*","users.name as name")
        ->join("users","users.id","=","activity_logs.user_id")
        ->orderBy("activity_logs.id","DESC")
        ->where('activity_logs.business_id',$data['business_id'])
        ->paginate(15)->toArray();
    }
}