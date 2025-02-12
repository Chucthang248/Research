<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @group delete
     */
    public function it_deletes_a_user_successfully()
    {
        // Tạo một user để xóa
        $user = User::factory()->create();

        // Gửi yêu cầu DELETE đến endpoint delete
        $response = $this->deleteJson("/api/users/delete/{$user->id}");

        // Kiểm tra phản hồi trả về
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'User deleted',
                 ]);

        // Kiểm tra user không còn trong database
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    /**
     * @test
     * @group delete
     */
    public function it_returns_error_if_user_not_found()
    {
        // Gửi yêu cầu DELETE đến một ID không tồn tại
        $response = $this->deleteJson('/api/users/delete/999');

        // Kiểm tra phản hồi trả về
        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'User not found',
                 ]);
    }
}
