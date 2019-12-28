<?php

require_once('data.php');
require_once('functions/functions.php');
session_start();

// all_lots
$main_page = templates_render ('all_lots', ['categories' => $categories, 'lots' => $lots, 'is_tab' => $is_tab, 'ru_category_name' => $ru_category_name]); // $ru_category_name времменная, содержит актуальный tab на русском

// lot
if (isset($_GET['tab']) && $_GET['tab'] == 'lot' && ($lot = lot_sql($connect, $_GET['id'])) != NULL){ // $lot... без скобок не работает 
//	$lot = lot_sql($connect);
	$main_page = templates_render ('lot', ['lot' => $lot, 'categories' => $categories, 'id' => $_GET['id']]);
}

// 404
else if (isset($_GET['tab']) && $_GET['tab'] == 'lot' && lot_sql($connect) == NULL){
	$lot = lot_sql($connect);
	$main_page = templates_render ('404', ['id' => $_GET['id']]);
}

// registration
else if (isset($_GET['tab']) && $_GET['tab'] == 'registration') {
	// session_start();
//	$_SESSION = [];
	// $_SESSION['registration_first_time'] = true;
	// $_SESSION['is_form_invalid'] = "";
	// $_SESSION['is_input_valid'][] = "";
//	$_SESSION['lot']['category_id'] = "";

    $main_page = templates_render ('registration', ['categories' => $categories, 'unique_email' => $unique_email]);
}

// login
else if (isset($_GET['tab']) && $_GET['tab'] == 'login') {
    $main_page = templates_render ('login', ['categories' => $categories]);
}

// add_lot
else if (isset($_GET['tab']) && $_GET['tab'] == 'add_lot'){
	// session_start();
	// $_SESSION = [];
	// $_SESSION['add_lot_first_time'] = true;
	// $_SESSION['is_form_invalid'] = "";
	// $_SESSION['is_input_valid'][] = "";
	// $_SESSION['lot']['category_id'] = ""; // передается пустой массив в выбор категории,чтобы "компилятор не ругался"
	$main_page = templates_render ('add_lot', ['categories' => $categories]);
}

// layout
$leyout = (templates_render ('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab])); // название шаблона, список переменных

print $leyout;
