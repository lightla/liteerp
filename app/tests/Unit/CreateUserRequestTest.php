<?php

namespace Tests\Unit;

use Core\User\Application\DTOs\CreateUserRequest;
use Tests\TestCase;

class CreateUserRequestTest extends TestCase
{
    public function test_from_array_creates_dto_correctly()
    {
        $data = [
            'email' => 'test@example.com',
            'user_id' => 1,
            'business_id' => 123,
            'role' => 'admin',
            'id' => 2
        ];

        $dto = CreateUserRequest::fromArray($data);

        $this->assertEquals('test@example.com', $dto->email);
        $this->assertEquals(1, $dto->created_by);
        $this->assertEquals(123, $dto->business_id);
        $this->assertEquals('admin', $dto->role);
        $this->assertEquals(2, $dto->id);
    }

    public function test_from_array_with_null_values()
    {
        $data = [
            'email' => 'test@example.com',
            'role' => 'admin'
        ];

        $dto = CreateUserRequest::fromArray($data);

        $this->assertEquals('test@example.com', $dto->email);
        $this->assertNull($dto->created_by);
        $this->assertNull($dto->business_id);
        $this->assertEquals('admin', $dto->role);
        $this->assertNull($dto->id);
    }

    public function test_to_array_converts_correctly()
    {
        $dto = new CreateUserRequest('test@example.com', 1, 123, 'admin', 2);

        $array = $dto->toArray();

        $expected = [
            'email' => 'test@example.com',
            'created_by' => 1,
            'business_id' => 123,
            'role' => 'admin',
            'id' => 2
        ];

        $this->assertEquals($expected, $array);
    }
}