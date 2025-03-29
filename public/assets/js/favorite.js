document.addEventListener('DOMContentLoaded', function() {
    // Lấy tất cả các form favorite
    const favoriteForms = document.querySelectorAll('.favorite-form');
    
    favoriteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = form.querySelector('.favorite-btn');
            const icon = button.querySelector('i');
            
            // Gửi request AJAX
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle trạng thái nút
                    button.classList.toggle('active');
                    icon.classList.toggle('far');
                    icon.classList.toggle('fas');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
}); 