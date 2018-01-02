<?php session_start();

require '../db.php';

if (isset($_SESSION['id_u'])) {

	$users = R::find('users','id = ?',
		array($_SESSION['id_u'])
	);
	$users -> online = 0;
	R::store($users);

	unset($_SESSION['id_u']);

	echo json_encode("1");
}