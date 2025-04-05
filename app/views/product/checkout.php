<?php include 'app/views/shares/header.php'; ?>

<div class="container mt-4">
    <h1 class="text-center">Thanh Toán</h1>

    <!-- Form thanh toán -->
    <form method="POST" action="/webbanhang/Product/processCheckout" class="mt-4">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Họ tên:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="text" id="phone" name="phone" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="address">Địa chỉ:</label>
            <textarea id="address" name="address" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Nút thanh toán -->
        <button type="submit" class="btn btn-success btn-block">Thanh toán</button>
    </form>

    <!-- Quay lại giỏ hàng -->
    <a href="/webbanhang/Product/cart" class="btn btn-secondary btn-block mt-2">Quay lại giỏ hàng</a>
</div>

<?php include 'app/views/shares/footer.php'; ?>
