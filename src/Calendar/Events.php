<?php
namespace Calendar;
require_once '../src/bootstrap.php';
//require_once '../bootstrap.php';
use Couchbase\Exception;
use PDO;


class Events {

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }


const SERVER = '127.0.0.1';
const NAME ='ProjetValres';
const USERNAME = 'epsi';
const PASS='rootroot';
const PORT='3302';

    /**
     * Récupère les évènement commençant entre 2 dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetween (\DateTimeInterface $start, \DateTimeInterface $end): array {
        try{
            $PDO = new PDO('mysql:dbname=' . NAME . ';host=' . SERVER .';port='.PORT,USERNAME, PASS);
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC;
            $PDO->query('SET CHARACTER SET UTF8');
            $PDO->query('SET NAMES UTF8');
        }catch (Exception $ex){
            echo 'Exception reçue : ',  $ex->getMessage(), "\n";
        }
        $sql = "SELECT * FROM events WHERE startEvent BETWEEN '{$start->format('Y-m-d 00:00:00')}' AND '{$end->format('Y-m-d 23:59:59')}' ORDER BY startEvent ASC";
        //var_dump($sql);
        $statement = $PDO->query($sql);
        $results =$statement->fetchAll();
        return $results;
    }

    /**
     * Récupère les évènement commençant entre 2 dates
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    //AVANT
    /*public function getEventsBetween (\DateTimeInterface $start, \DateTimeInterface $end): array {
        $pdo = new \PDO('mysql:host=localhost;dbname=planningFormation,charset=utf8', 'root', 'YoYo250497', [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);
        $sql = "SELECT * FROM Events WHERE startEvent BETWEEN {$start->format('Y-m-d 00:00:00')}
AND {$end->format('Y-m-d 23:59:59')} ORDER BY startEvent ASC";
        var_dump($sql);
        $statement = $this->pdo->query($sql);
        $results =$statement->fetchAll();
        return $results;
    }*/

    /**
     * Récupère les évènement commençant entre 2 dates indexé par jour
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return array
     */
    public function getEventsBetweenByDay (\DateTimeInterface $start, \DateTimeInterface $end): array {
        $events = $this->getEventsBetween($start,$end);
        $days = [];
        foreach ($events as $event){
            $date = explode(' ', $event['start'])[0];
            if(isset($days[$date])){
                $days[$date] = [$event];
            }else{
                $days[$date][] = $event ;
            }
        }
        return $days;
    }

    /**
     * Récupère un évènement
     * @param int $id
     * @return Event
     * @throws \Exception
     */
    public function find (int $id): Event {
        require 'Event.php';
        $statement = $this->pdo->query("SELECT * FROM Events WHERE id = $id LIMIT 1");
        $statement->setFetchMode(PDO::FETCH_CLASS, \Calendar\Event::class);
        $result= $statement->fetch();
        if ($result === false){
            throw new \Exception('Aucun résultat n\'a été trouvé');
        }
        return $result;
    }

    /**
     * @param Event $event
     * @param array $data
     * @return Event
     */
    public function hydrate(Event $event, array $data){
        $event->setDescriptionName($data['name']);
        $event->setDescription($data['description']);
        $event->setStartEvent(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start'])->format('Y-m-d H:i:s'));
        $event->setEndEvent(\DateTimeImmutable::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end'])->format('Y-m-d H:i:s'));
        return $event;
    }

    /**
     * Créer un évènement
     * @param Event $event
     * @return bool
     */
    public function create(Event $event): bool{
        //var_dump(get_pdo());
        $statement = $this->pdo->prepare('INSERT INTO events (descriptionName, description, startEvent, endEvent) VALUES (?, ?, ?, ?)');
        $statement->execute([
            $event->getDescriptionName(),
            $event->getDescription(),
            $event->getStartEvent()->format('Y-m-d H-i-s'),
            $event->getEndEvent()->format('Y-m-d H-i-s'),
        ]);
        return true;
    }

    /**
     * Met à jour un évènement au niveau de la bdd
     * @param Event $event
     * @return bool
     */
    public function update(Event $event): bool{
        $statement = $this->pdo->prepare('UPDATE events SET descriptionName = ?, description = ?, startEvent = ?, endEvent = ? WHERE id =?');
        $statement->execute([
            $event->getDescriptionName(),
            $event->getDescription(),
            $event->getStartEvent()->format('Y-m-d H-i-s'),
            $event->getEndEvent()->format('Y-m-d H-i-s'),
            $event->getId()
        ]);

    }

    /**
     * TODO : Supprime un évènement
     * @param Event $event
     * @return bool
     */
    public function delete(Event $event):bool{
        $statement = $this->pdo->prepare('DELETE FROM events WHERE descriptionName = ?, description = ?, startEvent = ?, endEvent = ? id =?');
        $statement->execute([
            $event->getDescriptionName(),
            $event->getDescription(),
            $event->getStartEvent()->format('Y-m-d H-i-s'),
            $event->getEndEvent()->format('Y-m-d H-i-s'),
            $event->getId()
        ]);
    }
}