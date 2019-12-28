<?php


// if ($config['enable']) {
//  require_once($config['tpl_path'] . 'main.php');
// }
// else {
//  $error_msg = "Сайт на техническом обслуживании";
//  require_once($config['tpl_path'] . 'off.php');
// }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// подключение к Базе Данных

$servername = "127.0.0.1";
$username = "root";
$password = "qwedsazxc1982MS";
$database = "yeticave";
$connect = mysqli_connect($servername, $username, $password, $database);
// mysqli_query($connect,'SET NAMES utf8'); // если кодировки не соответствуют чтобы привести все к utf8
// if ($connect){
//     print('соединение установленно<br>');
// }
// else 
//     print('Ошибка подключения <br> <b>' . mysqli_connect_error() . '</b>');
// $sql = "UPDATE lots 
// SET name = 'Ботинки для сноуборда DC Mutiny Charocal' 
// WHERE id = 4;"; // Формируем SQL запрос
// $result = mysqli_query($connect, $sql); // Выполненяем запрос (получаем объект результата (указатель))

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Запрос категорий товара

$sql = "SELECT  id, name, name_en  
FROM categories 
ORDER BY id ASC;"; // Формируем SQL запрос
$result = mysqli_query($connect, $sql);  // Выполненяем запрос (получаем объект результата (указатель))
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC); // MYSQLI_ASSOC  - в виде ассоциативного массива   // Преобразуем объект результата в двумерный массив (mysqli_fetch_all всегда возвращает двумерный массив)
// foreach ($rows as $row) {
$categories = $rows;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Запрос для карточек лотов

// сортировка по дате/цене

// значения по умолчанию
$selected_category = "IS NOT NULL";
$equally = '';
$ru_category_name = 'Открытые лоты';
// $sorting_name = ''; // на будущее, если не решу пролему подсветки типа сортировки

    $sort_field = "creation_time";
    $type_of_sorting  =  "DESC";

    if (isset($_GET['tab']) && $_GET['tab'] == 'cheap') { 
        $sort_field = "start_price";
        $type_of_sorting = "ASC";

    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'old') {
        $sort_field = "creation_time";
        $type_of_sorting = "ASC";
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'expensive') {
        $sort_field = "start_price";
        $type_of_sorting = "DESC";
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'new') {
        $sort_field = "creation_time";
        $type_of_sorting = "DESC";
    }
    
    // cортировка по категориям
    else if (isset($_GET['tab']) && $_GET['tab'] == 'boards') {
        $selected_category = "'boards'";
        $equally = '=';
        $ru_category_name = 'Доски и лыжи';
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'attachment') {
        $selected_category = "'attachment'";
        $equally = '=';
        $ru_category_name = 'Крепления';
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'boots') {
        $selected_category = "'boots'";
        $equally = '=';
        $ru_category_name = 'Ботинки';
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'clothing') {
        $selected_category = "'clothing'";
        $equally = '=';
        $ru_category_name = 'Одежда';
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'tools') {
        $selected_category = "'tools'";
        $equally = '=';
        $ru_category_name = 'Инструменты';
    }
    else if (isset($_GET['tab']) && $_GET['tab'] == 'other') {
        $selected_category = "'other'";
        $equally = '=';
        $ru_category_name = 'Разное';
    }



$sql = "SELECT 
 lots.id, 
 lots.name, 
 lots.description, 
 lots.category_id, 
 lots.user_id, 
 lots.creation_time, 
 lots.finish_time,
 lots.start_price, 
 lots.bet_step, 
 lots.image_url, 
 categories.name AS category, 
 categories.name_en AS category_en,
 (
  select bets.value
  from bets
  where bets.lot_id = lots.id
  order by creation_time desc
  limit 1
 ) as value
FROM lots 
INNER JOIN categories ON lots.category_id = categories.id
WHERE categories.name_en " . $equally . " " . $selected_category . " " .  
"ORDER BY lots." . $sort_field . " " . $type_of_sorting . ";"; // Формируем SQL запрос
 // print ('<pre>' . $sql . '</pre>');
