<?php

namespace Controllers;

use Model\User;
use Request\LoginRequest;
use Request\ProfileEditedRequest;
use Request\RegistrateRequest;

class UserController extends BaseController
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
       parent::__construct();
    }


    public function getRegistrate()
    {

        if ($this->authService->check()) {
            header('location: /catalog');
        }
        require_once '../Views/registration_form.php';
    }

    public function registrate(RegistrateRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {

            $password = password_hash($request->getPassword(), PASSWORD_DEFAULT);

            $insertData = User::insertByNameEmailPass($request->getName(), $request->getEmail(), $password);
            $result = User::getByEmail($request->getEmail());
            header("Location: http://localhost:81/catalog");
        }

        require_once '../Views/registration_form.php';
    }


    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }

    public function login(LoginRequest $request)
    {
        $errors = $request->validate();

        if (empty($errors)) {
            $result = $this->authService->auth($request->getUsername(), $request->getPassword());

            if (!$result) {
                $errors['username'] = 'логин или пароль указаны неверно';
            } else {
                header("Location: http://localhost:81/catalog");
            }
        }
        require_once '../Views/login_form.php';
    }



    public function profile()
    {

        if ($this->authService->check()) {
            $user = $this->authService->getCurrentUser();

            require_once '../Views/profile_form.php';
        } else {
            header('Location: http://localhost:81/login');
        }
    }


    public function getProfileEdited()
    {
        if ($this->authService->check()) {
            $userId = $this->authService->getCurrentUser();

            $user = User::getById($userId->getId());
            require_once '../Views/FORMeditedProfile.php';
        }
    }

    public function profileEdited(ProfileEditedRequest $request)
    {

        if ($this->authService->check()) {
            $userId = $this->authService->getCurrentUser();

            $user = User::getById($userId->getId());

                $errors = $request->validate();
                if (empty($errors)) {

                    if ($user->getName() !== $request->getName()) {
                        User::updateNameById($userId->getId(), $request->getName());
                    }
                    if ($user->getEmail() !== $request->getEmail()) {
                        User::updateEmailById($userId->getId(), $request->getEmail());
                    }
                    header('Location: http://localhost:81/profile');
                    exit;
                }
            require_once '../Views/FORMeditedProfile.php';
        } else {
            header('Location: http://localhost:81/login');
            exit;
        }
    }


    public function logout()
    {
        $this->authService->logout();
            header("Location: /login");
            exit();
    }


}