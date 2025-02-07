<?php
function ValidatePassword(array $data): array|null
{
    $errors = [];
    $pdo = new PDO("pgsql:host=postgres; port=5432; dbname=mydb", 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id =:id");
    $stmt->execute(array(":id" => $_SESSION['userId']));
    $user = $stmt->fetch();

$passwordDB = $user['password'];
$oldPassword = $_POST['old_password'];
$newPassword = $_POST['new_password'];
if (password_verify($oldPassword, $passwordDB)) {
    $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = '$newPasswordHash'  WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['userId']]);
} else {
    $errors['oldPassword'] = "Пароль неверный";
}
    return $errors;
}

?>
 <div class="card-e">
            <label for="old_password">Старый пароль:</label>
                <?php if (isset($errors)): ?>
                    <label style="color: brown"> <?php echo $errors;?> </label>
                <?php endif; ?>
            <input name="old_password">
        </div>
            <div class="card-e">
                <label for="old_password">Новый пароль:</label>
                <input name="new_password">
            </div>