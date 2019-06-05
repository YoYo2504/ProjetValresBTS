<?php
session_start();
require_once '../src/bootstrap.php';
require '../views/header.php';
require_once '../class/database.php';
require_once  '../src/Calendar/Event.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);

$allEvents = $pdo->query('SELECT descriptionName, description, startEvent, endEvent FROM events ORDER BY id DESC');

if(isset($_GET['search']) AND !empty($_GET['search'])){
    $search = htmlspecialchars($_GET['search']);
    $allEvents = $pdo->query('SELECT descriptionName, description, startEvent, endEvent FROM events WHERE CONCAT(description,descriptionName) LIKE "%'.$search.'%" ORDER BY id DESC');
}

?>
<h1>Rechercher un évènement</h1>
<br>
<form method="get">
    <input  type="search" name="search" placeholder="Recherche...">
    <input type="submit" value="Valider">
</form>

<?php if($allEvents->rowCount()> 0){ ?>
    <ul>
        <br>
        <?php while ($s = $allEvents->fetch()){?>
            <li>Description : <?= $s['descriptionName']?> (description complète: <?= $s['description']?> |
                Date: <?= (new DateTime($s['startEvent']))->format('d/m/Y');?> |
                Heure de début: <?= (new DateTime($s['startEvent']))->format('H:i');?> |
                Heure de fin: <?= (new DateTime($s['endEvent']))->format('H:i');?>)</li>
        <?php }?>
    </ul>
<?php }else{?>
    <br>
<P>Aucun résultat pour : <?= $search ?></P>
<?php }?>

