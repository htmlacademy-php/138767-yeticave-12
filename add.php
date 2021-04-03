<?php
    require_once ("init.php");
    require_once ("helpers.php");
    require_once ("data.php");
    require_once ("add-lot-validation.php");
    require_once ("routes.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $filename = "";
        $errors = [];
        $lot_post = [
            "lot_name" => FILTER_DEFAULT,
            "description" => FILTER_DEFAULT,
            "init_price" => FILTER_DEFAULT,
            "completed" => FILTER_DEFAULT,
            "bet_step" => FILTER_DEFAULT,
            "lot_category_id" => FILTER_VALIDATE_INT,
            "author_user_id" => FILTER_DEFAULT,
        ];
        $lot_sql = 'INSERT INTO lots(created, lot_name, description, init_price, completed, bet_step, lot_category_id, author_user_id, img_url)
            VALUES (
                NOW(),
                ?,
                ?,
                ?,
                ?,
                ?,
                (SELECT category_id FROM categories WHERE category_id = ?),
                (SELECT user_id FROM users WHERE user_id = ?),
                ?
            );';
        $lot = filter_input_array(INPUT_POST, $lot_post);

        $errors = validate_add_lot_form($lot);
        $errors["img_url"] = is_file_form_invalid();

        if (!$errors["img_url"]) {
            $lot["img_url"] = move_file("img_url");
        }
        // временное решение пока нет авторизации пользователя
        $lot["author_user_id"] = 1;

        if (in_array(true, $errors)) {
            $page_content = include_template("add.php", [
                "categories" => $categories,
                "values" => $lot_post,
                "errors" => $errors,
            ]);

            $layout = include_template("layout.php", [
                "categories" => $categories,
                "page_content" => $page_content,
                "is_auth" => $is_auth,
                "title" => $title,
                "user_name" => $user_name,
            ]);

            print($layout);
            die;
        }
        $res = set_data_to_db($link, $lot_sql, $lot);

        if ($res) {
            $lot["lot_id"] = mysqli_insert_id($link);
            header("Location: " . get_url_lot_page($lot));
        }

    }
    $page_content = include_template("add.php", ["categories" => $categories]);

    $layout = include_template("layout.php", [
        "categories" => $categories,
        "page_content" => $page_content,
        "is_auth" => $is_auth,
        "title" => $title,
        "user_name" => $user_name
    ]);

    print($layout);
?>
