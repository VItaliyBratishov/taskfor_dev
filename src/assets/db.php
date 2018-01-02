<?php
require"libs/php/rb-mysql.php";
R::setup( 'mysql:host=localhost;dbname=ourdb', 'root', '' );
$host = 'localhost'; 
$database = 'ourdb'; 
$user = 'root'; 
$password = '';
$connection = mysqli_connect($host, $user, $password, $database);
mysqli_set_charset($connection, "utf8");
