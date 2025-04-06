<?php
require_once 'CategoryDao.php';

class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDao());
    }
}
?>