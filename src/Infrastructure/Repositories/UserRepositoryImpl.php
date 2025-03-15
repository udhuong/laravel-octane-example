<?php

namespace Core\Infrastructure\Repositories;

use App\Models\User as UserModel;
use Core\Domain\Entities\User;
use Core\Domain\Repositories\UserRepository;
use Core\Infrastructure\Mappers\UserMapper;

class UserRepositoryImpl implements UserRepository
{
    public function findByEmail(string $email): ?User
    {
        $model = UserModel::query()
            ->select(['id', 'name', 'email', 'password', 'created_at'])
            ->where('email', $email)->first();

        if ($model === null) {
            return null;
        }

        $user = UserMapper::toEntity($model->toArray());
        $user->password = $model->password;

        return $user;
    }

    public function findById(int $id): ?User
    {
        $model = UserModel::query()
            ->select(['id', 'name', 'email', 'password', 'created_at'])
            ->find($id);

        if ($model === null) {
            return null;
        }

        return UserMapper::toEntity($model->toArray());
    }

    public function createTokenByUserId(int $id): string
    {
        $model = UserModel::find($id);
        return $model->createToken('auth_token')->plainTextToken;
    }

    public function create(User $user, string $password): int
    {
        $userCreated = UserModel::create([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'password' => $password,
        ]);
        return $userCreated->id;
    }
}
