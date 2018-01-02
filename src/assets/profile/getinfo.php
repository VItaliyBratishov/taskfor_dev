<?php session_start();

header('Access-Control-Allow-Origin: *'); 
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization');


$_POST = json_decode(file_get_contents('php://input'), true);

require '../db.php';

$users = R::findOne('users','id =?',
           array($_POST['id'])
         );
$information = R::findOne('information','id_u =?',
           array($_POST['id'])
         );

$data = [$users,$information];

echo json_encode($data);

