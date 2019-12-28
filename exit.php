<?php
require_once ('functions/functions.php'); // ../ значит на 1 уровень ниже
require_once('data.php');
session_start();
session_unset();
session_destroy();
$is_tab = 0; // отобразить узкое поле с категориями
$main_page = templates_render('login', ['categories' => $categories]);

        $leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab])); // название шаблона, список переменных
        print $leyout;
        exit();