<?php

require_once __DIR__ . '/CategoryDao.class.php';

$category_dao = new CategoryDao();


// Add a new category
$new_category = [
    "name" => "Technology",
    "description" => "All about technology and gadgets."
];

$added_category = $category_dao->addCategory($new_category);
print_r($added_category);

// Get all categories
$categories = $category_dao->getCategories();
print_r($categories);

// Get a category by ID
$category_id = $added_category['id'];
$category = $category_dao->getCategoryByID($category_id);
print_r($category);

// Update the category
$updated_category = [
    "name" => "Tech Updates",
    "description" => "Latest updates in technology."
];
$category_dao->editCategory($category_id, $updated_category);
print_r($category_dao->getCategoryByID($category_id));

// Delete the category
$category_dao->deleteCategory($category_id);
print_r($category_dao->getCategories());

?>