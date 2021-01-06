<?php
require_once ("helpers.php");
require_once ("init.php");
require_once ("data.php");

if ($link) {
    $categories_sql = "SELECT category_id, name, symbol_code FROM categories;";
    $lots_sql = "SELECT
    lot_name,
    init_price,
    img_url,
    completed,
    name,
    MAX(bets.price) as current_price
    FROM lots
    JOIN categories ON categories.category_id = lots.lot_category_id
    LEFT JOIN bets ON bets.bet_lot_id = lots.lot_id
    WHERE completed IS NULL
    GROUP BY lots.lot_id
    ORDER BY lots.created DESC;";

    if ($categories_result = mysqli_query($link, $categories_sql)) {
        $categories = mysqli_fetch_all($categories_result, MYSQLI_ASSOC);
    }

    if ($lots_result = mysqli_query($link, $lots_sql)) {
        $lots = mysqli_fetch_all($lots_result, MYSQLI_ASSOC);
    }
}

$is_auth = rand(0, 1);
$page_content = include_template("main.php", ["lots" => $lots, "categories" => $categories]);

$layout = include_template("layout.php", [
    "categories" => $categories,
    "page_content" => $page_content,
    "is_auth" => $is_auth,
    "title" => $title,
    "user_name" => $user_name
]);

print($layout);

