<?php

namespace Core\Application\UseCases;

use Core\Domain\Entities\User;
use Core\Domain\Repositories\UserRepository;
use Udhuong\LaravelCommon\Domain\Exceptions\AppException;

class GetDetailUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * Đăng nhập người dùng
     *
     * @param string $id
     * @return User
     * @throws AppException
     */
    public function handle(string $id): User
    {
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new AppException('Đăng nhập thất bại');
        }

        return $user;
    }
}
