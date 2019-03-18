<?php
require_once  'functions.php';
require_once 'bdd.php';
session_start();
if(!empty($_POST)){
    require_once '../src/db.php';
    $errors = [];
    if(empty($_POST['username']) || !preg_match('/^[A-Za-z0-9_]+$/', $_POST['username'])){
        $errors['username']="Votre pseudo n'est pas valide";
    }else{
        $req = $pdo2->prepare('SELECT id FROM utilisateur WHERE username = ?');
        $req->execute([$_POST['username']]);
        $user = $req->fetch();
        if($user){
            $errors['username'] = 'Ce pseudo est déjà pris';
        }
    }

    if(empty(['email'])|| !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email']= "votre email n'est pas valide";
    }
    else{
        $req = $pdo2->prepare('SELECT id FROM utilisateur WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cette email est déjà utilisé pour un autre compte';
        }
    }

    if(empty($_POST['password'])|| $_POST['password'] != $_POST['password_confirm']){
        $errors['email'] = "Vous devez rentrer un mot de passe valide";
    }

    if(empty($errors)){

        $req = $pdo2->prepare("INSERT INTO utilisateur SET username = ?, password = ?, email = ?, confirmation_token =?");
        $token = str_random(60);

        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $req->execute([$_POST['username'], $password, $_POST['email'], $token]);
        $user_id= $pdo2->lastInsertId();
        //              ⚠️⚠️⚠️⚠️⚠️⚠️⚠️                                                                                                              changer le lien par la suite
        mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n http://localhost:8000/account.php?id=$user_id&token=$token");
        $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
        header('Location: login.php');
        exit();
    }


    debug($errors);
}
?>
<?php require '../src/bootstrap.php';
require '../views/header.php';?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach ($errors as $error): ?>
        <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="" method="POST">
    <div class="form-group">
        <label for="">Pseudo</label>
        <input type="text" name="username" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Email</label>
        <input type="email" name="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Mot de passe</label>
        <input type="password" name="password" class="form-control">
    </div>
    <div class="form-group">
        <label for="">Confirmation mot de passe</label>
        <input type="password" name="password_confirm" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">M'inscrire</button>
</form>

<?php require '../views/footer.php';?>