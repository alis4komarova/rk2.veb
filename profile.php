<?php include 'header.php'; ?>
<?php
if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM shopping_lists WHERE user_id = $user_id";
$result = mysqli_query($conn, $query);
$orders = [];
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}
?>
<main>
    <h1 class="section-title">Мой профиль</h1>
    <div style="background: white; border-radius: 20px; padding: 3rem;">
        <h3>Привет, <?php safeEcho($_SESSION['username']); ?>!</h3>
        <p>Email: <?php safeEcho($_SESSION['email']); ?></p>
        <h4>Мои заказы: <?php echo count($orders); ?></h4>
        <h4>Мой список покупок</h4>
<?php if(!empty($orders)): ?>
    <ul>
    <?php foreach($orders as $order): 
        $product_query = mysqli_query($conn, "SELECT name FROM products WHERE id = " . $order['product_id']);
        $product = mysqli_fetch_assoc($product_query);
    ?>
        <li><?php echo htmlspecialchars($product['name']); ?> (добавлено: <?php echo $order['added_at']; ?>)</li>
    <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Ваш список покупок пуст</p>
<?php endif; ?>
        <a href="logout.php" style="display: inline-block; margin-top: 1rem; background: #f44336; color: white; padding: 0.8rem 1.5rem; border-radius: 20px; text-decoration: none;">
            Выйти
        </a>
    </div>
</main>
<?php include 'footer.php'; ?>