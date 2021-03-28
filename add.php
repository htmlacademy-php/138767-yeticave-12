<?php
    require_once ("init.php");
    require_once ("helpers.php");
    require_once ("data.php");
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

        foreach ($lot as $key => $value) {
            $is_value_numeric = isset($value) && is_numeric($value);

            switch ($key) {
                case "lot_name":
                    if (empty($value)) {
                        $errors[$key][] = "Введите наименование лота";
                    }
                    break;
                case "lot_category_id":
                    if (empty($value)) {
                        $errors[$key][] = "Выберите категорию";
                    }
                    break;
                case "description":
                    if (empty($value)) {
                        $errors[$key][] = "Введите описание";
                    }
                    break;
                case "init_price":
                    if (!$is_value_numeric) {
                        $errors[$key][] = "Введите начальную цену";
                    } else {
                        if ((int)$value < 0) {
                            $errors[$key][] = "Цена не может быть меньше нуля или ноль";
                        }
                    }
                    break;
                case "bet_step":
                    if (!$is_value_numeric) {
                        $errors[$key][] = "Введите шаг ставки";
                    } else {
                        if (is_float(+$value) || +$value <= 0) {
                            $errors[$key][] = "Шаг ставки должен быть целым числом и не меньше нуля";
                        }
                    }
                    break;
                case "completed":
                    if (empty($value)) {
                        $errors[$key][] = "Введите дату окончания торгов";
                    } else {
                        // проверка формата строки гггг-мм-дд 2012-01-01
                        $is_date_format_valid = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value);
                        $today = date("Y-m-d");
                        $d = new DateTime($value);
                        $date = $d->format("U");

                        if (!$is_date_format_valid) {
                            $errors[$key][] = "Дата должна быть формата гггг-мм-дд";
                        }
                        if ($is_date_format_valid && $value === $today) {
                            $errors[$key][] = "Дата должна быть больше текущей даты, хотя бы на один день";
                        }
                        if ($is_date_format_valid && $date <= time()) {
                            $errors[$key][] = "Дата должна не может быть прошедшей";
                        }
                    }
                    break;
            }
        }
        if (!is_uploaded_file($_FILES["img_url"]["tmp_name"])) {
            $errors["img_url"][] = "Загрузите изображение с лотом";
        } else {
            $allowed_types = ["image/png", "image/jpeg"];
            $allowed_format = ["jpeg", "png", "jpg"];
            $ext = pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

            if (in_array(mime_content_type($_FILES["img_url"]["tmp_name"]), $allowed_types)) {

                if (!in_array($ext, $allowed_format)) {
                    $errors["img_url"][] = "Разрешенные форматы jpeg, jpg, png";
                } else {
                    $uploaddir = "./uploads/";
                    $filename =  $uploaddir . uniqid() . basename($_FILES["img_url"]["name"]);
                    $lot["img_url"] = $filename;
                }
            }
        }

        // временное решение пока нет авторизации пользователя
        $lot["author_user_id"] = 1;

        if ($errors) {
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
        } else {
            $stmt = db_get_prepare_stmt($link, $lot_sql, $lot);
            $res = mysqli_stmt_execute($stmt);
            move_uploaded_file($_FILES["img_url"]["tmp_name"], $filename);

            if ($res) {
                $lot["lot_id"] = mysqli_insert_id($link);
                header("Location: " . get_url_lot_page($lot));
            }
        }

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
