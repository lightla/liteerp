<?php

namespace Tests\Unit;

use Core\ActivityLog\Application\UseCases\CreateActivityLog;
use Core\CustomerGroup\Application\DTOs\CreateCustomerGroupRequest;
use Core\CustomerGroup\Application\UseCases\CreateCustomerGroup;
use Core\CustomerGroup\Domain\Entities\CustomerGroup;
use Core\CustomerGroup\Domain\Services\CustomerGroupService;
use Tests\TestCase;
use Mockery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class CreateCustomerGroupTest extends TestCase
{
    protected $serviceMock;
    protected $activityLogMock;
    protected $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        Event::fake();
        DB::shouldReceive('beginTransaction')->andReturn(null);
        DB::shouldReceive('commit')->andReturn(null);

        $this->serviceMock = Mockery::mock(CustomerGroupService::class);
        $this->activityLogMock = Mockery::mock(CreateActivityLog::class);
        $this->useCase = new CreateCustomerGroup($this->serviceMock, $this->activityLogMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_creates_customer_group_successfully()
    {
        $dto = new CreateCustomerGroupRequest(
            business_id: 1,
            name: 'VIP Customers',
            created_by: 1,
            id: null
        );

        $customerGroup = new CustomerGroup(
            business_id: 1,
            name: 'VIP Customers',
            id: 1
        );

        $this->serviceMock->shouldReceive('create')
            ->with(Mockery::on(function ($arg) {
                return is_array($arg) &&
                       $arg['business_id'] === 1 &&
                       $arg['name'] === 'VIP Customers';
            }))
            ->andReturn($customerGroup);

        Event::shouldReceive('dispatch')
            ->with('erp.customergroup.create', Mockery::on(function ($arg) {
                return is_array($arg) &&
                       isset($arg['user_id']) &&
                       isset($arg['business_id']) &&
                       $arg['name'] === 'VIP Customers';
            }))
            ->once();

        $result = $this->useCase->handle($dto);

        $this->assertInstanceOf(CustomerGroup::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('VIP Customers', $result->name);
        $this->assertEquals(1, $result->business_id);
    }
}