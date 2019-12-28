<?php
require_once ('functions/functions.php'); // ../ значит на 1 уровень ниже
require_once('data.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {  // проверяем пришли ли формы

    $login = $_POST['login'];
}
else {
    print('ERROR POST REQUEST');
}

foreach ($login as $key => $value) { // перебираем массив с required полями
//	echo "<br> key = " . $key . ", value = " . $value . "<br>";
    if (empty($value)) { // если поле не заполненно
        $errors[$key] = $login[$key];
    }
}
// print ('<pre>');
// print ('login in 21<br>');
// var_dump($login);
// print ('</pre><br>');

// var_dump($errors);


if ($login['email']) {
	$errors['registred_email'] = false;
    $sql = "SELECT id FROM users WHERE email = '" . $login['email'] . "'"; // значение поля (переменная) обязательно в '', остальное без
    $res = mysqli_query($connect, $sql);
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    // print ('<pre>');
    // var_dump($rows);
    // print ('<br></pre>');
    if ($rows) {
        $errors['registred_email'] = true; // значит введенный емейл существует (ошибки нет)
        $sql = "SELECT * FROM users WHERE email = '" . $login['email'] . "'"; // значение поля (переменная) обязательно в '', остальное без
        // print($sql);
        $res = mysqli_query($connect, $sql);
        $user = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : null;
        //     print ('<pre>');
        //     print ('$user, первый var_dump<br>');
        // var_dump($user);
        //     print ('<br></pre>');
        if ($user) {
//         	            print ('<pre>');
//         				var_dump($user[0]['password']);
// 						print ('<br>');
//         				var_dump($login['password']);
//         				var_dump(password_verify($login['password'], $user[0]['password']));
//         				print ('<br></pre>');
// //	 		$errors['registred_email'] = true; // значит введенный емейл существует (ошибки нет)
            if (password_verify($login['password'], $user[0]['password'])) {
			session_start();
			$_SESSION['user'] = $user[0];
			$_SESSION['isauth'] = true;
			$main_page = templates_render ('all_lots', ['categories' => $categories, 'lots' => $lots, 'is_tab' => $is_tab, 'ru_category_name' => $ru_category_name]);

			$leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab,]));
			print $leyout;
            exit();
            }
        }
    }

    // print ('<pre> errors не залогинились <br>');
    // var_dump($errors);
    // print ('</pre>');
    if (isset($errors['email']) || isset($errors['password']) || $errors['registred_email'] == false || $errors['registred_email']) {
//	$add_lot_first_time = 0; // флаг, что форма отрпавляется повторно
        $main_page = templates_render('login', ['categories' => $categories, 'errors' => $errors, 'login' => $login]);

        $leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab, 'is_auth' => $is_auth])); // название шаблона, список переменных
        print $leyout;
    } else { // логин (введен и есть в базе) но пароль неверный
//        exit();
 	        
 	        $main_page = templates_render('login', ['categories' => $categories, 'errors' => $errors, 'login' => $login]);

        $leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab, 'is_auth' => $is_auth])); // название шаблона, список переменных
        print $leyout;
	}
}
else{ 	        $main_page = templates_render('login', ['categories' => $categories, 'errors' => $errors, 'login' => $login]);

        $leyout = (templates_render('layout', ['page_name' => $page_name, 'categories' => $categories, 'main_page' => $main_page, 'is_tab' => $is_tab])); // название шаблона, список переменных
        print $leyout;
}