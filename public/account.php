<?php session_start();
require 'functions.php';
require '../src/bootstrap.php';
//require_once 'bdd.php';
logged_only();
if(!empty($_POST)){
    if(!empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger']= "Les mots de passes ne correspondent pas";
    }else{
        $user_id = $_SESSION['auth']->id;
        $password=password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once '../src/db.php';
        $pdo2->prepare('UPDATE utilisateur SET password = ?')->execute([$password]);
        $_SESSION['flash']['success']= "Votre mot de passe a bien été mis à jour";
    }
}
require '../views/header.php';
?>

<h1>Bonjour <?= $_SESSION['auth']->username; ?></h1>

<form action="" method="POST">
    <div class="form-group">
        <input class="form-control" type="password" name="password" placeholder="Changer votre mot de passe"/>
    </div>
    <div class="form-group">
        <input class="form-control" type="password" name="password_Confirm" placeholder="Confirmation du mot de passe"/>
    </div>
    <button class="btn btn-primary">Changer mon mot de passe</button>
</form>



<?php require '../views/footer.php';?>