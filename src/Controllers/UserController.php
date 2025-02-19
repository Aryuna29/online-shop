<?php

namespace Controllers;
class UserController
{
    public function getRegistrate()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['userId'])) {
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

//            require_once '../Model/User.php';
            $userModel = new \Model\User();
            $insertData = $userModel->insertByNameEmailPass($name, $email, $password);
            $result = $userModel->getByEmail($email);
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
//                require_once '../Model/User.php';
                $userModel = new \Model\User();
                $result = $userModel->getByEmail($email);
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

        if (empty($errors)) {
            $email = $_POST['u'];
            $password = $_POST['p'];
//            require_once '../Model/User.php';
            $userModel = new \Model\User();
            $user = $userModel->getByEmail($email);

            if ($user === false) {
                $errors['username'] = 'логин или пароль указаны неверно';
            } else {
                $passwordDB = $user['password'];
                if (password_verify($password, $passwordDB)) {
                    if (session_status() !== PHP_SESSION_ACTIVE) {
                        session_start();
                    }
                    $_SESSION['userId'] = $user['id'];
                    header("Location: http://localhost:81/catalog");
                } else {
                    $errors['username'] = 'логин или пароль указаны неверно';
                }
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

    public function getProfile()
    {
        require_once '../Views/profile_form.php';
    }

    public function profile()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
//            require_once '../Model/User.php';
            $userModel = new \Model\User();
            $user = $userModel->getById($userId);
            require_once '../Views/profile_form.php';
        } else {
            header('Location: http://localhost:81/login');
        }
    }


    public function getProfileEdited()
    {
        require_once '../Views/FORMeditedProfile.php';
    }

    public function profileEdited()
    {

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
//            require_once '../Model/User.php';
            $userModel = new \Model\User();
            $user = $userModel->getById($userId);

            if (isset($_POST['submit'])) {
                $errors = $this->validateProfile($_POST);
                if (empty($errors)) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    if ($user['name'] !== $name) {
                        $userModel->updateNameById($userId, $name);
                    }
                    if ($user['email'] !== $email) {
                       $userModel->updateEmailById($userId, $email);
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
//            require_once '../Model/User.php';
            $userModel = new \Model\User();
            $user = $userModel->getByEmail($email);
            $userId = $_SESSION['userId'];
            if (!empty($user)) {
                if ($user['id'] !== $userId) {
                    $errors['email'] = 'email уже существует';
                }
            }
        }

        return $errors;
    }

    public function logout()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
            session_unset();
            session_destroy();
            header("Location: /login");
            require_once '../Views/logout.php';
            exit();
    }


}