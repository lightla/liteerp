<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_index_users()
    {
        Event::fake();
        $this->withoutMiddleware();
        // Assuming route is defined
        $response = $this->get('/api/business-access/users?business_id=1&user_id=1');
        
        $response->assertStatus(200);
    }

    public function test_create_user_valid_data()
    {
        Event::fake();
        $this->withoutMiddleware();
        $data = [
            'email' => 'test@example.com',
            'role' => 'admin',
            'business_id' => 1,
            'user_id' => 1,
            'name' => 'a',
            'password' => 'adfadf'
        ];

        $response = $this->post('/api/business-access/users', $data);

        $response->assertStatus(400);
    }

    public function test_create_user_invalid_email()
    {
        Event::fake();
        $this->withoutMiddleware();
        $data = [
            'email' => 'invalid-email',
            'role' => 'admin',
            'business_id' => 1,
            'user_id' => 1
        ];

        $response = $this->post('/api/business-access/users', $data);

        $response->assertStatus(302);
    }

    public function test_create_user_invalid_role()
    {
        Event::fake();
        $this->withoutMiddleware();
        $data = [
            'email' => 'test@example.com',
            'role' => 'invalid-role',
            'business_id' => 1,
            'user_id' => 1
        ];

        $response = $this->post('/api/business-access/users', $data);

        $response->assertStatus(302);
    }

    public function test_update_user_invalid()
    {
        Event::fake();
        $this->withoutMiddleware();
        $data = [
            'email' => 'test@example.com',
            'role' => 'manager',
            'business_id' => 1,
            'user_id' => 1
        ];

        $response = $this->put('/api/business-access/users/1', $data);

        $response->assertStatus(400);
    }

    public function test_delete_user_invalid()
    {
        Event::fake();
        $this->withoutMiddleware();
        $response = $this->delete('/api/business-access/users/1?business_id=1&user_id=1');

        $response->assertStatus(400);
    }
}
