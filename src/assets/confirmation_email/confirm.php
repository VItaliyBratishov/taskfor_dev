<?php session_start();
require '../db.php';
$users = R::findOne('users','confirmation_email =?',
	array($_GET['key'])
);

if ($users != null) {

	$users -> confirmation_email = '1';
	R::store($users);
	
	?>


	
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Подтверждение email | <?php echo $users -> email; ?></title>
		<link rel="stylesheet" href="../libs/css/materialize.min.css">
		<link rel="stylesheet" href="../libs/css/animate.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	</head>
	<body>
		<style>
		*{
			color: #76CD6F;
		}
	</style>

	<center>
		<div style="margin-top: 70px" >
			<i style="font-size: 250px" class="material-icons animated bounceIn">check_circle</i><br>
			<p class="material-icons animated bounceInUp"> 
				Спасибо, что Вы с нами. Можете войти с любого устройства
			</p>
		</div>
	</center>

</body>
</html>





<?php
}
?>

