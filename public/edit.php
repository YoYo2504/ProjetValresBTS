<?php
session_start();
require '../src/bootstrap.php';
require_once '../src/App/Validator.php';

$pdo = get_pdo();
$events = new Calendar\Events($pdo);
$errors=[];

if (!isset($_GET['id'])){
    header('location: /404.php');
}
try{
    $event = $events->find($_GET['id']);
}catch (\Exception $e){
    e404();
}

$data = [
    'name' => $event->getDescriptionName,
    'date' => $event->getStartEvent,
    'start' => $event->getStartEvent,
    'end' => $event->getEndEvent,
    'description' => $event->getDescription,
];

if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = $_POST;
    $validator = new \Calendar\EventValidator();
    $errors = $validator->validates($_POST);
    if(empty($errors)){
        header('Location: /index?success=1.php');
        $event = $events->hydrate(new \Calendar\Event(), $data);
        $events->update($event);
        exit();
        //dd($errors);
    }
}

render('header', ['title'=> $event->getDescriptionName]);
?>

<h1>Editer l'évènement <small><?= h($event['descriptionName']);?></small> </h1><br>

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