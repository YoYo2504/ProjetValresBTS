<?php
require '../views/header.php';
require '../src/bootstrap.php';
require_once 'bdd.php';
require 'functions.php';
reconnect_from_cookie();
if(isset($_SESSION['auth'])){
    header('Location: account.php');
    exit();
}
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once '../src/db.php';
    $req = $pdo2-> prepare('SELECT * FROM utilisateur WHERE (username= :username OR email= :username) AND confirmed_ad IS NOT NULL ');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user->password)){

        $_SESSION['auth']= $user;
        $_SESSION['flash']['success']= 'Vous êtes bien connecté';
        if($_POST['remember']){
            $remember_token = str_random(250);
            $pdo2->prepare('UPDATE utilisateur SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
            $setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'aigledesmontagnes'), time() + 60*60 *24*7); //clé pour le cookie secret
        }
        header('Location: account.php');
        exit();
    }else{
        $_SESSION['flash']['danger']= 'Identifiant ou mot de passe incorrecte';
    }
}
?>

<h1>Se connecter</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="">Pseudo ou l'email</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="form-group">
            <label for="">Mot de passe<a href="remember.php">(Mot de passe oublié)</a> </label>
            <input type="password" name="password" class="form-control">
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="remember" value="1"/> Se souvenir de moi
            </label>
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

<?php require '../views/footer.php';?>