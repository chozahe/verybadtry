<?php
include 'htmls/index.html';
require_once("Database.php");
require_once("Shortner.php");

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$shortCode = trim($requestPath, '/');
if($shortCode!==''){
    try {
        $shortner = new Shortner();
        $long_url = $shortner->redirect($shortCode);
        echo $long_url;
    }catch (Exception $e){
        echo $e->getMessage();
    }
}
if($_SERVER["REQUEST_METHOD"] == "POST") {
    try{
        $shortner = new Shortner();
        $shortCode = $shortner->short($_POST['url']);
        $shortUrl = "http://".$_SERVER['HTTP_HOST'].'/'.$shortCode;
        echo ("<p>коротки: <a href='$shortUrl'>$shortUrl</a> </p>");
    }catch (Exception $e){
        echo "<p style='color:red'>ошибка:" .$e->getMessage(). "</p>";
    }
}


