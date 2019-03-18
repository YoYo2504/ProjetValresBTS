<?php
require '../src/bootstrap.php';
require_once 'bdd.php';

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

render('header', ['title'=> $event->getDescriptionName]);
?>

<h1><?= h($event->getDescriptionName());?> </h1>

<ul>
    <li>Date: <?= $event->getStartEvent()->format('d/m/Y');?></li>
    <li>Heure de début: <?= $event->getStartEvent()->format('H:i');?></li>
    <li>Heure de fin: <?= $event->getEndEvent()->format('H:i');?></li>
    <li>
        Description:<br>
        <?= h($event->getDescription());?>
    </li>
</ul>
<?php require '../views/footer.php';?>