<?php
require_once 'config.php';
$result = mysqli_query($conn, "SELECT * FROM products");
$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>
<?php include 'header.php'; ?>

<section class="hero">
    <h2>Добро пожаловать в Ice Dream!</h2>
    <p>Самое вкусное мороженое в городе</p>
    <a href="shop.php" class="btn-primary">Перейти в магазин</a>
</section>

<section class="carousel-section">
    <h2 class="section-title">Популярные вкусы</h2>
    
    <div class="carousel-container">
        <div class="carousel-track">
            <?php 
            foreach($products as $product):
                if ($product['id'] < 10):
            ?>
            <div class="carousel-slide">
                <div class="carousel-card">
                    <img src="images/<?php safeEcho($product['image_url']); ?>" 
                         alt="<?php safeEcho($product['name']); ?>" 
                         class="carousel-image">
                    <div class="carousel-info">
                        <h3><?php safeEcho($product['name']); ?></h3>
                        <p><?php safeEcho($product['description']); ?></p>
                        <div class="carousel-price"><?php echo number_format($product['price'], 2); ?> ₽</div>
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small btn-details">
                            Подробнее
                        </a>
                    </div>
                </div>
            </div>
            <?php endif;
        endforeach; ?>
        </div>
        
        <button class="carousel-btn prev-btn">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="carousel-btn next-btn">
            <i class="fas fa-chevron-right"></i>
        </button>
        
        <div class="carousel-dots">
            <?php for($i = 0; $i < ceil(count($products)-1 / 3); $i++): ?>
            <button class="dot <?php echo $i == 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></button>
            <?php endfor; ?>
        </div>
    </div>
</section>

<section class="products-section mobile-only">
    <h2 class="section-title">Все вкусы</h2>
    <div class="products-grid">
        <?php foreach($products as $product): ?>
        <div class="product-card">
            <img src="images/<?php safeEcho($product['image_url']); ?>" 
                 alt="<?php safeEcho($product['name']); ?>" 
                 class="product-image">
            <div class="product-info">
                <h3 class="product-name"><?php safeEcho($product['name']); ?></h3>
                <p><?php safeEcho($product['description']); ?></p>
                <div class="product-price"><?php echo number_format($product['price'], 2); ?> ₽</div>
                <div class="product-actions">
                    <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small btn-details">
                        Подробнее
                    </a>
                    <button class="btn-small btn-cart" 
                            data-product-id="<?php echo $product['id']; ?>"
                            data-product-name="<?php safeEcho($product['name']); ?>">
                        В список
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<?php include 'footer.php'; ?>