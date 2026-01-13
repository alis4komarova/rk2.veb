<?php include 'header.php'; ?>
<?php
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$message_sent = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $message_sent = true;
}
?>
<main>
    <div class="form-container">
        <h2 class="form-title">Обратная связь</h2>
        
        <?php if($message_sent): ?>
            <div style="background: #4CAF50; color: white; padding: 1.5rem; border-radius: 10px; margin-bottom: 2rem; text-align: center;">
                <i class="fas fa-check-circle" style="font-size: 2rem; margin-bottom: 1rem;"></i>
                <h3>Спасибо за ваше сообщение!</h3>
                <p>Мы свяжемся с вами в ближайшее время на email: <?php safeEcho($_SESSION['email']); ?></p>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Ваше имя</label>
                <input type="text" value="<?php safeEcho($_SESSION['username']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Ваш email</label>
                <input type="email" value="<?php safeEcho($_SESSION['email']); ?>" disabled>
            </div>
            
            <div class="form-group">
                <label for="message">Ваше сообщение</label>
                <textarea id="message" name="message" required placeholder="Напишите ваше сообщение здесь..." rows="6"></textarea>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i> Отправить сообщение
            </button>
        </form>
    </div>
</main>
<?php include 'footer.php'; ?>