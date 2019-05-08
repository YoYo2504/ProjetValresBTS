<?php
session_start();
require_once '../src/bootstrap.php';
require '../views/header.php';
require_once '../class/database.php';
use Calendar\Events;
use Calendar\month;

$pdo = get_pdo();
$events = new Events(pdo);
//$month = new month($_GET['month'] ?? null, $_GET ['year'] ?? null);
$day = new month($_GET['day'] ?? null, $_GET['month'] ?? null, $_GET ['year'] ?? null);
$start = $day->getStartingDay();
//$start = $start-> format('N') === '1' ? $start : $month->getStartingDay()->modify('last monday');
$start = $start-> format('N') === '1' ? $start : $day->getStartingDay()->modify('last monday');
//$weeks = $month->getWeeks();
$weeks = $day->getWeeks();
$end = (clone $start)->modify('+'.(6 + 7 * ($weeks -1)) .' days');
$events = $events->getEventsBetweenByDay($start,$end);

?>

<div class="calendar">
    <div class="d-flex flex-row align-items-center justify-content-between mx-sm-3">
        <h1><?= $day->toStringDay(); ?></h1>
        <div>

            <a href="day.php?month=<?= $day->previousDay()->day;?> & year= <?= $day->previousDay()->year;?>" class="btn btn-primary">&lt;</a>
            <a href="day.php?month=<?= $day->nextDay()->day;?> & year= <?= $day->nextDay()->year;?>" class="btn btn-primary">&gt;</a>

        </div>
    </div>
    <?php foreach ($eventsForDay as $event): ?>
        <div class="calendar__event">
            <?= (new DateTime($event['start']))->format('H:i') ?> - <a href="event.php?id=<?= $event['id'];?>"><?=
                h($event['descriptionName']);?></a>
        </div>
    <?php endforeach; ?>

</div>
