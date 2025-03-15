<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserLoginResource;
use App\Http\Response\Responder;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Đăng ký người dùng mới
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return Responder::success([
            'id' => $user->id,
        ], 'Đăng ký thành công');
    }

    /**
     * Người dùng đăng nhập
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AppException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw new AppException('Đăng nhập thất bại');
        }

        return Responder::success([
            'token' => $user->createToken('auth_token')->plainTextToken,
            'user' => new UserLoginResource($user),
        ], 'Đăng nhập thành công');
    }

    /**
     * Người dùng chi tiết
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws AppException
     */
    public function detail(Request $request): JsonResponse
    {
        $user = User::where('id', $request->id)->first();

        if (!$user) {
            throw new AppException('Không tìm thấy người dùng');
        }

        return Responder::success([
            new UserLoginResource($user)
        ], 'Lấy thông tin người dùng thành công');
    }

    /**
     * Đăng xuất người dùng
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return Responder::ok('Đăng xuất thành công');
    }
}
