<?php
require_once "config/db.php";

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    throw new Exception("No database connection");
}

function get_lots_from_db() {
    global $link;
    $lots_sql = "SELECT
    lot_name,
    init_price,
    img_url,
    completed,
    lots.created,
    name,
    MAX(bets.price) as current_price
    FROM lots
    JOIN categories ON categories.category_id = lots.lot_category_id
    LEFT JOIN bets ON bets.bet_lot_id = lots.lot_id
    WHERE completed > NOW()
    GROUP BY lots.lot_id
    ORDER BY lots.created DESC;";
    $lots = [];

    if ($lots_result = mysqli_query($link, $lots_sql)) {
        $lots = mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
    }

    return $lots;
}

function get_categories_from_db() {
    global $link;
    $categories_sql = "SELECT category_id, name, symbol_code FROM categories;";
    $categories = [];

    if ($categories_result = mysqli_query($link, $categories_sql)) {
        $categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
    }

    return $categories;
}
