<?php

namespace Core\Domain\Repositories;

use Core\Domain\Entities\User;

interface UserRepository
{
    /**
     * Tìm người dùng theo email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User;

    /**
     * Tìm người dùng theo id
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User;

    /**
     * Tạo token theo id người dùng
     *
     * @param int $id
     * @return string
     */
    public function createTokenByUserId(int $id): string;

    /**
     * Tạo người dùng mới
     *
     * @param User $user
     * @param string $password
     * @return int
     */
    public function create(User $user, string $password): int;
}
