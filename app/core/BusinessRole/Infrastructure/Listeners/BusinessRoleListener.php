<?php 
namespace Core\BusinessRole\Infrastructure\Listeners;

use Core\BusinessRole\Application\DTOs\CheckRoleBusinessRoleRequest;
use Core\BusinessRole\Application\DTOs\CreateBusinessRoleRequest;
use Core\BusinessRole\Application\DTOs\DeleteBusinessRoleRequest;
use Core\BusinessRole\Application\UseCases\CheckPermissionBusinessRole;
use Core\BusinessRole\Application\UseCases\CreateBusinessRole;
use Core\BusinessRole\Application\UseCases\DeleteBusinessRole;
use Core\BusinessRole\Application\UseCases\UpdateBusinessRole;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;

class BusinessRoleListener {
    public function __construct(private CheckPermissionBusinessRole $checkPermission,
    private CreateBusinessRole $createBusinessRole,
    private UpdateBusinessRole $updateBusinessRole,
    private DeleteBusinessRole $deleteBusinessRole)
    {
        
    }
    public function handle(){
        Event::listen("erp.*.*",function(string $eventName, array $data) {
            /**
             * If is action related about business, so it needed business_id
             * But if no business id, so it will be not action of business
             */
            if(empty($data['business_id'])) {
                return;
            }
            /**
             * If create business system will be keep check role
             * Because role only can check after create business
             * And system only check role related business exists
             */
            if($eventName === 'erp.business.create') {
                return $this->createBusinessRole->handle(CreateBusinessRoleRequest::fromArray($data));
            }
            /**
             * Check permission
             */
            $this->checkPermission->handle(CheckRoleBusinessRoleRequest::fromArray([
                'action' => $eventName,
                ...$data
            ]));
            /**
             * If create / update new user for business, so system need create / update role for user
             */
            if($eventName === 'erp.user.create') {
                $this->createBusinessRole->handle(CreateBusinessRoleRequest::fromArray($data));
            }
            if($eventName === 'erp.user.update') {
                $this->updateBusinessRole->handle(CreateBusinessRoleRequest::fromArray($data));
            }
            if($eventName === 'erp.user.delete') {
                $this->deleteBusinessRole->handle(DeleteBusinessRoleRequest::fromArray($data));
            }
        });
    }
}