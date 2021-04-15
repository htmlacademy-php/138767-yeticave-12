<?php

/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date): bool
{
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form(int $number, string $one, string $two, string $many): string
{
    $number = (int)$number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = [])
{
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();
    return $result;
}

/**
 * форматирует сумму и добалявет знак рубля
 *
 * Примеры использования:
 * format_price(12500) // 12 500₽
 * format_price(999) // 999₽
 * format_price(1000) // 1 000₽
 * format_price(1150, "$") // 1 150₽
 *
 * @param int $price цена в виде цифры
 * @param string $label значек валюты
 *
 * @return string цена со знаком
 */
function format_price(int $price, string $label = "₽")
{
    $price_value = ceil($price);

    if ($price_value < 1000) {
        return $price_value . $label;
    } else {
        return number_format($price_value, 0, ',', ' ') . $label;
    }
}

/**
 * вычисляет сколько осталось часов и минут до даты из будущего
 *
 * Примеры использования:
 * get_date_range("2020-08-20") // [10, 27]
 *
 * @param string $date дата в виде "2020-08-20"
 *
 * @return array [10, 27] где 10 - часы, 27 - минуты
 */
function get_date_range($date)
{
    $dt_end = date_create($date);
    $dt_now = date_create("now");
    $dt_diff = date_diff($dt_end, $dt_now);
    $left_time_seconds = date_interval_format($dt_diff, "%S");
    $left_time_hours = floor((strtotime($date) - time()) / 3600);

    $time_lot_expiration = [$left_time_hours, $left_time_seconds];

    return $time_lot_expiration;
}

function show_form_error($errors)
{
    if (!$errors) {
        echo "";
        return;
    }

    foreach ($errors as $error) {
        echo "<span class='form__error'>" . $error . "</span>";
    }
}

function move_file($file)
{
    $uploaddir = "./uploads/";
    $filename = $uploaddir . uniqid() . basename($_FILES[$file]["name"]);
    move_uploaded_file($_FILES[$file]["tmp_name"], $filename);
    return $filename;
}

function set_data_to_db($link, $sql, $data)
{
    $stmt = db_get_prepare_stmt($link, $sql, $data);
    return mysqli_stmt_execute($stmt);
}
