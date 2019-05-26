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
    $data = $events->find($_GET['id']);

}catch (\Exception $e){
    e404();
}

if($_SERVER['REQUEST_METHOD']==='POST'){


    // Suppression de l'évènement à l'aide d'une requête préparée
    $data = $_POST;
    $data['id']=$_GET['id'];
    $var=$data['id'];

    $req = $pdo->prepare('DELETE FROM events WHERE id=" '.$var.'"');
    $req->execute();

    header('Location: /index?success=1.php');


}

render('header', ['title'=> $data->getDescriptionName]);
?>

<h1><?= h($data['descriptionName']);?> </h1><br>

<ul>
    <li>Date: <?= (new DateTime($data['startEvent']))->format('d/m/Y');?></li>
    <li>Heure de début: <?= (new DateTime($data['startEvent']))->format('H:i');?></li>
    <li>Heure de fin: <?= (new DateTime($data['endEvent']))->format('H:i');?></li>
    <li>
        Description:<br>
        <?= h($data['description']);?>
    </li>
</ul>
<div>
    <?php
    if(isset($_SESSION['auth'])):?>
        <a href="edit.php?id=<?= $data['id'];?>" class="btn btn-primary">Modifier</a>
    <form action="" method="post" class="form">
        <button class="btn btn-primary">Supprimer la réservation</button>
    </form>
    <? endif;?>
</div>

<?php require '../views/footer.php';?>