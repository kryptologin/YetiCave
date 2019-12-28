<?php
require_once ('functions/functions.php'); // ../ значит на 1 уровень ниже
require_once('data.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // проверяем пришли ли формы
	$reg = $_POST['reg'];
}
else {
    print('ERROR POST REQUEST');
}

foreach ($reg as $key => $value) { // перебираем массив с required полями
//	echo "<br> key = " . $key . ", value = " . $value . "<br>";
	if (empty($value)) { // если поле не заполненно
		$errors[$key] = $reg[$key];
	}
}	


$errors['unique_email'] = true;
if ($reg['email']){
	$sql = "SELECT id FROM users WHERE email = '" . $reg['email'] . "'"; // значение sql поля (переменная) обязательно в "", остальное без
	$res = mysqli_query($connect, $sql);
	$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
	// var_dump($rows);
		if ($rows) {
	 		$errors['unique_email'] = false;
	 	} 
}
// var_dump($errors['unique_email']);
if (isset(($errors)['email']) || 
	isset(($errors)['password']) ||
	isset(($errors)['name']) ||
	isset(($errors)['message']) ||
	$errors['unique_email'] == false){
//	$add_lot_first_time = 0; // флаг, что форма отрпавляется повторно
	$main_page = templates_render ('registration', ['categories' => $categories, 'errors' => $errors, 'reg' => $reg]);

	$leyout = (templates_render ('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab, 'is_auth' => $is_auth])); // название шаблона, список переменных
	print $leyout;
}


$add_user = $reg;
$filename = uniqid() . '.jpg'; // uniqid() создает уникальную последовательность символов
$add_user["image_url"] = '/img/user_avatars/' . $filename; // добавляем новое имя-адес файла
move_uploaded_file($_FILES['image']['tmp_name'], __DIR__ . $add_user['image_url']); // перемещаем файл в его директорию
$sql = 'INSERT INTO users 
SET name = "' . $add_user["name"] . '", 
email = "' . $add_user["email"] . '", 
contacts ="' . $add_user['message'] .'",
creation_time = "' . sql_datetime() . '", 
password = "' . password_hash($add_user["password"], PASSWORD_DEFAULT) . '", 
avatar = "' . $add_user["image_url"] . '";'; 
$res = mysqli_query($connect, $sql);
if ($res) {
	$add_lot_id = mysqli_insert_id($connect); // получаем id нового лота
}
// session_start(); // чтобы поле login в tab=login автозаполнялось
// $_SESSION['login'] = $add_user['name'];
header("Location: /index.php?tab=login"); // переходим на страницу login с id нового лота
exit();
// $_GET['tab'] = 'add_lot'; // в отличии от header при использовании require  index.php?tab=lot не работает

