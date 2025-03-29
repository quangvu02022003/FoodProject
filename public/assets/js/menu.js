document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('menuModal');
    const closeBtn = modal.querySelector('.close');
    let currentFoodId = null;

    // Mở modal khi click nút thêm vào menu
    document.querySelectorAll('.btn-add-menu').forEach(button => {
        button.addEventListener('click', function() {
            currentFoodId = this.dataset.foodId;
            modal.style.display = 'block';
        });
    });

    // Đóng modal
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Xử lý khi chọn menu
    document.querySelectorAll('.menu-item').forEach(button => {
        button.addEventListener('click', function() {
            const menuId = this.dataset.menuId;
            
            fetch('/index.php/menus/add-food', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    menu_id: menuId,
                    food_id: currentFoodId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Đã thêm món ăn vào menu!');
                    modal.style.display = 'none';
                } else {
                    alert(data.message || 'Có lỗi xảy ra!');
                }
            });
        });
    });
}); 