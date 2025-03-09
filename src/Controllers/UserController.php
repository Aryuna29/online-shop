<?php

namespace Controllers;

use Model\User;
use Service\AuthService;

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

    public function registrate()
    {
        $errors = $this->ValidateRegistrate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-repeat'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $insertData = $this->userModel->insertByNameEmailPass($name, $email, $password);
            $result = $this->userModel->getByEmail($email);
            header("Location: http://localhost:81/catalog");
        }

        require_once '../Views/registration_form.php';
    }

    private function ValidateRegistrate(array $data): array|null
    {
        $errors = [];

        if (isset($data['name'])) {
            $name = $data['name'];
            if (strlen($name) < 2) {
                $errors['name'] = 'Имя должно быть больше 2';
            } elseif (is_numeric($name)) {
                $errors['name'] = 'Имя не должно содержать цифры';
            }
        } else {
            $errors['name'] = 'Имя должно быть заполнено';
        }

        if (isset($data['email'])) {
            $email = $data['email'];
            if (strlen($email) < 3) {
                $errors['email'] = 'email должен быть больше 3 символов';
            } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $errors['email'] = 'email некорректный';
            } else {
                $result = $this->userModel->getByEmail($email);
                if ($result > 0) {
                    $errors['email'] = 'email уже существует';
                }
            }
        } else {
            $errors['email'] = 'email должен быть заполнен';
        }

        if (isset($data['psw'])) {
            $password = $data['psw'];
            if (strlen($password) < 4) {
                $errors['password'] = 'пароль должен быть больше 4 символов';
            }
            $passwordRep = $data['psw-repeat'];
            if ($password !== $passwordRep) {
                $errors['passwordRep'] = 'пароли не совпали';
            }
        } else {
            $errors['password'] = 'пароль должен быть заполнен';
        }

        return $errors;
    }

    public function getLogin()
    {
        require_once '../Views/login_form.php';
    }

    public function login()
    {
        $errors = $this->validateLogin($_POST);
        $email = $_POST['u'];
        $password = $_POST['p'];

        if (empty($errors)) {
            $result = $this->authService->auth($email, $password);

            if (!$result) {
                $errors['username'] = 'логин или пароль указаны неверно';
            } else {
                header("Location: http://localhost:81/catalog");
            }
        }
        require_once '../Views/login_form.php';
    }

    private function validateLogin(array $data): array|null
    {
        $errors = [];
        if (empty($data['u'])) {
            $errors['username'] = 'Логин не заполнен';
        }
        if (empty($data['p'])) {
            $errors['password'] = 'пароль не заполнен';
        }
        return $errors;
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

            $user = $this->userModel->getById($userId->getId());
            require_once '../Views/FORMeditedProfile.php';
        }
    }

    public function profileEdited()
    {


        if ($this->authService->check()) {
            $userId = $this->authService->getCurrentUser();

            $user = $this->userModel->getById($userId->getId());

            if (isset($_POST['submit'])) {
                $errors = $this->validateProfile($_POST);
                if (empty($errors)) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    if ($user->getName() !== $name) {
                        $this->userModel->updateNameById($userId->getId(), $name);
                    }
                    if ($user->getEmail() !== $email) {
                        $this->userModel->updateEmailById($userId->getId(), $email);
                    }
                    header('Location: http://localhost:81/profile');
                    exit;
                }
            }
            require_once '../Views/FORMeditedProfile.php';
        } else {
            header('Location: http://localhost:81/login');
            exit;
        }
    }

    private function validateProfile(array $data): null|array
    {
        $errors = [];
        $name = $data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = 'Имя быть больше 2 символов';
        } elseif (is_numeric($name)) {
            $errors['name'] = 'Имя не должно содержать цифры';
        }
        $email = $data['email'];
        if (strlen($email) < 3) {
            $errors['email'] = 'email должен быть больше 3 символов';
        } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $errors['email'] = 'email некорректный';
        } else {

            $user = $this->userModel->getByEmail($email);
            $userId = $_SESSION['userId'];
            if (!empty($user)) {
                if ($user->getId() !== $userId) {
                    $errors['email'] = 'email уже существует';
                }
            }
        }

        return $errors;
    }

    public function logout()
    {
        $this->authService->logout();
            header("Location: /login");
            exit();
    }


}