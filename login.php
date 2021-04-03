<?php
require_once ("init.php");
require_once ("helpers.php");
require_once ("data.php");

$page_content = include_template("login.php");

$layout = include_template("layout.php", [
    "categories" => $categories,
    "page_content" => $page_content,
    "is_auth" => $is_auth,
    "title" => $title,
    "user_name" => $user_name
]);

print($layout);
?>
