<?php

//define('SERVER', '127.0.0.1');
//define('NAME', 'ProjetValres');
//define('USERNAME', 'epsi');
//define('PASS', 'rootroot');
//define('PORT', 3302);

define('SERVER', '169.254.7.108');
define('NAME', 'ProjetValres');
define('USERNAME', 'root');
define('PASS', 'rootroot');
define('PORT', 3306);

$pdo2 = new PDO('mysql:dbname=' . NAME . ';host=' . SERVER .';port='.PORT,USERNAME, PASS);
$pdo2 -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);

