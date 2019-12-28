<?php
// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

$is_tab = isset($_GET['tab']) ? 0 : 1; //  не помню, что-то связанное с загрузкой по умолчанию

$unique_email = true; // для registration, чтобы при первом запуске компилятор не ругался

$page_name = 'Главная';


// $is_auth - Выбирает зарегистрирован пользователь или нет

 // $is_auth = rand (0, 1);
$is_auth = 1;

$user_name = 'Алексей';
$user_avatar = 'img/user.jpg';

// надо разобраться с вложенным тернарным оператором
// <?php (isset($errors['email'])) ? print ('Введите e-mail') : $errors['unique_email'] == false ? print('Пользователь с таким e-mail уже существует') : print('');?>