<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


$data = json_decode(file_get_contents('php://input'), true);

require '../db.php';

if (isset($data['token'])) {
	$temp = R::findOne('users','token =?',array($data['token']));
	$temp -> Token = null;
	R::store($temp);


	$data_send['err'] =  false;
	echo json_encode($data_send);
}else{
	$data_err['err'] = true;
	$data_err['data'] = 'Пользователь не существует';
	echo json_encode($data_err);
}
