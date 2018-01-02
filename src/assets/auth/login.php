<?php session_start();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


$_POST = json_decode(file_get_contents('php://input'), true);

require '../db.php';

if (!isset($_SESSION['id_u'])) {


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

		$token = md5(time().time().rand(0,41)).md5($users_t -> date . time()) . md5($users_t -> name . rand(0,22) . "Привет Мир!").md5('Это пасхалка!');

		$users_t -> online = time();
		$users_t -> token = $token;
		R::store($users_t);

		$_SESSION['id_u'] == $users_t -> id;


		echo json_encode('{ "err" : false, "data":"'. $users_t -> id .',"auth_token": "'. $token .'" }');

	}else{
		echo json_encode('{ "err" : true, "data":"'. array_shift($err) .'"}');
	}
}