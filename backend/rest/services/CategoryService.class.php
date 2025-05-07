<?php

require_once __DIR__ . "/../dao/CategoryDao.class.php";

class CategoryService {
    private $categoryDao;

    public function __construct() {
        $this->categoryDao = new CategoryDao();
    }

    public function addCategory($category) {
        return $this->categoryDao->addCategory($category);
    }

    public function getCategories() {
        $data = $this->categoryDao->getCategories();
        return ["data" => $data];
    }

    public function getCategoryById($category_id) {
        return $this->categoryDao->getCategoryByID($category_id);
    }

    public function deleteCategory($category_id) {
        $this->categoryDao->deleteCategory($category_id);
    }

    public function editCategory($category) {
        $category_id = $category['id'];
        unset($category['id']);

        $this->categoryDao->editCategory($category_id, $category);
    }
}
?>