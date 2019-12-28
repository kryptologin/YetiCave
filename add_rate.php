<?php
require_once ('functions/functions.php'); // ../ значит на 1 уровень ниже
require_once('data.php');
session_start();
if (isset($_SESSION['isauth'])){
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // проверяем пришли ли формы
//		print ('<br><pre>');
//		var_dump($_POST);
		
		
		$add_rate = lot_sql($connect, $_POST["lot_id"]);
//		var_dump($add_rate);
		
		$add_rate['post'] = $_POST;
//		var_dump($add_rate);

//		var_dump((int)$_POST['rate'] < ((int)$add_rate['bet_step'] + (int)$add_rate['start_price']));
//				print ('<br></pre>');
			 if ((int)$add_rate['post']['rate'] < ((int)$add_rate['bet_step'] + (int)$add_rate['start_price'])){
				$errors = true;
//				print ('<br> привет!');
				
				$main_page = templates_render ('lot', ['lot' => $add_rate, 'categories' => $categories, 'id' => $add_rate['id'], 'errors' => $errors]);
				$leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab])); // название шаблона, список переменных
    			print $leyout;
    			exit();
			}
		$sql = 'UPDATE lots 
		SET 
		start_price = "' . $add_rate['post']['rate'] . '"
		WHERE id = "' . $add_rate['id']. '";';
		$res = mysqli_query($connect, $sql);
		// var_dump($res);
		// var_dump($sql);
// print ('<pre>');
// var_dump($_SESSION);
// print ('</pre>');
		$sql = 'INSERT INTO bets 
		SET 
		lot_id = "' . $add_rate["post"]["lot_id"] . '",
		user_id = "' . $_SESSION["user"]["id"] . '",
		value = "' . $add_rate["post"]["rate"] . '", 
		creation_time = "' . sql_datetime() . '";';
		// var_dump($sql);
		$res = mysqli_query($connect, $sql);
		// var_dump($res);
		header("Location: /index.php?tab=lot&id=" . $add_rate["post"]["lot_id"]); // переходим на страницу lot с id нового лота
		exit();

	}
	    else{
    	print('ERROR POST REQUEST');
    	exit();
    }


}
else{
	$main_page = templates_render('login', ['categories' => $categories]);
	$leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab])); // название шаблона, список переменных
    print $leyout;
    exit();
}
