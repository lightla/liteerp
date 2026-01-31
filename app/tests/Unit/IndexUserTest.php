<?php

namespace Tests\Unit;

use Core\User\Application\UseCases\IndexUser;
use Core\User\Domain\Services\UserService;
use Tests\TestCase;
use Mockery;

class IndexUserTest extends TestCase
{
    protected $serviceMock;
    protected $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->serviceMock = Mockery::mock(UserService::class);
        $this->useCase = new IndexUser($this->serviceMock);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_handle_returns_users()
    {
        $data = [['id' => 1, 'email' => 'test@example.com']];
        $this->serviceMock->shouldReceive('index')->with(['business_id' => 123])->andReturn($data);

        $result = $this->useCase->handle(['business_id' => 123]);

        $this->assertEquals($data, $result);
    }
}