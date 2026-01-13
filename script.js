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
    alert(productName + ' добавлено в список!');
}

function removeFromCart(itemId) {
    const item = document.querySelector(`[data-item-id="${itemId}"]`);
    if (item) {
        item.closest('.shopping-list-item').remove();
        alert('Товар удален');
    }
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