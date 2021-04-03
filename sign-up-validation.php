<?php
require_once ("init.php");

function sign_up_validate($values) {
    $errors = [];

    foreach ($values as $key => $value) {
        switch ($key) {
            case "email":
                if (empty($value)) {
                    $errors[$key][] = "Введите свой email";
                    break;
                }
                if (check_user_email($value)) {
                    $errors[$key][] = "Такой email уже существует";
                    break;
                }
                break;
            case "password":
                if (empty($value)) $errors[$key][] = "Введите пароль";
                break;
            case "name":
                if (empty($value)) $errors[$key][] = "Введите свое имя";
                break;
            case "message":
                if (empty($value)) $errors[$key][] = "Напишите как с вами связаться";
        }
    }

    return $errors;
}
