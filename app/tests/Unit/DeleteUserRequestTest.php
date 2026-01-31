<?php

namespace Tests\Unit;

use Core\User\Application\DTOs\DeleteUserRequest;
use Tests\TestCase;

class DeleteUserRequestTest extends TestCase
{
    public function test_from_array_creates_dto_correctly()
    {
        $data = [
            'user_id' => 1,
            'business_id' => 123,
            'id' => 2
        ];

        $dto = DeleteUserRequest::fromArray($data);

        $this->assertEquals(1, $dto->created_by);
        $this->assertEquals(123, $dto->business_id);
        $this->assertEquals(2, $dto->id);
    }

    public function test_from_array_with_null_values()
    {
        $data = [];

        $dto = DeleteUserRequest::fromArray($data);

        $this->assertNull($dto->created_by);
        $this->assertNull($dto->business_id);
        $this->assertNull($dto->id);
    }

    public function test_to_array_converts_correctly()
    {
        $dto = new DeleteUserRequest(1, 123, 2);

        $array = $dto->toArray();

        $expected = [
            'created_by' => 1,
            'business_id' => 123,
            'id' => 2
        ];

        $this->assertEquals($expected, $array);
    }
}