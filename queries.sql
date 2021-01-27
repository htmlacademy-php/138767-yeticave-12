CREATE DATABASE yeticave;
USE yeticave;
-- КАТЕГОРИИ
INSERT INTO categories(name)
VALUES("Доски и лыжи"), ("Крепления"), ("Ботинки"), ("Одежда"), ("Инструменты"), ("Разное");


-- ЮЗЕРЫ
INSERT INTO users
SET email = "sidorov@gmail.com", name = 'Andrei', created = NOW(), password = 'lesspassword';
INSERT INTO users
SET email = "lebedev@gmail.com", name = 'Andrei', created = NOW(), password = 'lesspassword';
INSERT INTO users
SET email = "test_user@test.com", name = 'Petr', created = NOW(), password = 'lesspassword';
INSERT INTO users
SET email = "test@test.com", name = 'Masha', created = NOW(), password = 'lesspassword';


-- ТОВАРЫ
-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-08-21",
    "2014 Rossignol District Snowboard",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-1.jpg",
    10999,
    1000,
    (SELECT category_id FROM categories WHERE category_id = 1),
    (SELECT user_id FROM users WHERE user_id = 4)
);

-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-09-25",
    "DC Ply Mens 2016/2017 Snowboard",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-2.jpg",
    159999,
    1000,
    (SELECT category_id FROM categories WHERE category_id = 1),
    (SELECT user_id FROM users WHERE user_id = 3)
);

-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-09-25",
    "Крепления Union Contact Pro 2015 года размер L",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-3.jpg",
    8000,
    500,
    (SELECT category_id FROM categories WHERE category_id = 2),
    (SELECT user_id FROM users WHERE user_id = 2)
);

-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-09-24",
    "Ботинки для сноуборда DC Mutiny Charocal",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-4.jpg",
    10999,
    500,
    (SELECT category_id FROM categories WHERE category_id = 3),
    (SELECT user_id FROM users WHERE user_id = 1)
);

-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-09-25",
    "Куртка для сноуборда DC Mutiny Charocal",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-5.jpg",
    7500,
    500,
    (SELECT category_id FROM categories WHERE category_id = 4),
    (SELECT user_id FROM users WHERE user_id = 1)
);

-- лот с товаром без победителя winner_user_id
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id)
VALUES (
    "2020-09-25",
    "Маска Oakley Canopy",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-6.jpg",
    5400,
    500,
    (SELECT category_id FROM categories WHERE category_id = 6),
    (SELECT user_id FROM users WHERE user_id = 4)
);

-- лот с товаром C победителем
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id, winner_user_id, completed)
VALUES (
    "2020-09-25",
    "Маска Oakley Canopy",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-6.jpg",
    5400,
    500,
    (SELECT category_id FROM categories WHERE category_id = 6),
    (SELECT user_id FROM users WHERE user_id = 4),
    1,
    "2020-09-27"
);

-- лот с товаром C победителем
INSERT INTO lots(created, lot_name, description, img_url, init_price, bet_step, lot_category_id, author_user_id, winner_user_id, completed)
VALUES (
    "2020-09-25",
    "Куртка для сноуборда DC Mutiny Charocal",
    "Subject Women - это лимитированная версия женского сноуборда Salomon Lotus с захватывающей новой графикой!",
    "img/lot-5.jpg",
    7500,
    500,
    (SELECT category_id FROM categories WHERE category_id = 4),
    (SELECT user_id FROM users WHERE user_id = 1),
    2,
    "2020-09-28"
);


-- СТАВКИ на lot_id 2
INSERT INTO bets(created, price, bet_user_id, bet_lot_id)
VALUES (
    "2020-09-25 01:25:00",
    5900,
    (SELECT user_id FROM users WHERE user_id = 1),
    (SELECT lot_id FROM lots WHERE lot_id = 2)
);

INSERT INTO bets(created, price, bet_user_id, bet_lot_id)
VALUES (
    "2020-09-25 07:25:00",
    6400,
    (SELECT user_id FROM users WHERE user_id = 2),
    (SELECT lot_id FROM lots WHERE lot_id = 2)
);

INSERT INTO bets(created, price, bet_user_id, bet_lot_id)
VALUES (
    "2020-09-25 09:25:00",
    6900,
    (SELECT user_id FROM users WHERE user_id = 4),
    (SELECT lot_id FROM lots WHERE lot_id = 2)
);

-- СТАВКИ на lot_id 1
INSERT INTO bets(created, price, bet_user_id, bet_lot_id)
VALUES (
    "2020-09-25 01:25:00",
    5900,
    (SELECT user_id FROM users WHERE user_id = 1),
    (SELECT lot_id FROM lots WHERE lot_id = 1)
);


-- ЗАПРОСЫ НА ПОЛУЧЕНИЕ
-- получить все категории
SELECT name FROM categories;

-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, текущую цену, название категории
SELECT
    lot_name,
    init_price,
    img_url,
    (SELECT MAX(price) FROM bets WHERE bets.bet_lot_id = lots.lot_id) AS current_price,
    (SELECT name FROM categories WHERE lots.lot_category_id = categories.category_id) AS category,
    completed
    FROM lots
    WHERE completed IS NULL;

-- вариант с JOIN
SELECT
    lot_name,
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
    ORDER BY lots.created DESC;

-- показать лот по его id. Получите также название категории, к которой принадлежит лот
SELECT
    lot_name,
    (SELECT name FROM categories WHERE lots.lot_category_id = categories.category_id) as category
    FROM lots
    WHERE lot_id = 1;

-- вариант с JOIN
SELECT
    lot_name,
    name
    FROM lots
    JOIN categories ON lots.lot_category_id = categories.category_id
    WHERE lot_id = 1;


-- обновить название лота по его идентификатору
UPDATE lots SET lot_name = "new lot name" WHERE lot_id = 1;

-- получить список ставок для лота по его идентификатору с сортировкой по дате
SELECT * FROM bets WHERE bet_lot_id = 1 ORDER BY created;
