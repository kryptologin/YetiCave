CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT  COLLATE  utf8_general_ci;

USE yeticave;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255) NOT NULL,
    email CHAR(255) NOT NULL UNIQUE,
    password CHAR(255) NOT NULL,
    avatar CHAR(255),
    contacts TEXT NOT NULL,
    creation_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);

INSERT INTO `users` (`id`, `name`, `email`,`password`,`avatar`,`contacts`,`creation_time`) VALUES
(1, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-02-23T15:30:06.342`),
(2, 'Phillip M Dorrough', `us93enz9fuq@meantinc.com`, `topsecret`, `img/M_person (2).jpg`, `4293  Chicago Avenue` ,`2019-04-245T22:42:02.427`),
(3, 'Sandra T Cooley', `sw4i5izyed@fakemailgenerator.net`, `topsecret`, `img/W_person (3).jpg`, `3093  Bolman Court` ,`2019-05-15T18:12:06.331`),
(4, 'Robert', `p59x0dbwhmo@groupbuff.com`, `topsecret`, `img/M_person (4).jpg`, `3639  Langtown Road` ,`2019-03-22T13:18:26.352`),
(5, 'Scotty T Ragan', `m7b59ldpt3p@meantinc.com`, `topsecret`, `img/M_person (5).jpg`, `4508  Sussex Court` ,`2019-03-14T07:11:13.455`);


-- (6, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-05-12T22:30:12.194`),
-- (7, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-03-10T12:32:23.589`),
-- (8, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-02-04T14:18:54.426`),
-- (9, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-09-21T15:19:03.126`),
-- (10, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-08-14T13:32:15.325`),
-- (11, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-07-11T23:19:34.236`),
-- (12, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-05-03T22:15:23.441`),
-- (13, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-07-20T05:02:25.774`),
-- (14, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-02-14T03:32:46.242`),
-- (15, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-03-20T19:25:32.459`),
-- (16, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-08-12T11:32:23.464`),
-- (17, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-05-03T13:36:19.251`),
-- (18, 'Sara', `sara@email.com`, `topsecret`, `img/W_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-08-28T15:32:36.568`),
-- (19, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-03-14T19:32:30.565`),
-- (20, 'Sara', `sara@email.com`, `topsecret`, `img/M_person (1).jpg`, `Marion, 1655 Argonne Street` ,`2019-09-11T21:25:16.882`);


CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name CHAR(255) NOT NULL UNIQUE
);

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Доски и лыжи'),
(2, 'Крепления'),
(3, 'Ботинки'),
(4, 'Одежда'),
(5, 'Инструменты'),
(6, 'Разное');

CREATE TABLE lots (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    name CHAR(255) NOT NULL,
    description TEXT NOT NULL,
    creation_time DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    finish_time DATETIME NOT NULL,
    start_price INT UNSIGNED NOT NULL,
    bet_step INT UNSIGNED NOT NULL,
    image CHAR(255) NOT NULL,
    fav_count INT UNSIGNED NOT NULL,
    winner_id INT UNSIGNED,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (winner_id) REFERENCES users(id)
);

INSERT INTO `lots` (`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id') VALUES
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id'),
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id'),
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id'),
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id'),
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id'),
(`id`, `category_id`, `user_id`, `name`, `description`, `creation_time`, `finish_time`,`start_price`, `bet_step`, `image`, `fav_count`, 'winner_id');

   [
    'name' => '2014 Rossignol District Snowboard',
    'category_id' => 'Доски и лыжи',
    'start_price' => '10999',
    'image' => 'img/lot-1.jpg'
    ],
    [
    'name' => 'DC Ply Mens 2016/2017 Snowboard',
    'category_id' => 'Доски и лыжи',
    'start_price' => '15999',
    'image' => 'img/lot-2.jpg'
    ],
    [
    'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category_id' => 'Крепления',
    'start_price' => '8000',
    'image' => 'img/lot-3.jpg'
    ],
    [
    'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category_id' => 'Ботинки',
    'start_price' => '10999',
    'image' => 'img/lot-4.jpg'
    ],
    [
    'name' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category_id' => 'Одежда',
    'start_price' => '7500',
    'image' => 'img/lot-5.jpg'
    ],
    [
    'name' => 'Маска Oakley Canopy',
    'category_id' => 'Разное',
    'start_price' => '5400',
    'image' => 'img/lot-6.jpg'
    ]
];

CREATE TABLE bets (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    lot_id INT UNSIGNED NOT NULL,
    value INT UNSIGNED NOT NULL,
    creation_time DATETIME DEFAULT  CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (lot_id) REFERENCES lots(id)
);


INSERT INTO `bets` (`id`, `user_id`, `lot_id`, `value`, `creation_time`) VALUES

['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
CREATE FULLTEXT INDEX lot_search ON lots(name, description);
];
