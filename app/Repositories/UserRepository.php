<?php

namespace App\Repositories;

use Doctrine\ORM\EntityRepository;
use App\Entities\User;

class UserRepository extends EntityRepository
{
    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->findOneByEmail($email);

        if ($user && $user->verifyPassword($password)) {
            return $user;
        }

        return null;
    }
}
