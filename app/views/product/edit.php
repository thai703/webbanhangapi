<?php include 'app/views/shares/header.php'; ?>
<h1>Sửa sản phẩm</h1>
<form id="edit-product-form">
    <input type="hidden" id="id" name="id">
    <div class="form-group">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" class="form-control" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" class="form-control" step="0.01" required>
    </div>
    <div class="form-group">
        <label for="category_id">Danh mục:</label>
        <select id="category_id" name="category_id" class="form-control" required></select>
    </div>
    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
</form>
<a href="/webbanhang/Product/list" class="btn btn-secondary mt-2">Quay lại danh sách sản phẩm</a>
<?php include 'app/views/shares/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    let productId = <?= $editId ?>;

    // Lấy thông tin sản phẩm
    $.getJSON(`/webbanhang/api/product/${productId}`, function (data) {
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        $('#price').val(data.price);
        $('#category_id').val(data.category_id);
    });

    // Lấy danh mục sản phẩm
    $.getJSON('/webbanhang/api/category', function (data) {
        $.each(data, function (index, category) {
            $('#category_id').append($('<option>', { value: category.id, text: category.name }));
        });
    });

    // Xử lý cập nhật sản phẩm
    $('#edit-product-form').submit(function (event) {
        event.preventDefault();
        let jsonData = $(this).serializeArray().reduce((obj, item) => {
            obj[item.name] = item.value;
            return obj;
        }, {});

        $.ajax({
            url: `/webbanhang/api/product/${jsonData.id}`,
            type: 'PUT',
            contentType: 'application/json',
            data: JSON.stringify(jsonData),
            success: function (response) {
                if (response.message === 'Product updated successfully') {
                    window.location.href = '/webbanhang/Product/list';
                } else {
                    alert('Cập nhật sản phẩm thất bại');
                }
            },
            error: function () {
                alert('Lỗi khi gửi dữ liệu!');
            }
        });
    });
});
</script>
