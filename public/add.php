<?php
require '../src/bootstrap.php';
require_once 'bdd.php';

$data =[
    'date'  => $_GET['date'] ?? date('Y-m-d'),
    'start' => date('H:i'),
    'end'   => date('H:i')
];
$validator = new App\Validator($data);
if(!$validator->validate('date', 'date')){
    $data['date'] = date('Y-m-d');
};
$errors = [];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = $_POST;
    $errors = [];
    $validator = new Calendar\EventValidator();
    $errors = $validator->validates($_POST);
    if(empty($errors)){
        $event = new \Calendar\Events(get_pdo());
        $events = $event->hydrate(new \Calendar\Event(), $data);
        $event->create($event);
        header('Location: /index?success=1');
        exit();
        dd($errors);
    }
}
render('header',['title'=>'Ajouter un évènement']);
?>

<div class="container">
    <?php if(!empty($errors)): ?>
        <div class="alert alert-danger">
            Merci de corriger les mauvais renseignements
        </div>
    <?php endif; ?>
    <h1>Ajouter un évènement</h1>

    <form action="" method="post"class="form">
        <?php render('calendar/form', ['data'=> $data, 'errors'=> $errors]); ?>
        <div class="form-group">
            <button class="btn btn-primary">Ajouter la réservation</button>
        </div>
    </form>
</div>

<?php render('footer');?>
