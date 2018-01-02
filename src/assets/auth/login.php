<?php session_start();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


$_POST = json_decode(file_get_contents('php://input'), true);

require '../db.php';

	$email = trim($_POST['email']);
	$password = trim($_POST['password']);

	$users_t = R::findOne('users','email =?',
		array(trim($email))
	);

	if ($users_t == null) {
		$err[] = 'Пользователь не существует';
	}
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$err[] = 'Некорректный email';
	}


	if (empty($err)) {


		do{

			$token = md5(time().time().rand(0,41)).md5($users_t -> date . time()) . md5($users_t -> name . rand(0,22) . "Привет Мир!").md5('Это пасхалка!').
			 md5(time().time().rand(0,12)).md5($users_t -> date . time()) . md5(rand(0,89) . "Пока Мир!").md5('Это не пасхалка!') ;

			$temp = 	R::findOne('users','token = ?',array($token);

		}while($temp != null);

		
		 $users_t -> token = $token;
		 R::store($users_t);

		 $data['err'] = false;
		 $data['token'] = $token;
		 $data['data'] = faslse;

		echo json_encode($data);

	}else{

		$data_err['err'] = true;
		$data_err['data'] = array_shift($err);
		$data_err['token'] = false;

		echo json_encode($data_err);


	}
