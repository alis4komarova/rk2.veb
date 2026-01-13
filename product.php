<?php include 'header.php'; ?>
<?php
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    header('Location: shop.php');
    exit();
}
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
if (!$product) {
    header('Location: shop.php');
    exit();
}
?>
<main>
    <div class="product-detail">
        <div>
            <img src="images/<?php safeEcho($product['image_url']); ?>" 
                 alt="<?php safeEcho($product['name']); ?>" 
                 class="product-detail-image">
        </div>
        <div class="product-detail-info">
            <h2><?php safeEcho($product['name']); ?></h2>
            <div class="product-detail-price"><?php echo number_format($product['price'], 2); ?> ₽</div>
            <div class="product-stock">
                В наличии: <?php echo $product['stock']; ?> шт.
            </div>
            <p class="product-detail-description">
                <?php echo nl2br(safeEcho($product['detailed_description'])); ?>
            </p>
            <div class="product-actions-large">
                <div class="product-actions-large">
                    <a href="shop.php" class="btn-large btn-details">Назад в магазин</a>
                    <?php if(isLoggedIn()): ?>
                        <button class="btn-large btn-cart"
                                data-product-id="<?php echo $product['id']; ?>"
                                data-product-name="<?php safeEcho($product['name']); ?>">
                            Добавить в список
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php'; ?>