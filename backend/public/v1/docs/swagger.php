<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/../../../vendor/autoload.php';
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1'){
   define('BASE_URL', 'http://localhost/danis-pojskic/web-programming/backend');
} else {
   define('BASE_URL', 'https://whattohost-57p29.ondigitalocean.app/backend/');
}
$openapi = \OpenApi\Generator::scan([
   __DIR__ . '/doc_setup.php',
   __DIR__ . '/../../../rest/routes' // may need to be changed
]);
header('Content-Type: application/json');
echo $openapi->toJson();
?>
