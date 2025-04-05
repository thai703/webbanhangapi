<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h2 class="text-center">Danh sách danh mục</h2>
    <a href="/webbanhang/category/create" class="btn btn-primary mb-3">Thêm danh mục</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên danh mục</th>
                <th>Mô tả</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody id="category-list">
            <!-- Dữ liệu danh mục sẽ được tải bằng jQuery -->
        </tbody>
    </table>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<script>
$(document).ready(function() {
    function loadCategories() {
        $.ajax({
            url: "/webbanhang/api/category",
            type: "GET",
            success: function(categories) {
                let categoryList = $("#category-list");
                categoryList.empty();
                
                categories.forEach(category => {
                    let row = `
                        <tr>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>${category.description}</td>
                            <td>
                                <a href="/webbanhang/category/edit/${category.id}" class="btn btn-warning">Sửa</a>
                                <button class="btn btn-danger delete-btn" data-id="${category.id}">Xóa</button>
                            </td>
                        </tr>
                    `;
                    categoryList.append(row);
                });

                $(".delete-btn").click(function() {
                    let categoryId = $(this).data("id");
                    if (confirm("Bạn có chắc chắn muốn xóa?")) {
                        $.ajax({
                            url: `/webbanhang/api/category/${categoryId}`,
                            type: "DELETE",
                            success: function(response) {
                                if (response.message === "Category deleted successfully") {
                                    loadCategories();
                                } else {
                                    alert("Xóa danh mục thất bại");
                                }
                            },
                            error: function() {
                                alert("Có lỗi xảy ra, vui lòng thử lại!");
                            }
                        });
                    }
                });
            },
            error: function() {
                alert("Không thể tải danh mục, vui lòng thử lại!");
            }
        });
    }

    loadCategories();
});
</script>
