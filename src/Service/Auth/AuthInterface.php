<?php

namespace Service\Auth;

use Model\User;

interface AuthInterface
{
    public function check(): bool;

    public function getCurrentUser(): User|null;

    public function auth(string $email, string $password);

    public function logout();
}