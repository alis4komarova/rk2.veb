<?php include 'header.php'; ?>
<?php
//все товары для витрины
$result = mysqli_query($conn, "SELECT * FROM products");
$products = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
}
?>

<h1 class="section-title">Наше мороженое</h1>

<div class="view-toggle">
    <button class="view-btn active" data-view="grid">Карточки</button>
    <button class="view-btn" data-view="table">Таблица</button>
</div>

<table class="products-table" id="products-table" style="display: none;">
    <thead>
        <tr>
            <th>Название</th>
            <th>Описание</th>
            <th>Цена</th>
            <th>В наличии</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?php safeEcho($product['name']); ?></td>
            <td><?php safeEcho($product['description']); ?></td>
            <td><?php echo number_format($product['price'], 2); ?> ₽</td>
            <td><?php echo $product['stock']; ?> шт.</td>
            <td>
                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small btn-details">Подробнее</a>
                <?php if(isLoggedIn()): ?>
                    <button class="btn-small btn-cart" 
                            data-product-id="<?php echo $product['id']; ?>"
                            data-product-name="<?php safeEcho($product['name']); ?>">
                        В список
                    </button>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="products-grid" id="products-grid">
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
                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn-small btn-details">Подробнее</a>
                <?php if(isLoggedIn()): ?>
                    <button class="btn-small btn-cart"
                            data-product-id="<?php echo $product['id']; ?>"
                            data-product-name="<?php safeEcho($product['name']); ?>">
                        В список
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if(isLoggedIn()): ?>
<div id="shopping-list" class="shopping-list" style="margin-top: 50px; border-top: 2px dashed #ff66b2; padding-top: 30px;">
    <h2 class="section-title">Мой список покупок</h2>
    <?php
    $user_id = intval($_SESSION['user_id']);
    //данные товара через JOIN
    $list_query = "SELECT sl.id AS entry_id, sl.product_id, p.name, p.price, p.image_url 
                FROM shopping_lists sl 
                JOIN products p ON sl.product_id = p.id 
                WHERE sl.user_id = $user_id 
                ORDER BY sl.id DESC";
    $list_result = mysqli_query($conn, $list_query);
    ?>

    <div id="list-container">
        <?php if($list_result && mysqli_num_rows($list_result) > 0): ?>
            <?php while($item = mysqli_fetch_assoc($list_result)): ?>
            <div class="shopping-list-item" style="display: flex; align-items: center; background: white; margin-bottom: 10px; padding: 15px; border-radius: 15px; justify-content: space-between;">
                <div class="item-info" style="display: flex; align-items: center; gap: 20px;">
                    <img src="images/<?php safeEcho($item['image_url']); ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 10px;">
                    <div>
                        <h4 style="margin: 0;"><?php safeEcho($item['name']); ?></h4>
                        <div class="item-price" style="color: #ff66b2; font-weight: bold;"><?php echo number_format($item['price'], 2); ?> ₽</div>
                    </div>
                </div>
                <div class="item-actions">
                    <button class="btn-remove" data-item-id="<?php echo $item['entry_id']; ?>" style="background: #ff4d4d; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer;">
                        Удалить
                    </button>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-cart" style="text-align: center; padding: 20px; background: #fff; border-radius: 15px;">
                <p>Ваш список пока пуст. Добавьте что-нибудь вкусное!</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>