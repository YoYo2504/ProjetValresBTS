<?php
session_start();
require '../views/header.php';
require '../src/bootstrap.php';
//require_once 'bdd.php';
if(isset($_GET['id']) && isset($_GET['token'])){
    require '../src/db.php';
    $req = $pdo2->prepare('SELECT * FROM utilisateur WHERE id = ? AND reset_token IS NOT NULL reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'], $_GET['token']]);
    $user = $req->fetch();
    if($user){
        if(!empty($_POST)){
            if(!empty($_POST['password']) && $_POST['password']== $_POST['password_confirm']){
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $_SESSION['flash']['success']= 'Votre mot de passe a bien été modifié';
                $_SESSION['auth'] = $user;
                header('Location: account.php');
                exit();
            }
        }
    }else{

        $_SESSION['flash']['session'] = "Ce token n'est pas valide";
        header('Location: login.php');
        exit();
    }
}else{
    header('Location: login.php');
    exit();
}
?>

<h1>Réinitialiser mon mot de passe</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="">Mot de passe</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="">Confirmation du mot de passe</label>
            <input type="password" name="password_confirm" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Réinitialiser mon mot de passe </button>
    </form>

<?php require '../views/footer.php';?>