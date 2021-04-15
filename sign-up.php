<?php

require_once("init.php");
require_once("helpers.php");
require_once("data.php");
require_once("sign-up-validation.php");
require_once("routes.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];
    $user_post = [
        "email" => FILTER_VALIDATE_EMAIL,
        "password" => FILTER_DEFAULT,
        "name" => FILTER_DEFAULT,
        "message" => FILTER_DEFAULT,
    ];
    $user_sql = "INSERT INTO users SET email = ?, password = ?, name = ?, created = NOW(), message = ?;";

    $user = filter_input_array(INPUT_POST, $user_post);
    $errors = sign_up_validate($user);

    if (in_array(true, $errors)) {
        $page_content = include_template(
            "sign-up.php",
            [
                "categories" => $categories,
                "errors" => $errors,
            ]
        );

        $layout = include_template(
            "layout.php",
            [
                "categories" => $categories,
                "page_content" => $page_content,
                "is_auth" => $is_auth,
                "title" => $title,
                "user_name" => $user_name,
            ]
        );

        print($layout);
        die;
    }
    $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);

    $res = set_data_to_db($link, $user_sql, $user);

    if ($res) {
        header("Location: " . get_url_login_page());
    }
}

$page_content = include_template("sign-up.php");

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


