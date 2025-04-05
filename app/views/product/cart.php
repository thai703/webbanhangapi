<?php include 'app/views/shares/header.php'; ?>
<h1 class="text-center">🛒 Giỏ hàng</h1>

<?php if (!empty($cart)): ?>
    <ul class="list-group">
        <?php 
        $total = 0; // Khởi tạo biến tổng tiền
        foreach ($cart as $id => $item): 
            $item_total = $item['price'] * $item['quantity']; // Tính tổng tiền cho sản phẩm
            $total += $item_total; // Cộng tổng tiền vào tổng của giỏ hàng
        ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <h2><?php echo htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                    <?php if (!empty($item['image'])): ?>
                        <img src="/webbanhang/<?php echo htmlspecialchars($item['image']); ?>" alt="Product Image" style="max-width: 100px;">
                    <?php endif; ?>
                    <p>Giá: <?php echo number_format($item['price']); ?> VND</p>
                    <p>Số lượng: 
                        <form action="/webbanhang/Product/updateQuantity" method="POST" style="display:inline;">
                            <button type="submit" name="update_quantity" value="decrease_<?php echo $id; ?>" class="btn btn-sm btn-warning">-</button>
                            <?php echo $item['quantity']; ?>
                            <button type="submit" name="update_quantity" value="increase_<?php echo $id; ?>" class="btn btn-sm btn-warning">+</button>
                        </form>
                    </p>
                    <p>Tổng: <?php echo number_format($item_total); ?> VND</p>
                </div>
                <div>
                    <a href="/webbanhang/Product/removeFromCart/<?php echo $id; ?>" class="btn btn-danger">❌ Xóa</a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Hiển thị tổng tiền -->
    <h3 class="mt-4">Tổng tiền: <?php echo number_format($total); ?> VND</h3>

    <a href="/webbanhang/Product/clearCart" class="btn btn-warning mt-2">🗑 Xóa toàn bộ giỏ hàng</a>
    <a href="/webbanhang/Product" class="btn btn-secondary mt-2">🔙 Tiếp tục mua sắm</a>
    <a href="/webbanhang/Product/checkout" class="btn btn-primary mt-2">💳 Thanh Toán</a>

<?php else: ?>
    <p>🛍 Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>

<?php include 'app/views/shares/footer.php'; ?>
