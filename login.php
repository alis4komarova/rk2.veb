<?php include 'header.php'; ?>
<?php
if (isLoggedIn()) {
    header('Location: profile.php');
    exit();
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        header('Location: profile.php');
        exit();
    } else {
        $error = "Неверный email или пароль";
    }
}
?>
<main>
    <div class="form-container">
        <h2 class="form-title">Вход в аккаунт</h2>
        <?php if($error): ?>
            <div style="background: var(--error); color: red; padding: 1rem; border-radius: 10px; margin-bottom: 1.5rem;">
                <?php safeEcho($error); ?>
            </div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn-submit">
                Войти
            </button>
        </form>
        <div class="form-footer">
            <p>Еще нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>