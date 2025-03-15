<?php

namespace Core\Application\UseCases;

use Core\Domain\Entities\User;
use Core\Domain\Exceptions\AppException;
use Core\Domain\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * Đăng nhập người dùng
     *
     * @param string $email
     * @param string $password
     * @return User
     * @throws AppException
     */
    public function handle(string $email, string $password): User
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user || !Hash::check($password, $user->password)) {
            throw new AppException('Đăng nhập thất bại');
        }

        $user->token = $this->userRepository->createTokenByUserId($user->id);

        return $user;
    }
}
