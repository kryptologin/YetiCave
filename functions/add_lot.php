<?php

print ('<br><br><br>'  . __DIR__ . '<br><br><br>');

require_once( __DIR__ . 'functions/functions.php');
// require_once ('index.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST;
}
else {
    print('ERROR');
}


print ('<br><br><br>'  . __DIR__ . '<br><br><br>');


// print ('<br>');
// var_dump($_FILES);
// print ('<br>');
$add_lot = $_POST['add_lot'];


$filename = uniqid() . '.jpg';
$add_lot["image_url"] = '/uploads/' . uniqid() . '.jpg';
move_uploaded_file($_FILES['lot']['tmp_name'], __DIR__ . $add_lot["image_url"]);
var_dump($add_lot);


$sql = 'INSERT INTO lots 
SET category_id = ' . $add_lot["category_id"] . ', 
user_id = 1,
name = ' . $add_lot["name"] . ', 
description = ' . $add_lot["description"] . ', 
creation_time = ' . sql_datetime() . ', 
finish_time = ' . $add_lot["finish_time"] .' '. date("H:i:s") /* надо будет переделат с JS запросом времени пользователя */. ', 
start_price = ' . $add_lot["start_price"] . ', 
bet_step = ' . $add_lot["bet_step"] . ', 
image_url = ' . $add_lot["image_url"] . ';';


print ('<br><br><br>' . $sql . '<br><br><br>');

$res = mysqli_query($connect, $sql);

print ('<br><br><br>' . $res . '<br><br><br>');

if ($res) {
    $add_lot_id = mysqli_insert_id($connect);

    print ('<br><br><br>' . $id . '<br><br><br>');

//            header("Location: /index.php?tab=lot&id=" . $id);
    $_GET['tab'] = 'lot';
    $_GET['id'] = $add_lot_id;
} else {
    $content = include_template('error.php', ['error' => mysqli_error($link)]);
}
