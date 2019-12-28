Б?зрз
require_once ('functions/functions.php');
require_once('data.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // проверяем пришли ли формы
		$add_lot = $_POST['add_lot'];
}
else {
    print('ERROR POST REQUEST');
}

foreach ($add_lot as $key => $value) { // перебираем массив с required полями
//	echo "<br> key = " . $key . ", value = " . $value . "<br>";
	if (empty($value)) { // если поле не заполненно
		$errors[$key] = $add_lot[$key]; // cоздаем массив required полей (используется foreach, так как все поля required)
	}
}	

$early = ('Выберите дату не ранее ' . date("d/m/Y", strtotime("+1 day")));
$late = ('Выберите дату не позднее ' . date("d/m/Y", strtotime("+100 day")));

if (empty($add_lot['finish_time'])) {
$errors ['finish_time'] = 'Введите дату завершения торгов';
	$add_lot['finish_time'] = date("Y-m-d", strtotime("+1 day"));
}
else if ($add_lot['finish_time'] < date("Y-m-d",strtotime("+1 day"))){
	$errors['finish_time'] = $early;
	$add_lot['finish_time'] = date("Y-m-d", strtotime("+1 day"));
}
else if ($add_lot['finish_time'] > date("Y-m-d", strtotime("+100 day"))){
	$errors['finish_time'] = $late;
	$add_lot['finish_time'] = date("Y-m-d", strtotime("+100 day"));
}
// echo "<pre>";
// var_dump ($errors);
// echo "</pre>";


if (isset($errors)){
    $main_page = templates_render ('add_lot', ['categories' => $categories, 'add_lot' => $add_lot, 'errors' => $errors]);
    
    $leyout = (templates_render ('layout', ['page_name' => $page_name, 'categories' => $categories, 'is_auth' => $is_auth, 'user_name' => $user_name, 'user_avatar' => $user_avatar, 'main_page' => $main_page, 
	'is_tab' => $is_tab])); // название шаблона, список переменных
    print $leyout;
    exit();
}
$filename = uniqid() . '.jpg'; // uniqid() создает уникальную последовательность символов
$add_lot["image_url"] = '/uploads/' . uniqid() . '.jpg'; // добавляем новое имя-адес файла в $add_lot
move_uploaded_file($_FILES['lot']['tmp_name'], __DIR__ . $add_lot["image_url"]); // перемещаем файл в 	
$sql = 'INSERT INTO lots 
SET category_id = ' . $add_lot["category_id"] . ', 
user_id = ' . $_SESSION["user"]["id"] . ',
name = "' . $add_lot["name"] . '", 
description = "' . $add_lot["description"] . '", 
creation_time = "' . sql_datetime() . '", 
finish_time = "' . $add_lot["finish_time"] .' '. date("H:i:s"). /* надо будет переделат с JS запросом времени пользователя */'", 
start_price = "' . $add_lot["start_price"] . '", 
bet_step = "' . $add_lot["bet_step"] . '", 
image_url = "' . $add_lot["image_url"] . '";'; 
$res = mysqli_query($connect, $sql);
if ($res) {
	$add_lot_id = mysqli_insert_id($connect); // получаем id нового лота
}
header("Location: /index.php?tab=lot&id=" . $add_lot_id); // переходим на страницу lot с id нового лота
exit();










