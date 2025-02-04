<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // API lấy danh sách tất cả users
    public function getAllUsers()
    {
        // Kiểm tra cache Redis trước
        $users = Cache::remember('users', 60, function () {
            return User::all();
        });

        return response()->json($users);
    }

    // API tạo user mới
    public function registerUser(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Xóa cache (nếu có danh sách user trong Redis)
        Cache::forget('users');

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user,
        ], 201);
    }

    // API xóa user theo ID
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete();

        // Xóa cache để làm mới danh sách users
        Cache::forget('users');

        return response()->json(['message' => 'User deleted'], 200);
    }
}
