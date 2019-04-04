<?php
require '../src/bootstrap.php';
//require_once 'bdd.php';

$pdo = get_pdo();
$event = new Calendar\Events($pdo);
$errors = [];

try{
    $event = $events->find($_GET['id'] ?? null);
}catch (\Exception $e){
    e404();
}catch (\Error $e){
    e404();
}

$data = [
        'name'          =>  $event->getDescriptionName(),
        'date'          =>  $event->getStartEvent()->format('Y-m-d'),
        'start'         =>  $event->getStartEvent()->format('H-i'),
        'end'           =>  $event->getEndEvent()->format('H-i'),
        'description'   =>  $event->getDescription()
];



if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = $_POST;

    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($data);
    if(empty($errors)){
        $events ->hydrate($event, $data);
        $events->update($event);
        header('Location: /index?success=1');
        exit();
        dd($errors);
    }
}

render('header', ['title'=> $event->getDescriptionName]);
?>

<h1>Editer l'évènement<small><?= h($event->getDescriptionName());?></small> </h1>

    <div class="container">
        <form action="" method="post"class="form">
            <?php render('calendar/form', ['data'=> $data, 'errors'=> $errors]); ?>
            <?php
            //if(isset($_SESSION['auth'])):?>
                <div class="form-group">
                    <button class="btn btn-primary">Modifier la réservation</button>
                    <button class="btn btn-primary">Supprimer la réservation</button>
                </div>
            <?//endif;?>
        </form>
    </div>
<?php render('footer');?>