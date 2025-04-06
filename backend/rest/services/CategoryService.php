<?php
require_once '../dao/CategoryDao.php';
require_once 'BaseService.php';


class CategoryService extends BaseService {
    public function __construct() {
        parent::__construct(new CategoryDao());
    }
}
?>