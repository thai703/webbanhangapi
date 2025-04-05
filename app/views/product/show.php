<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo htmlspecialchars($product->name, ENT_QUOTES, 'UTF-8'); ?></h1>

    <div class="row">
        <div class="col-md-6 mb-4">
            <!-- Hình ảnh sản phẩm -->
            <div class="card shadow-sm border-0">
                <?php if (!empty($product->image)): ?>
                    <img src="/webbanhang/<?php echo htmlspecialchars($product->image, ENT_QUOTES, 'UTF-8'); ?>" alt="Product Image" class="card-img-top" style="max-width: 100%; height: 400px; object-fit: contain;">
                <?php else: ?>
                    <div class="card-body text-center">
                        <p class="text-muted">Không có ảnh sản phẩm.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <!-- Thông tin sản phẩm -->
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body">
                    <h5 class="card-title text-primary">Thông tin sản phẩm</h5>
                    <p class="mb-3"><strong class="text-dark">Giá:</strong> <span class="text-success font-weight-bold"><?php echo number_format($product->price, 0, ',', '.'); ?> VND</span></p>
                    <p class="mb-3"><strong class="text-dark">Mô tả:</strong> <?php echo nl2br(htmlspecialchars($product->description, ENT_QUOTES, 'UTF-8')); ?></p>
                    <p class="mb-3"><strong class="text-dark">Danh mục:</strong> 
                        <?php 
                            if (!empty($product->category_name)) {
                                echo htmlspecialchars($product->category_name, ENT_QUOTES, 'UTF-8');
                            } else {
                                echo '<span class="text-muted">Chưa có danh mục</span>';
                            }
                        ?>
                    </p>
                    
                    <button id="add-to-cart" class="btn btn-success btn-lg btn-block mb-2" data-id="<?php echo $product->id; ?>">Thêm vào giỏ hàng</button>

                    <a href="/webbanhang/Product" class="btn btn-secondary btn-block">Quay lại</a>
                    
                    <div id="cart-message" class="mt-3"></div> <!-- Thông báo khi thêm vào giỏ hàng -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'app/views/shares/footer.php'; ?>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }
</style>

<script>
$(document).ready(function() {
    $("#add-to-cart").click(function() {
        let productId = $(this).data("id");

        $.ajax({
            url: "/webbanhang/api/cart",
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify({ product_id: productId }),
            success: function(response) {
                if (response.message === "Product added to cart") {
                    $("#cart-message").html('<div class="alert alert-success">Đã thêm vào giỏ hàng!</div>');
                } else {
                    $("#cart-message").html('<div class="alert alert-danger">Thêm sản phẩm thất bại!</div>');
                }
            },
            error: function() {
                $("#cart-message").html('<div class="alert alert-danger">Lỗi kết nối, vui lòng thử lại!</div>');
            }
        });
    });
});
</script>
