<?php

require_once("helpers.php");
require_once("init.php");
require_once("data.php");
require_once("routes.php");

$page_content = include_template("main.php", ["lots" => $lots, "categories" => $categories]);

$layout = include_template(
    "layout.php",
    [
        "categories" => $categories,
        "page_content" => $page_content,
        "is_auth" => $is_auth,
        "title" => $title,
        "user_name" => $user_name
    ]
);

print($layout);

