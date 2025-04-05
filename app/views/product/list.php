<?php include 'app/views/shares/header.php'; ?>
<h1 class="text-center mb-4">Danh sách sản phẩm</h1>

<div class="container">
    <a href="/webbanhang/Product/add" class="btn btn-success mb-3" id="add-product-btn" style="display: none;">Thêm sản phẩm mới</a>
    <ul class="list-group" id="product-list"></ul>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    const token = localStorage.getItem('jwtToken');
    if (!token) {
        alert('Vui lòng đăng nhập');
        window.location.href = '/webbanhang/account/login';
        return;
    }

    // Kiểm tra quyền admin
    $.ajax({
        url: '/webbanhang/api/user/me',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function (user) {
            if (user.role === 'admin') {
                $('#add-product-btn').show();
                $('.edit-btn, .delete-btn').show();
            }
        }
    });

    // Lấy danh sách sản phẩm
    $.ajax({
        url: '/webbanhang/api/product',
        headers: { 'Authorization': 'Bearer ' + token },
        success: function (data) {
            $.each(data, function (index, product) {
                $('#product-list').append(`
                    <li class="list-group-item">
                        <h5><a href="/webbanhang/Product/show/${product.id}" class="text-dark">${product.name}</a></h5>
                        <p>${product.description}</p>
                        <p class="text-success">Giá: ${Number(product.price).toLocaleString('vi-VN')} VND</p>
                        <button class="btn btn-danger btn-sm delete-btn" onclick="deleteProduct(${product.id})">Xóa</button>
                    </li>
                `);
            });
        }
    });
});

// Xóa sản phẩm
function deleteProduct(id) {
    if (confirm('Bạn có chắc chắn muốn xóa?')) {
        $.ajax({
            url: `/webbanhang/api/product/${id}`,
            type: 'DELETE',
            success: function () { location.reload(); }
        });
    }
}
</script>
