<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .fixed-header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: linear-gradient(90deg, #007bff, #00c4cc);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            z-index: 1000;
        }
        .navbar-brand {
            font-weight: bold;
            color: white !important;
            font-size: 1.5rem;
            transition: color 0.3s;
        }
        .navbar-brand:hover {
            color: #f8f9fa !important;
        }
        .nav-link {
            color: white !important;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        .navbar-toggler {
            border-color: rgba(255, 255, 255, 0.5);
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 0.8)' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        body {
            padding-top: 70px;
            background: #f4f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        .product-image {
            max-width: 100px;
            height: auto;
            border-radius: 5px;
            transition: transform 0.3s;
        }
        .product-image:hover {
            transform: scale(1.1);
        }
        .cart-icon {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-header">
        <a class="navbar-brand" href="#">Quản lý sản phẩm</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="/webbanhang/Product/">Danh sách sản phẩm</a></li>
                <li class="nav-item"><a class="nav-link" href="/webbanhang/Product/add">Thêm sản phẩm</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="/webbanhang/Product/cart">
                        <i class="fas fa-shopping-cart cart-icon"></i> Giỏ hàng 
                        <?php if (!empty($_SESSION['cart'])): ?>
                            (<?= array_sum(array_column($_SESSION['cart'], 'quantity')) ?>)
                        <?php endif; ?>
                    </a>
                </li>
                <li class="nav-item"><a class="nav-link" href="/webbanhang/category/">Quản lý Kho hàng</a></li>

                <!-- Hiển thị tên người dùng nếu có JWT -->
                <li class="nav-item" id="nav-username" style="display: none;">
                    <a class="nav-link"><i class="fas fa-user"></i> <span id="username-display"></span></a>
                </li>

                <li class="nav-item" id="nav-login">
                    <a class="nav-link" href="/webbanhang/account/login"><i class="fas fa-sign-in-alt"></i> Login</a>
                </li>
                <li class="nav-item" id="nav-register">
                    <a class="nav-link" href="/webbanhang/account/register"><i class="fas fa-user-plus"></i> Register</a>
                </li>
                <li class="nav-item" id="nav-logout" style="display: none;">
                    <a class="nav-link" href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Banner -->
    <div class="mt-5">
        <img src="/webbanhang/uploads/banner.jpg" class="img-fluid w-100" alt="Banner">
    </div>

    <div>
    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        function logout() {
            localStorage.removeItem('jwtToken');
            location.href = '/webbanhang/account/login';
        }

        document.addEventListener("DOMContentLoaded", function() {
            const token = localStorage.getItem('jwtToken');
            if (token) {
                document.getElementById('nav-login').style.display = 'none';
                document.getElementById('nav-register').style.display = 'none';
                document.getElementById('nav-logout').style.display = 'block';
                document.getElementById('nav-username').style.display = 'block';

                // Giải mã JWT để lấy tên người dùng
                try {
                    const payload = JSON.parse(atob(token.split('.')[1]));
                    document.getElementById('username-display').textContent = payload.username;
                } catch (e) {
                    console.error("Lỗi giải mã JWT:", e);
                }
            } else {
                document.getElementById('nav-login').style.display = 'block';
                document.getElementById('nav-register').style.display = 'block';
                document.getElementById('nav-logout').style.display = 'none';
                document.getElementById('nav-username').style.display = 'none';
            }
        });
    </script>
</body>
</html>
