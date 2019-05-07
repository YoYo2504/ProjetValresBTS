<?php
session_start();
$user_id = $_GET['id'];
$token =$_GET['token'];
require '../src/db.php';
$req = $pdo->prepare('SELECT * FROM username WHERE id = ?');
$req->execute([$user_id]);
$user = $req->fetch();

if($user && $user->confirmation_token == $token){
    $pdo2->prepare('UPDATE username SET confirmation_token = NULL, confirmed_ad = NOW() WHERE id = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été validé';
    $_SESSION['auth'] = $user; // auth comme authentification
    header('Location: account.php');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location : login.php');
}

