<?php

require  '../vendor/autoload.php';

function e404(){
    require'../public/404.php';
    exit();
}

function dd(...$vars){
    foreach ($vars as $var){
        echo '<pre>';
       // print_r($var);
        echo '</pre>';
    }

}

//define('SERVER', '127.0.0.1');
//define('NAME', 'ProjetValres');
//define('USERNAME', 'epsi');
//define('PASS', 'rootroot');
//define('PORT', 3302);

define('SERVER', '10.229.206.33');
define('NAME', 'ProjetValres');
define('USERNAME', 'root');
define('PASS', 'rootroot');
define('PORT', 3306);



// ne sert à rien ??
function get_pdo(){
    try{
        $PDO = new PDO('mysql:dbname=' . NAME . ';host=' . SERVER .';port='.PORT,USERNAME, PASS);
        $PDO ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        $PDO ->query('SET CHARACTER SET UTF8');
        $PDO->query('SET NAMES UTF8');
        return $PDO;
    }catch (Exception $ex){
        echo 'Exception reçue : ',  $ex->getMessage(), "\n";
    }
}


function h(?string $value): string{
    if($value === null){
        return '';
    }

    return htmlentities($value);
}

function render(string $views, $parameters = []){
    extract($parameters);
    include "../views/{$views}.php";
}