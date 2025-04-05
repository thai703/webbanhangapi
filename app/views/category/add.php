<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Thêm danh mục</h2>
    <form id="add-category-form">
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Thêm danh mục</button>
        <a href="/webbanhang/category" class="btn btn-secondary">Quay lại danh sách</a>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
$(document).ready(function() {
    $("#add-category-form").submit(function(e) {
        e.preventDefault();
        let formData = {
            name: $("#name").val(),
            description: $("#description").val()
        };

        $.ajax({
            url: "/webbanhang/api/category",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(formData),
            success: function(response) {
                if (response.message === "Category created successfully") {
                    window.location.href = "/webbanhang/category";
                } else {
                    alert("Thêm danh mục thất bại");
                }
            },
            error: function() {
                alert("Có lỗi xảy ra, vui lòng thử lại!");
            }
        });
    });
});
</script>
