<?php
require '../views/header.php';
require '../src/bootstrap.php';
//require_once 'bdd.php';
if(!isset($_POST) && !empty($_POST['email'])){
    require_once '../src/db.php';
    $req = $pdo2-> prepare('SELECT * FROM utilisateur WHERE email= ? AND confirmed_ad IS NOT NULL ');
    $req->execute($_POST['email']);
    $user = $req->fetch();
    if($user){

        $reset_token = str_random(60);
        $pdo2->prepare('UPDATE utilisateur SET reset_token = ?, reset_at = NOW() WHERE id= ?')->execute([$reset_token, $user->id]);

        $_SESSION['flash']['success']= 'Consulté votre boite mail pour récupérer les instruction de rappel de votre mot de passe';

        //              ⚠️⚠️⚠️⚠️⚠️⚠️⚠️                                                                                                              changer le lien par la suite
        mail($_POST['email'], 'Réinitialisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\n http://localhost:8000/reset.php?id={$user->id}&token=$reset_token");
        header('Location: login.php');
        exit();
    }else{
        $_SESSION['flash']['danger']= 'Aucun compte ne correspond à cette adresse';
    }
}
?>

    <h1>Mot de passe oublié</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="">Email</label>
            <input type="email" name="mail" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>

<?php require '../views/footer.php';?>