CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE categories (
    cat_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    symbol_code VARCHAR(255)
);

CREATE TABLE lots (
    lot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP (6),
    lot_name VARCHAR(128),
    lot_gategory INT NOT NULL,
    description VARCHAR(255),
    img_url VARCHAR(255),
    init_price NUMERIC(19, 4),
    date_of_completion TIMESTAMP (6),
    step INT(4)
);

CREATE TABLE bets (
    bet_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP (6),
    price NUMERIC(19, 4),
    bet_user INT NOT NULL,
    bet_lot INT NOT NULL
);

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP(6),
    email VARCHAR(128),
    name VARCHAR(128),
    password VARCHAR(128),
    contacts VARCHAR(128),
    user_lot INT NOT NULL,
    user_bet INT NOT NULL
);

ALTER TABLE lots ADD FOREIGN KEY(lot_gategory) REFERENCES categories(cat_id);
ALTER TABLE bets ADD FOREIGN KEY(bet_user) REFERENCES users(user_id);
ALTER TABLE bets ADD FOREIGN KEY(bet_lot) REFERENCES lots(lot_id);
ALTER TABLE users ADD FOREIGN KEY(user_lot) REFERENCES lots(lot_id);
ALTER TABLE users ADD FOREIGN KEY(user_bet) REFERENCES bets(bet_id);

