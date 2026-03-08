<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use App\Entities\User;
use Flight as F;

class AuthService
{
    private EntityManagerInterface $em;

    public function __construct()
    {
        $this->em = F::em();
    }

    public function login(string $email, string $password): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->authenticate($email, $password)
        ;
    }
}
