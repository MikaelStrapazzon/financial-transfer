<?php

namespace App\services\user;

use App\database\sql\entities\User;
use App\database\sql\repositories\UserRepository;
use App\exceptions\NotFoundException;

class UserCrudService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * @throws NotFoundException
     */
    public function findById(int $id): User
    {
        $user = $this->userRepository->findById($id);
        if ($user === null) {
            throw new NotFoundException("User with id $id not found");
        }

        return $user;
    }

    public function update(User|array $user): void
    {
        // TODO
        $this->validateUser($user);

        $this->userRepository->update($user);
    }

    public function validateUser(User|array $user)
    {
        // TODO
        return true;
    }
}
