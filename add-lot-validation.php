<?php

function validate_add_lot_form($form_values) {
    $errors = [];

    foreach ($form_values as $key => $value) {
        switch ($key) {
            case "lot_name":
                if (empty($value)) {
                    $errors[$key] = "Введите наименование лота";
                }
                break;
            case "lot_category_id":
                if (empty($value)) {
                    $errors[$key] = "Выберите категорию";
                }
                break;
            case "description":
                if (empty($value)) {
                    $errors[$key] = "Введите описание";
                }
                break;
            case "init_price":
                $errors[$key] = is_init_price_invalid($value);
                break;
            case "bet_step":
                is_bet_step_invalid($value);
                break;
            case "completed":
                $errors[$key] = is_completed_invalid($value);
                break;
        }
    }
    return $errors;
}

function is_input_valid($value) {
    return isset($value) && is_numeric($value);
}

function is_init_price_invalid($value) {
    if (!is_input_valid($value)) {
        return "Введите начальную цену";
    }
    if ((int)$value < 0) {
        return "Цена не может быть меньше нуля или ноль";
    }
    return false;
}

function is_bet_step_invalid($value) {
    if (!is_input_valid($value)) {
        return "Введите шаг ставки";
    }
    if (is_float(+$value) || +$value <= 0) {
        return "Шаг ставки должен быть целым числом и не меньше нуля";
    }
    return false;
}

function is_completed_invalid($value) {
    if (empty($value)) return "Введите дату окончания торгов";

    // проверка формата строки гггг-мм-дд 2012-01-01
    $is_date_format_valid = preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$value);
    $today = date("Y-m-d");
    $d = new DateTime($value);
    $date = $d->format("U");

    if (!$is_date_format_valid) {
        return "Дата должна быть формата гггг-мм-дд";
    }
    if ($is_date_format_valid && $value === $today) {
        return "Дата должна быть больше текущей даты, хотя бы на один день";
    }
    if ($is_date_format_valid && $date <= time()) {
        return "Дата должна не может быть прошедшей";
    }
    return false;
}

function is_file_form_invalid() {
    if (!is_uploaded_file($_FILES["img_url"]["tmp_name"])) return "Загрузите изображение с лотом";

    $allowed_types = ["image/png", "image/jpeg"];
    $allowed_format = ["jpeg", "png", "jpg"];
    $ext = pathinfo($_FILES["img_url"]["name"], PATHINFO_EXTENSION);

    if (in_array(mime_content_type($_FILES["img_url"]["tmp_name"]), $allowed_types)) {
        if (!in_array($ext, $allowed_format)) return "Разрешенные форматы jpeg, jpg, png";

        return false;
    }
}
