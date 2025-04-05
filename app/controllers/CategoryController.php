<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class CategoryController {
    private $db;
    private $categoryModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->categoryModel = new CategoryModel($this->db);
    }

    public function index() {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit();
        }
        $categories = $this->categoryModel->getCategories();
        include __DIR__ . '/../views/category/list.php';
    }

    public function create() {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $this->categoryModel->addCategory($name, $description);
            header('Location: /webbanhang/category');
            exit();
        } else {
            include __DIR__ . '/../views/category/add.php';
        }
    }

    public function edit($id = null) {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit();
        }
        if ($id === null) {
            die('Lỗi: Không có ID danh mục để sửa');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $this->categoryModel->updateCategory($id, $name, $description);
            header('Location: /webbanhang/category');
            exit();
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            include __DIR__ . '/../views/category/edit.php';
        }
    }

    public function delete($id = null) {
        if (!SessionHelper::isAdmin()) {
            echo "Bạn không có quyền truy cập chức năng này.";
            exit();
        }
        if ($id === null) {
            die('Lỗi: Không có ID danh mục để xóa');
        }

        $this->categoryModel->deleteCategory($id);
        header('Location: /webbanhang/category');
        exit();
    }
}
?>