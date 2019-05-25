<?php
session_start();
require '../src/bootstrap.php';
require_once '../src/App/Validator.php';
require_once '../src/Calendar/Event.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors=[];

if (!isset($_GET['id'])){
    header('location: /404.php');
}
try{
    $data = $events->find($_GET['id']);

}catch (\Exception $e){
    e404();
}
/*
$data = [
    'name' => $event->getDescriptionName(),
    'date' => $event->getStartEvent(),
    'start' => $event->getStartEvent(),
    'end' => $event->getEndEvent(),
    'description' => $event->getDescription()
];
*/

if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = $_POST;
    $data['id']=$_GET['id'];
    $validator = new \Calendar\EventValidator();
    $errors = $validator->validates($_POST);

    if(empty($errors)){
        $event = $events->hydrate(new \Calendar\Event(), $data);
        $events->update($event);
        header('Location: /index?success=1.php');
        exit();
    }
}

render('header', ['title'=> $data['descriptionName']]);
?>

<h1>Editer l'évènement <small><?= h($data['descriptionName']);?></small> </h1><br>

<div class="container">
    <form action="" method="post" class="form">
        <?php render('calendar/form', ['data'=> $data, 'errors'=> $errors]); ?>
        <?php if(isset($_SESSION['auth'])):?>
            <div class="form-group">
                <button class="btn btn-primary">Modifier la réservation</button>
            </div>
        <?php else :?>
            <div class="alert alert-danger">
                Merci de vous connecter pour ajouter une réservation
            </div>
        <?endif;?>

    </form>
</div>

<?php render('footer');