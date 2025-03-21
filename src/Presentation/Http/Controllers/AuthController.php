<?php

namespace Core\Presentation\Http\Controllers;

use Core\Application\UseCases\CreateUserUseCase;
use Core\Application\UseCases\GetDetailUserUseCase;
use Core\Application\UseCases\LoginUserUseCase;
use Core\Presentation\Http\Requests\LoginRequest;
use Core\Presentation\Http\Requests\RegisterRequest;
use Core\Presentation\Http\Response\UserDetailResponse;
use Core\Presentation\Http\Response\UserLoginResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;
use Udhuong\LaravelCommon\Presentation\Http\Controllers\Controller;
use Udhuong\LaravelCommon\Presentation\Http\Response\Responder;

class AuthController extends Controller
{
    public function __construct(
        private readonly CreateUserUseCase $createUserUseCase,
        private readonly LoginUserUseCase $loginUserUseCase,
        private readonly GetDetailUserUseCase $getDetailUserUseCase
    ) {
    }

    /**
     * Đăng ký người dùng mới
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws AppException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->createUserUseCase->handle($request->toUser(), $request->get('password'));
        $response = ['id' => $user->id];
        return Responder::success($response, 'Đăng ký thành công');
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
        $user = $this->loginUserUseCase->handle($request->get('email'), $request->get('password'));
        return Responder::success(UserLoginResponse::format($user), 'Đăng nhập thành công');
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
        $id = $request->get('id');
        if (!$id) {
            throw new AppException('Vui lòng truyền id người dùng');
        }

        $user = $this->getDetailUserUseCase->handle($id);
        return Responder::success([UserDetailResponse::format($user)], 'Lấy thông tin người dùng thành công');
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