$result = mysqli_query($connect, $sql);  // Выполненяем запрос (получаем объект результата (указатель))
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC); // MYSQLI_ASSOC  - в виде ассоциативного массива   // Преобразуем объект результата в двумерный массив (mysqli_fetch_all всегда возвращает двумерный массив)
$lots = $rows;

// SELECT 
//  lots.id, 
//  lots.name, 
//  lots.description, 
//  lots.category_id, 
//  lots.user_id, 
//  lots.creation_time, 
//  lots.finish_time,
//  lots.start_price, 
//  lots.bet_step, 
//  lots.image_url, 
//  categories.name AS category, 
//  categories.name_en AS category_en,
//  (
//   select bets.value
//   from bets
//   where bets.lot_id = lots.id
//   order by creation_time desc
//   limit 1
//  ) as value
// FROM lots 
// INNER JOIN categories ON lots.category_id = categories.id
// WHERE categories.name_en IS NOT NULL 
// ORDER BY lots.creation_time DESC



/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// only_first_word() - Получает дату в формате SQL возвращает разницу с нынешней датой в формате '5д 10ч 37м 52с'

function yetti_time ($sql_finish_time){
    date_default_timezone_set("Europe/Moscow"); 
    $finish_time = strtotime($sql_finish_time); // strtotime приводит строку к unixtime (работает с любыми разделителями)
    $well_time = $finish_time - time(); // получаем разницу между заданной и нынешней датой
    if ($well_time < 0){
        return 'Прием ставок завершен';
    }
    $days = (floor($well_time / (24*60*60))); // < 0); ? floor($well_time / (24*60*60));
    $hours = floor($well_time / 60 / 60 % 24);
    $minutes = floor($well_time / 60 % 60);
    $seconds = $well_time % 60;
    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT); // str_pad () добавляет '0' слева к 1-чному числу
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT); 
    $seconds = str_pad($seconds, 2, '0', STR_PAD_LEFT);
//    var_dump($seconds);
    if ($days < 1){
        return ($hours . 'ч ' . $minutes . 'м ' . $seconds . 'с');
    }
    return ($days . 'д ' . $hours . 'ч ' . $minutes . 'м ' . $seconds . 'с');
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// only_first_word() - Возвращает только 1-е слово из строки

function only_first_word ($string) {
$words = explode(" ", $string);
return $words[0];
}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// divide_price() - Меняет ценник с "15999" на "15 999 ₽"

