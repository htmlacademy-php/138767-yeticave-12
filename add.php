<?php
    require_once ("init.php");
    require_once ("helpers.php");
    require_once ("data.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $required = ["lot_name", "description", "category", "init_price", "completed", "bet_step"];
        $errors = [];

        $lot = filter_input_array(INPUT_POST, [
            "lot_name" => FILTER_DEFAULT,
            "description" => FILTER_DEFAULT,
            "category" => FILTER_DEFAULT,
            "init_price" => FILTER_DEFAULT,
            "completed" => FILTER_DEFAULT,
            "bet_step" => FILTER_DEFAULT,
        ], true);

        foreach ($lot as $key => $value) {
            $is_value_numeric = empty($value) || !is_numeric($value);

            switch ($key) {
                case "lot_name":
                    if (empty($value)) {
                        $errors[$key][] = "Введите наименование лота";
                    }
                case "category":
                    if (empty($value)) {
                        $errors[$key][] = "Выберите категорию";
                    }
                case "description":
                    if (empty($value)) {
                        $errors[$key][] = "Введите описание";
                    }
                case "init_price":
                    if ($is_value_numeric) {
                        $errors[$key][] = "Введите начальную цену";
                    }
                    if ($is_value_numeric && $value < 0) {
                        $errors[$key][] = "Цена не может быть меньше нуля или ноль";
                    }
                case "bet_step":
                    if ($is_value_numeric) {
                        $errors[$key][] = "Введите шаг ставки";
                    }
                    if ($is_value_numeric || is_float($value)) {
                        $errors[$key][] = "Шаг ставки должен быть целым числом";
                    }
                    if ($is_value_numeric && $value < 0) {
                        $errors[$key][] = "Цена не может быть меньше нуля или ноль";
                    }
                case "completed":
                    if (empty($value)) {
                        $errors[$key][] = "Введите дату окончания торгов";
                    } else {
                        // проверка формата строки гггг-мм-дд 2012-01-01
                        $is_date_format_valid = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value);
                        $today = date("Y-m-d");

                        if (!$is_date_format_valid) {
                            $errors[$key][] = "Дата должна быть формата гггг-мм-дд";
                        }
                        if ($is_date_format_valid && $value === $today) {
                            $errors[$key][] = "Дата должна быть больше текущей даты, хотя бы на один день";
                        }
                    }
            }
        }

        if ($errors) {
            $page_content = include_template("add.php", ["categories" => $categories]);

            $layout = include_template("layout.php", [
                "categories" => $categories,
                "page_content" => $page_content,
                "is_auth" => $is_auth,
                "title" => $title,
                "user_name" => $user_name,
                "errors" => $errors
            ]);

            print($layout);
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
