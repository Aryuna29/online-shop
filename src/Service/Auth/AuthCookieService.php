<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function check(): bool
    {
        return isset($_COOKIE['userId']);
    }

    public function getCurrentUser(): User|null
    {
        if ($this->check()) {
            $userId = $_COOKIE['userId'];
            return User::getById($userId);
        } else {
            return null;
        }


    }

    public function auth(string $email, string $password)
    {

        $user = User::getByEmail($email);

        if (!$user) {
            return false;
        } else {
            $passwordDB = $user->getPassword();
            if (password_verify($password, $passwordDB)) {
                setcookie('userId', $user->getId());
                return true;
            } else {
                return false;
            }
        }
    }
    public function logout()
    {
     setcookie('userId', '', time() - 3600, '/');
     unset($_COOKIE['userId']);
    }


}