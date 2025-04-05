<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/helpers/SessionHelper.php');

class ProductController {
    private $productModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }

    public function index() {
        $products = $this->productModel->getProducts();
        include 'app/views/product/list.php';
    }

    public function show($id) {
        $product = $this->productModel->getProductById($id);
        if ($product) {
            include 'app/views/product/show.php';
        } else {
            echo "Không thấy sản phẩm.";
        }
    }

    public function addToCart($id) {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            return;
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$id])) {
            $_SESSION['cart'][$id]['quantity']++;
        } else {
            $_SESSION['cart'][$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }

        header('Location: /webbanhang/Product/cart');
    }

    public function processCheckout() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }
        // Giữ nguyên logic xử lý checkout
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];

            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "Giỏ hàng trống.";
                return;
            }

            $this->db->beginTransaction();
            try {
                $query = "INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->bindParam(':address', $address);
                $stmt->execute();
                $order_id = $this->db->lastInsertId();

                $cart = $_SESSION['cart'];
                foreach ($cart as $product_id => $item) {
                    $query = "INSERT INTO order_details (order_id, product_id, quantity, price) 
                              VALUES (:order_id, :product_id, :quantity, :price)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':order_id', $order_id);
                    $stmt->bindParam(':product_id', $product_id);
                    $stmt->bindParam(':quantity', $item['quantity']);
                    $stmt->bindParam(':price', $item['price']);
                    $stmt->execute();
                }

                unset($_SESSION['cart']);
                $this->db->commit();
                header('Location: /webbanhang/Product/orderConfirmation');
            } catch (Exception $e) {
                $this->db->rollBack();
                echo "Đã xảy ra lỗi khi xử lý đơn hàng: " . $e->getMessage();
            }
        }
    }

    public function orderConfirmation() {
        include 'app/views/product/orderConfirmation.php';
    }

    public function cart() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        include 'app/views/product/cart.php';
    }

    public function updateQuantity() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        if (isset($_POST['update_quantity'])) {
            $update_action = $_POST['update_quantity'];
            list($action, $id) = explode('_', $update_action);

            if (isset($_SESSION['cart'][$id])) {
                if ($action == 'increase') {
                    $_SESSION['cart'][$id]['quantity']++;
                } elseif ($action == 'decrease' && $_SESSION['cart'][$id]['quantity'] > 1) {
                    $_SESSION['cart'][$id]['quantity']--;
                }
            }
        }

        header('Location: /webbanhang/Product/cart');
        exit();
    }

    public function delete($id) {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit();
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Không tìm thấy sản phẩm.";
            exit();
        }

        $this->productModel->deleteProduct($id);
        header('Location: /webbanhang/Product');
        exit();
    }

    public function removeFromCart($id) {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        if (isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        header('Location: /webbanhang/Product/cart');
    }

    public function clearCart() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        unset($_SESSION['cart']);
        header('Location: /webbanhang/Product/cart');
    }

    public function add() {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            return;
        }

        $categories = (new CategoryModel($this->db))->getCategories();
        include_once 'app/views/product/add.php';
    }

    public function save() {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if ($result) {
                header('Location: /webbanhang/Product');
                exit();
            } else {
                echo "Đã xảy ra lỗi khi thêm sản phẩm.";
            }
        }
    }

    public function update() {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($result) {
                header('Location: /webbanhang/Product');
                exit();
            } else {
                echo "Đã xảy ra lỗi khi cập nhật sản phẩm.";
            }
        }
    }

    public function edit($id) {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            return;
        }

        if ($id === null) {
            die('Lỗi: Không có ID sản phẩm để sửa');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category_id = $_POST['category_id'];
            $image = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $image = $this->uploadImage($_FILES['image']);
            }

            $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);
            header('Location: /webbanhang/Product');
            exit();
        } else {
            $product = $this->productModel->getProductById($id);
            if ($product) {
                $categories = (new CategoryModel($this->db))->getCategories();
                include 'app/views/product/edit.php';
            } else {
                echo "Sản phẩm không tồn tại.";
            }
        }
    }

    private function uploadImage($file) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($file["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($file["tmp_name"]);
        if ($check === false) {
            throw new Exception("File không phải là hình ảnh.");
        }

        if ($file["size"] > 10 * 1024 * 1024) {
            throw new Exception("Hình ảnh có kích thước quá lớn.");
        }

        if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
            throw new Exception("Chỉ cho phép các định dạng JPG, JPEG, PNG và GIF.");
        }

        if (!move_uploaded_file($file["tmp_name"], $target_file)) {
            throw new Exception("Có lỗi xảy ra khi tải lên hình ảnh.");
        }

        return $target_file;
    }

    public function checkout() {
        if (!SessionHelper::isLoggedIn()) {
            header('Location: /webbanhang/account/login');
            exit();
        }

        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            header('Location: /webbanhang/Product/cart');
            exit();
        }

        include 'app/views/product/checkout.php';
    }
}
?>