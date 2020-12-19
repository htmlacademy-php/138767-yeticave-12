CREATE DATABASE yeticave;
USE yeticave;

CREATE TABLE categories (
    category_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255),
    symbol_code VARCHAR(255)
);

CREATE TABLE lots (
    lot_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP(6),
    lot_name VARCHAR(128),
    lot_category_id INT NOT NULL,
    author_user_id INT NOT NULL,
    winner_user_id INT NOT NULL,
    description VARCHAR(255),
    img_url VARCHAR(255),
    init_price NUMERIC(19, 4),
    completed TIMESTAMP (6),
    bet_step INT(4)
);

CREATE TABLE bets (
    bet_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP(6),
    price NUMERIC(19, 4),
    bet_user_id INT NOT NULL,
    bet_lot_id INT NOT NULL
);

CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created TIMESTAMP(6),
    email VARCHAR(128),
    name VARCHAR(128),
    password VARCHAR(128),
    contacts VARCHAR(128)
);

ALTER TABLE lots ADD FOREIGN KEY(lot_category_id) REFERENCES categories(category_id);
ALTER TABLE lots ADD FOREIGN KEY(author_user_id) REFERENCES users(user_id);
ALTER TABLE lots ADD FOREIGN KEY(winner_user_id) REFERENCES users(user_id);
ALTER TABLE bets ADD FOREIGN KEY(bet_lot_id) REFERENCES lots(lot_id);

CREATE INDEX email ON users(email);
CREATE INDEX created ON bets(created);
CREATE INDEX created ON lots(created);
CREATE INDEX description ON lots(description);
CREATE INDEX lot_name ON lots(lot_name);
CREATE INDEX name ON categories(name);


