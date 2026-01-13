</main>
<footer>
    <div class="footer-content">
        <ul class="footer-list">
            <li class="footer-item logo-item">
                <div class="footer-logo">
                    <div class="logo-icon">🍦</div>
                    <h3><?php echo $site_name; ?></h3>
                </div>
            </li>
            
            <li class="footer-item info-item">
                <p>&copy; <?php echo date('Y'); ?> <?php echo $site_name; ?></p>
                <p class="page-generation-time">
                    <?php
                    date_default_timezone_set('Europe/Moscow');
                    echo "Страница сформирована " . date('d.m.Y H:i:s');
                    ?>
                </p>
            </li>
            
            <li class="footer-item contacts-item">
                <ul class="contacts-sublist">
                    <li><i class="fas fa-map-marker-alt"></i> г. Москва, ул. Сладкая, д. 15</li>
                    <li><i class="fas fa-phone"></i> +7 (495) 123-45-67</li>
                    <li><i class="fas fa-envelope"></i> info@icedream.ru</li>
                </ul>
            </li>
        </ul>
    </div>
</footer>
<script src="script.js"></script>
</body>
</html>