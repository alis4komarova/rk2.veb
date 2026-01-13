document.addEventListener('DOMContentLoaded', function() {
    const loader = document.querySelector('.loader');
    if (loader) {
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 500);
    }
    
    const viewButtons = document.querySelectorAll('.view-btn');
    const tableView = document.getElementById('products-table');
    const gridView = document.getElementById('products-grid');
    
    if (viewButtons.length && tableView && gridView) {
        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                viewButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                if (this.dataset.view === 'table') {
                    tableView.style.display = 'table';
                    gridView.style.display = 'none';
                } else {
                    tableView.style.display = 'none';
                    gridView.style.display = 'grid';
                }
            });
        });
    }
    
    const cartButtons = document.querySelectorAll('.btn-cart');
    cartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            addToCart(productId, productName);
        });
    });
    
    const removeButtons = document.querySelectorAll('.btn-remove');
    removeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            if (confirm('Удалить товар?')) {
                removeFromCart(itemId);
            }
        });
    });
    
    initCarousel();
});

function addToCart(productId, productName) {
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('product_id', productId);

    fetch('add_to_list.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при отправке запроса');
    });
}

function removeFromCart(itemId) {
    if (!confirm('Удалить товар из списка?')) return;
    
    const formData = new FormData();
    formData.append('action', 'remove');
    formData.append('item_id', itemId);

    fetch('add_to_list.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('Ответ при удалении:', data);
        if (data.success) {
            alert('✅ ' + data.message);
            // Находим и удаляем элемент из DOM
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            if (itemElement) {
                const listItem = itemElement.closest('.shopping-list-item');
                if (listItem) {
                    listItem.remove();
                }
            }
            // Если список стал пустым, показываем сообщение
            const listContainer = document.getElementById('list-container');
            if (listContainer && listContainer.children.length === 0) {
                listContainer.innerHTML = `
                    <div class="empty-cart" style="text-align: center; padding: 20px; background: #fff; border-radius: 15px;">
                        <p>Ваш список пока пуст. Добавьте что-нибудь вкусное!</p>
                    </div>
                `;
            }
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        alert('Ошибка при удалении товара');
    });
}

function initCarousel() {
    const track = document.querySelector('.carousel-track');
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dots = document.querySelectorAll('.dot');
    
    if (!track || slides.length === 0) return;
    
    let currentIndex = 0;
    const slidesToShow = 3;
    
    function updateCarousel() {
        if (slides.length > 0) {
            const slideWidth = slides[0].offsetWidth + 20;
            track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === Math.floor(currentIndex / slidesToShow));
            });
        }
    }
    
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateCarousel();
            }
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (currentIndex < slides.length - slidesToShow) {
                currentIndex++;
                updateCarousel();
            }
        });
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentIndex = index * slidesToShow;
            updateCarousel();
        });
    });
    
    let autoSlide = setInterval(() => {
        if (currentIndex < slides.length - slidesToShow) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    }, 5000);
    
    const carousel = document.querySelector('.carousel-container');
    if (carousel) {
        carousel.addEventListener('mouseenter', () => {
            clearInterval(autoSlide);
        });
        
        carousel.addEventListener('mouseleave', () => {
            autoSlide = setInterval(() => {
                if (currentIndex < slides.length - slidesToShow) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateCarousel();
            }, 5000);
        });
    }
    
    window.addEventListener('resize', updateCarousel);
    updateCarousel();
}