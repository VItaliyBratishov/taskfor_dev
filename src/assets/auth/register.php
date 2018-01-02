<?php session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


$_POST = json_decode(file_get_contents('php://input'), true);

require '../db.php';

if (!isset($_SESSION['id_u'])) {


	$email = trim($_POST['email']);
	$password = trim($_POST['password']);
	$name = trim($_POST['name']);

	$phone = trim($_POST['phone']);
	$city = trim($_POST['city']);


	$users_t = R::findOne('users','email =?',
		array(trim($email))
	);

	if ($users_t != null) {
		$err[] = 'Пользователь с вамшим email существует';
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err[] = 'Некорректный email';
	}
	if (strlen(trim($password)) < 6) {
		$err[] = 'Длинна пароля менее 6-ти символов';
	}



	if (empty($err)) {


		$email_key =  md5(time().rand(2,458)) . md5(time().rand(1,7852));

		do{

			$token = md5(time().time().rand(0,41)).md5($users_t -> date . time()) . md5($users_t -> name . rand(0,22) . "Привет Мир!").md5('Это пасхалка!').
			 md5(time().time().rand(0,12)).md5($users_t -> date . time()) . md5(rand(0,89) . "Пока Мир!").md5('Это не пасхалка!') ;

			$temp = 	R::findOne('users','token = ?',array($token);

		}while($temp != null);


		$users = R::dispense('users');

		$users -> email = $email;
		$users -> name = $name;
		$users -> password = md5(trim($password));
		$users -> confirmation_email = $email_key;
		$users -> date = time();
		$users -> permission = 0;
		$users -> type = '';
		$users -> ban = false;
		$users -> reason_ban = null;
		$users -> token = $token;

		$id_u = R::store($users);

		$information = R::dispense('information');

		$information -> id_u = $id_u;
		$information -> phone = $phone;
		$information -> city = $city;

		R::store($information);


		$subject = "Подтверждение почты";

		$message = '
		<html>
		<head>
		<title>Подтверждение почты | '. $email .' </title>
		</head>
		<body>
		<a href="https://rtrucking.000webhostapp.com/assets/confirmation_email/confirm.php?key='.$email_key .'">Для подтверждения перейдите по ссылке </a>
		</body>
		</html>';

		$headers  = "Content-type: text/html; charset=utf-8 \r\n";

		mail($email, $subject, $message, $headers);

		 $data['err'] = false;
		 $data['token'] = $token;
		 $data['data'] = 'success';

		echo json_encode($data);

	}else{
		$data_err['err'] = true;

		$data_err['data'] = array_shift($err);

		echo json_encode($data_err
	);
	}
}
