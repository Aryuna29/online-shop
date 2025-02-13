<?php
class user
{
    public function getRegistrate()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            header('location: /catalog');
        }
        require_once './form/registration_form.php';
    }
    public function registrate()
    {
        $errors = $this->ValidateRegistrate($_POST);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $passwordRep = $_POST['psw-repeat'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');

            $password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);

            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $result = $stmt->fetch();
            header("Location: http://localhost:81/catalog");
        }

        require_once './form/registration_form.php';
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
                $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $identEmail = $stmt->fetch();
                if ($identEmail > 0) {
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
        require_once './form/login_form.php';
    }

    public function login()
    {

        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {
            $username = $_POST['u'];
            $password = $_POST['p'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute(['email' => $username]);

            $user = $stmt->fetch();

            if ($user === false) {
                $errors['username'] = 'логин или пароль указаны неверно';
            } else {
                $passwordDB = $user['password'];
                if (password_verify($password, $passwordDB)) {
                    session_start();
                    $_SESSION['userId'] = $user['id'];
                    //setcookie('user_id', $user['id']);
                    header("Location: http://localhost:81/catalog");
                } else {
                    $errors['username'] = 'логин или пароль указаны неверно';
                }
            }

        }
        require_once './form/login_form.php';
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
        require_once './form/profile_form.php';
    }
    public function profile()
    {
        session_start();
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->query("SELECT * FROM users WHERE id = '$userId'");
            $user = $stmt->fetch();
            require_once './form/profile_form.php';
        } else {
            header('Location: http://localhost:81/login');
        }
    }


    public function getProfileEdited()
    {
        require_once './form/FORMeditedProfile.php';
    }

    public function profileEdited()
    {

        session_start();
        if (isset($_SESSION['userId'])) {
            $userId = $_SESSION['userId'];
            $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id =:id");
            $stmt->execute(array(":id" => $userId));
            $user = $stmt->fetch();

            if (isset($_POST['submit'])) {
                $errors = $this->validateProfile($_POST);
                if (empty($errors)) {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    if ($user['name'] !== $name) {
                        $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = $userId");
                        $stmt->execute([':name' => $name]);
                    }
                    if ($user['email'] !== $email) {
                        $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = $userId");
                        $stmt->execute([':email' => $email]);
                    }
                    header('Location: http://localhost:81/profile');
                    exit;
                }

            }
            require_once './form/FORMeditedProfile.php';
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
                $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
                $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $stmt->execute(['email' => $email]);
                $user = $stmt->fetch();
                $userId = $_SESSION['userId'];
                if ($user['id'] !== $userId) {
                    $errors['email'] = 'email уже существует';
                }
            }

            return $errors;
       }


}