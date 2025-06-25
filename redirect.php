<?php
require_once 'Database.php';
require_once 'Shortner.php';

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$shortCode = trim($path, '/');

if(!empty($shortCode)){
    try {
        $shortner = new Shortner();
        $fullLink = $shortner->redirect($shortCode);

        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ". $fullLink);
        exit();
    }catch (Exception $e){
        header("HTTP/1.1 404 Not Found");
        echo"ссылка не найдена";
    }
}else {
    header("Location: /");
}

