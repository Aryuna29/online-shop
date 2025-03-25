<?php

namespace Service\Auth;

use Model\User;

class AuthSessionService implements AuthInterface
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function check(): bool
    {
        $this->startSession();
        return isset($_SESSION['userId']);
    }

    public function getCurrentUser(): User|null
    {
        $this->startSession();
        if ($this->check()) {
            $userId = $_SESSION['userId'];
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
                $this->startSession();
                $_SESSION['userId'] = $user->getId();
                return true;
            } else {
                return false;
            }
        }
    }
    public function logout()
    {
        $this->startSession();
        session_destroy();
    }

    protected function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

}