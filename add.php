<?php
    require_once ("init.php");
    require_once ("helpers.php");
    require_once ("data.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $required = ["lot_name", "description", "img_url", "category", "init_price", "completed", "bet_step"];
        $errors = [];

        
    } else {
        $page_content = include_template("add.php", ["categories" => $categories]);

        $layout = include_template("layout.php", [
            "categories" => $categories,
            "page_content" => $page_content,
            "is_auth" => $is_auth,
            "title" => $title,
            "user_name" => $user_name
        ]);

        print($layout);
    }
?>
