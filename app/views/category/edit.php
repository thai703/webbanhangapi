<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Chỉnh sửa danh mục</h2>
    <form id="edit-category-form">
        <input type="hidden" id="id" name="id" value="<?= $category->id ?>">
        <div class="form-group">
            <label for="name">Tên danh mục</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $category->name ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Mô tả</label>
            <textarea class="form-control" id="description" name="description" required><?= $category->description ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="/webbanhang/category" class="btn btn-secondary">Quay lại danh sách</a>
    </form>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
$(document).ready(function() {
    $("#edit-category-form").submit(function(e) {
        e.preventDefault();
        let categoryId = $("#id").val();
        let formData = {
            name: $("#name").val(),
            description: $("#description").val()
        };

        $.ajax({
            url: `/webbanhang/api/category/${categoryId}`,
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify(formData),
            success: function(response) {
                if (response.message === "Category updated successfully") {
                    window.location.href = "/webbanhang/category";
                } else {
                    alert("Cập nhật danh mục thất bại");
                }
            },
            error: function() {
                alert("Có lỗi xảy ra, vui lòng thử lại!");
            }
        });
    });
});
</script>
