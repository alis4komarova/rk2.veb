<?php include 'header.php'; ?>
<?php
if (isLoggedIn()) {
    header('Location: profile.php');
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Заполните все поля";
    } elseif ($password !== $confirm_password) {
        $error = "Пароли не совпадают";
    } elseif (strlen($password) < 6) {
        $error = "Пароль должен быть не менее 6 символов";
    } else {
        $check_query = "SELECT id FROM users WHERE email = '$email' OR username = '$username'";
        $check_result = mysqli_query($conn, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            $error = "Пользователь уже существует";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
            if (mysqli_query($conn, $insert_query)) {
                $user_id = mysqli_insert_id($conn);
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['email'] = $email;
                header('Location: profile.php');
                exit();
            } else {
                $error = "Ошибка регистрации";
            }
        }
    }
}
?>
<main>
    <div class="form-container">
        <h2 class="form-title">Регистрация</h2>
        <?php if($error): ?>
            <div style="background: var(--error); color: white; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <?php safeEcho($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Имя пользователя</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Подтверждение пароля</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn-submit">
                Зарегистрироваться
            </button>
        </form>
        <div class="form-footer">
            <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>