function divide_price ($price) {
    round($price);
    return number_format($price, 0, '', ' ') . " ₽";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// only_2_rows() - функция, ограничивает строку 70-75 символами, принцип работы не понятен, следует переделать на основе explode() и цикла с защитой от злоумышленников

function only_2_rows ($string) {
    if (strlen($string) < 76){
        return $string;
    }
$string = substr($string, 0, 70);
$string = substr($string, 0, strrpos($string, ' '));
return $string."… ";
}

function only_2_rows_long ($string) {
    if (strlen($string) < 76){
        return $string;
    }
    $string = substr($string, 0, 270);
    $string = substr($string, 0, strrpos($string, ' '));
    return $string."… ";
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// lot_sql() - Запрос на показ конкретного лота

function lot_sql($connect, $lot_id){
    $sql = "SELECT 
    lots.id, 
    lots.name, 
    lots.description, 
    lots.category_id, 
    lots.start_price,
    lots.bet_step, 
    lots.image_url,
    lots.creation_time,
    lots.finish_time, 
    categories.name as category, 
    categories.name_en as category_en
    FROM lots 
    JOIN categories
    ON lots.category_id = categories.id
    WHERE lots.id = " . only_digits($lot_id) . ";"; // Убираем все символы кроме цифр, которые мог внести вручную злоумышленник в URL 
    $result = mysqli_query($connect, $sql);
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    if (empty($rows)){ 
        return 0;
    }
    else{
        $sql = "SELECT 
        bets.user_id,
        bets.value,
        bets.creation_time,
        users.name as user_name,
        users.email as user_email
        FROM bets
        JOIN users
        ON bets.user_id = users.id
        WHERE  bets.lot_id  = " . only_digits($lot_id) . " 
        ORDER BY bets.creation_time DESC;";
 //       print ($sql);
        $result = mysqli_query($connect, $sql);
        $rows[0]['bets'] = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
// print ('<pre>');
// var_dump($rows[0]);
// print ('</pre><br>');
return $rows[0];
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// remaining_time() - Выводит оставшееся время до полуночи

function remaining_time() {
    date_default_timezone_set("Europe/Moscow"); 
    $ts_midnight = strtotime('tomorrow'); // получаем TS для полуночи
    $secs_to_midnight = $ts_midnight - time();
    $hours = floor($secs_to_midnight / 3600);
    $minutes = floor(($secs_to_midnight % 3600) / 60);
    $hours = str_pad($hours, 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($minutes, 2, '0', STR_PAD_LEFT);
    return "$hours:$minutes";
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// templates_render() - функция шаблонизатор

function templates_render ($tmpl, $vars = array()){
    if (file_exists('templates/'.$tmpl.'.tpl.php') ){
        ob_start(); // включаем буферизированный вывод
        extract($vars); // превращает ключи массива в переменные и присваивает им значения ключей
        require ('templates/'.$tmpl.'.tpl.php');
        return ob_get_clean(); // забираем данные из буфера, очищаем его и возвращаем из функиции

    }
    else return ('<h1>error: ' . '<b>templates/' . $tmpl . '.tpl.php</b>' . ' is not available</h1>');
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// only_digits() - функция удаляет из полученой строки все кроме цифр

function only_digits($string){
    return preg_replace("/[^0-9]/", '', $string);
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// // sql_data() - функция возвращает дату в формате 2019-02-23T15:30:06 

function sql_datetime(){
    return date("Y-m-d") . "T" . date("H:i:s");
}






// $headers_keys = [
//     'Язык браузера' => 'ACCEPT_LANGUAGE',
//     'Страница перехода' => 'REFERER',
//     'Поддерживаемый контент' => 'ACCEPT',
//     'Браузер и ОС пользователя' => 'USER_AGENT',
//     'Домен сайта' => 'HOST'
// ];

// header("X-Academy: keks");
// $response_headers = headers_list();
// print_r($response_headers);
// sleep(3);
// header("Location: ../index.php");


// foreach ($_SERVER as $name => $key) {
//         print("<b>$name</b>: $key<br>");
//     }




// SQL Connection failed "Warning: mysqli_connect(): (HY000/2002): Connection refused"

//  mysqli_connect('127.0.0.1', 'id10743467_my1php', 'absolutely correct password', 'id10743467_my1php');

// All data is correct, I enter phpmyadmin without problems. I deleted and re-created the database, changed the password in the settings, every time I get Warning: mysqli_connect (): (HY000/2002): Connection refused
// Please help to solve the problem!


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// // lot_bool_sql() - функция запрос к базе данных, использовалась до изучения сессий
/*
function lot_bool_sql($connect, $type_of_query){
    $sql_select = "SELECT  
    lot_bool
    FROM temp
    WHERE id = 1";  

    $sql_insert = "
    UPDATE temp
    SET lot_bool = " . $type_of_query . " 
    WHERE id = 1";
    print ('<b> sql_insert = </b>' . $sql_insert . '<br>');
    
    if ($type_of_query == 0 || $type_of_query == 1) {
        print ('<b> if type_of_query = </b>' . $type_of_query . '<br>');
        $sql = $sql_insert;
        print ('<b>now sql = </b>' . $type_of_query . '<br>');

    }
    else {
        $sql = $sql_select;
    }
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $result = mysqli_query($connect, $sql); 
     var_dump($result);
     print ('<b>$result sql<br>');

    $temp_rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    var_dump($temp_rows);
    print ('<b>$result sql<br>');
    return $temp_rows[0]['lot_bool'];
}

    $first_request = lot_bool_sql($connect, 2);
    print ('<b> first_request = </b>' . $first_request . '<br>');


//  print ('<b> first_request = </b>' . $first_request . '<br>');
//    end;

*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// // создаем куку


// $cookie_name = "registration";
// $cookie_value = implode(',', $errors);
// var_dump ($cookie_value);
// $cookie_expire = strtotime("+30 days");
// $path = "/";
// setcookie($cookie_name, $cookie_value, $cookie_expire, $path);
// var_dump($_COOKIE);
// var_dump($_COOKIE["registration_errors"]);



