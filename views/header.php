<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>

<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/calendar.css">
    <title><?= isset($title) ? h($title): 'Mon calendrier'; ?></title>
</head>
<body>
<nav class="navbar navbar-dark bg-primary mb-3">
    <a class="navbar-brand" href="/index.php">Projet VALRES M2L</a>
    <?php if(isset($_SESSION['auth'])): ?>
        <a class="navbar-brand" href="/logout.php">Se déconnecter</a>
    <?php else :?>
        <a class="navbar-brand" href="/register.php">S'inscrire</a>
        <a class="navbar-brand" href="/login.php">Se connecter</a>
    <?php endif; ?>
    <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <?php if(isset($_SESSION['auth'])): ?>
                <li><a href="/logout.php">Se déconnecter</a> </li>
            <?php else :?>
                <li><a href="/register.php">S'inscrire</a></li>
                <li><a href="/login.php">Se connecter</a></li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach ($_SESSION['flash']as $type =>$message): ?>
        <div class="alert alert-<?= $type; ?>">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
