<?php

namespace Core\Application\UseCases;

use Core\Domain\Entities\User;
use Core\Domain\Exceptions\AppException;
use Core\Domain\Repositories\UserRepository;

class CreateUserUseCase
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {
    }

    /**
     * Tạo người dùng mới
     *
     * @param User $user
     * @param string $password
     * @return User
     * @throws AppException
     */
    public function handle(User $user, string $password): User
    {
        $userExist = $this->userRepository->findByEmail($user->email);
        if ($userExist != null) {
            throw new AppException('Email đã tồn tại');
        }
        $user->id = $this->userRepository->create($user, $password);

        return $user;
    }
}
