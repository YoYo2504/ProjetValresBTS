<?php

/*$pdo2 = new PDO('host=localhost;mysql:dbname=planningFormation','root', 'YoYo250497');
$pdo2 -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);*/

define('SERVER', '127.0.0.1');
define('NAME', 'planningFormation');
define('USERNAME', 'root');
define('PASS', 'YoYo250497');

$pdo2 = new PDO('mysql:dname=' . NAME .';host=' . SERVER ,USERNAME, PASS);
$pdo2 -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);