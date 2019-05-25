<?php
session_start();
require '../src/bootstrap.php';
//require_once 'bdd.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
if (!isset($_GET['id'])){
    header('location: /404.php');
}
try{
    $event = $events->find($_GET['id']);
}catch (\Exception $e){
    e404();
}

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_SESSION['auth'])){
        //$event = $events->hydrate(new \Calendar\Event(), $data);
        $events->update($event);
        header('Location: /index?success=1.php');
        exit();
    }
}

render('header', ['title'=> $event->getDescriptionName]);
?>

<h1><?= h($event['descriptionName']);?> </h1><br>

<ul>
    <li>Date: <?= (new DateTime($event['startEvent']))->format('d/m/Y');?></li>
    <li>Heure de début: <?= (new DateTime($event['startEvent']))->format('H:i');?></li>
    <li>Heure de fin: <?= (new DateTime($event['endEvent']))->format('H:i');?></li>
    <li>
        Description:<br>
        <?= h($event['description']);?>
    </li>
</ul>
<div>

    <?php
    if(isset($_SESSION['auth'])):?>
        <a href="edit.php?id=<?= $event['id'];?>" class="btn btn-primary">Modifier</a>
    <form action="" method="post" class="form">
        <button class="btn btn-primary">Supprimer la réservation</button>
    </form>
    <? endif;?>
</div>

<?php require '../views/footer.php';?>