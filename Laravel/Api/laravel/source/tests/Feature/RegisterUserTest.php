<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @group register
     */
    public function it_registers_a_new_user()
    {
        // Mock dữ liệu đầu vào
        $data = [
            'name' => 'John Doe5',
            'email' => 'john5.doe@example.com',
            'password' => 'securepassword',
            'password_confirmation' => 'securepassword',
        ];

        // Gửi yêu cầu POST đến endpoint register
        $response = $this->postJson('/api/users/register', $data);

        // Kiểm tra phản hồi trả về
        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'User registered successfully',
                 ]);

        // Kiểm tra dữ liệu trong database
        $this->assertDatabaseHas('users', [
            'email' => 'john.doe@example.com',
        ]);
    }

    /**
     * @test
     * @group register
     */
    public function it_fails_if_email_is_already_registered()
    {
        // Tạo user trong database
        User::factory()->create([
            'email' => 'john.doe@example.com',
        ]);

        // Mock dữ liệu đầu vào với email đã tồn tại
        $data = [
            'name' => 'Jane Doe',
            'email' => 'john5.doe@example.com',
            'password' => 'securepassword',
            'password_confirmation' => 'securepassword',
        ];

        // Gửi yêu cầu POST đến endpoint register
        $response = $this->postJson('/api/users/register', $data);

        // Kiểm tra phản hồi trả về
        $response->assertStatus(422)
                 ->assertJsonValidationErrors('email');
    }
}

