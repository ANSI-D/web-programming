<?php

require_once __DIR__ . "/BaseDao.class.php";

class CategoryDao extends BaseDao {
    public function __construct() {
        parent::__construct("categories");
    } 

    public function addCategory($category) {
        return $this->insert("categories", $category);
    }    

    public function getCategories() {
        $query = "SELECT * 
        FROM categories";

        return $this->query($query, []);
    }

    public function getCategoryByID($category_id) {
        $query = "SELECT * 
        FROM categories
        WHERE id = :id";

        return $this->query_unique($query, [
            "id" => $category_id
        ]);
    }

    public function deleteCategory($category_id) {
        $query = "DELETE FROM categories WHERE id = :id";
        $this->execute($query, [
            'id' => $category_id
        ]);
    }

    public function editCategory($category_id, $category) {
        $query = "UPDATE categories SET name = :name, description = :description WHERE id = :id";        $this->execute($query, [
            'id' => $category_id,
            'name' => $category['name'],
            'description' => $category['description']
            
        ]);
    }
}

?>