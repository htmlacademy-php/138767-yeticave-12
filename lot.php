<?php
    require_once "init.php";
    require_once ("helpers.php");
    require_once ("data.php");
    require_once ("init.php");

    $lot = get_lot();

    if (!$lot) {
        $page_content = include_template("404.php");
    } else {
        $page_content = include_template("lot.php", ["lot" => $lot[0]]);
    }

    $page = [
        "categories" => $categories,
        "page_content" => $page_content,
        "is_auth" => $is_auth,
        "title" => $title,
        "user_name" => $user_name
    ];

    $layout = include_template("layout.php", $page);
    print($layout);
?>
