<!Doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- fin bootstrap -->
    <link rel="stylesheet" href="css/calendar.css">
    <title><?= isset($title) ? h($title): 'Mon calendrier'; ?></title>
</head>
<body>
<nav class="navbar navbar-dark bg-primary mb-3">
    <a class="btn btn-primary" href="/index.php">Projet VALRES M2L</a>
    <a class="btn btn-primary" href="/search.php">Rechercher un évènement</a>
    <?php if(isset($_SESSION['auth'])): ?>
        <a class="btn btn-primary" href="/account.php">Mon compte</a>
        <a class="btn btn-primary" href="/logout.php">Se déconnecter</a>
    <?php else :?>
        <a class="btn btn-primary" href="/register.php">S'inscrire</a>
        <a class="btn btn-primary" href="/login.php">Se connecter</a>
    <?php endif; ?>
</nav>

<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach ($_SESSION['flash']as $type =>$message): ?>
        <div class="alert alert-<?= $type; ?>">
            <?= $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
