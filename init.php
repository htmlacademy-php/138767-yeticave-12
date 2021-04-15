<?php

require_once "config/db.php";

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");
$lots = get_lots_from_db();
$categories = get_categories_from_db();

if (!$link) {
    throw new Exception("No database connection");
}

function get_lots_from_db()
{
    global $link;
    $lots = [];

    $lots_sql = "SELECT
        lot_name,
        lot_id,
        lot_category_id,
        init_price,
        img_url,
        completed,
        name,
        lots.created,
        MAX(bets.price) as current_price
        FROM lots
        JOIN categories ON categories.category_id = lots.lot_category_id
        LEFT JOIN bets ON bets.bet_lot_id = lots.lot_id
        WHERE completed > NOW()
        GROUP BY lots.lot_id
        ORDER BY lots.created DESC;";

    if ($lots_result = mysqli_query($link, $lots_sql)) {
        $lots = mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
    }

    return $lots;
}

function get_categories_from_db()
{
    global $link;
    $categories = [];
    $categories_sql = "SELECT category_id, name, symbol_code FROM categories;";

    if ($categories_result = mysqli_query($link, $categories_sql)) {
        $categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
    }

    return $categories;
}

function get_lot()
{
    global $link;
    $lot_id = filter_input(INPUT_GET, "lot_id");

    if ($lot_id) {
        $lot_sql = "SELECT
            lot_name,
            lot_id,
            lot_category_id,
            init_price,
            img_url,
            completed,
            name,
            description,
            bet_step,
            lots.created,
            IFNULL(MAX(bets.price + lots.bet_step), lots.init_price + lots.bet_step) as current_price
            FROM lots
            JOIN categories ON categories.category_id = lots.lot_category_id
            LEFT JOIN bets ON bets.bet_lot_id = lots.lot_id
            WHERE completed > NOW()
            AND lot_id = " . $lot_id . ";";

        if ($lot_result = mysqli_query($link, $lot_sql)) {
            return mysqli_fetch_all($lot_result, MYSQLI_ASSOC);
        }
    }

    return false;
}

function check_user_email($inputEmail)
{
    global $link;

    $email_sql = "SELECT email FROM users WHERE email = '" . $inputEmail . "';";

    if ($email_result = mysqli_query($link, $email_sql)) {
        return mysqli_fetch_all($email_result, MYSQLI_ASSOC);
    }

    return false;
}
