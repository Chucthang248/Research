<?php

namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;

class UserRoleTest extends TestCase
{
    /** @test */
    public function it_checks_if_user_is_admin()
    {
        // Setup: Tạo một user với vai trò admin
        $user = User::factory()->create([
            'is_admin' => 1,
        ]);

        // Action: Gọi phương thức isAdmin
        $result = $user->isAdmin();

        // Assertion: Kiểm tra kết quả trả về
        $this->assertTrue($result, 'User should be an admin.');
    }

    // /** @test */
    // public function it_checks_if_user_is_not_admin()
    // {
    //     // Setup: Tạo một user không phải admin
    //     $user = User::factory()->create([
    //         'is_admin' => false,
    //     ]);

    //     // Action: Gọi phương thức isAdmin
    //     $result = $user->isAdmin();

    //     // Assertion: Kiểm tra kết quả trả về
    //     $this->assertFalse($result, 'User should not be an admin.');
    // }
}
