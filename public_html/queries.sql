
-- получить все категории;

SELECT name FROM `categories`;

----------------------------------------------------------------------------------------------------------------
-- получить самые новые, открытые лоты. Каждый лот должен включать название, стартовую цену, ссылку на изображение, цену, количество ставок, название категории;



----------------------------------------------------------------------------------------------------------------
-- показать лот по его id. Получите также название категории, к которой принадлежит лот

SELECT lots.name, categories.name FROM lots
JOIN categories
ON lots.category_id = categories.id
WHERE lots.id = 1;

----------------------------------------------------------------------------------------------------------------
-- обновить название лота по его идентификатору;

UPDATE lots 
SET name = 'UP Ботинки для сноуборда DC Mutiny Charocal' 
WHERE id = 4;

----------------------------------------------------------------------------------------------------------------
-- получить список самых свежих ставок для лота по его идентификатору;

SELECT bets.value, lots.name, bets.creation_time, users.name
FROM lots
JOIN bets
ON bets.lot_id = lots.id
JOIN users
ON users.id = bets.user_id
ORDER BY bets.creation_time DESC;

-- колхозный вариант

SELECT bets.value, lots.name, bets.creation_time, users.name
FROM lots
JOIN bets
JOIN users
ON users.id = bets.user_id
WHERE bets.lot_id = lots.id
ORDER BY bets.creation_time DESC;