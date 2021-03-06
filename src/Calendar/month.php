<?php
/**
 * Created by PhpStorm.
 * User: yoanfilipe
 * Date: 05/12/2018
 * Time: 17:23
 */
namespace Calendar;
class Month{

    public $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    public $day;
    public $month;
    public $year;

    /**
     * Month constructor.
     * @param int $month
     * @param int $year
     * @throws \Exception
     */

    public function __construct(?int $month = null, ?int $year = null )
    {
        if ($month === null || $month<1 || $month>12){
            $month = intval (date('m'));
        }
        if ($year === null){
            $year =intval( date ('Y'));
        }
        if ($year < 1970){
            throw new \Exception("L'année est inférieur à 1970");
        }
        $this->month = $month;
        $this->year = $year;
    }


    /**
     * @return \DateTimeInterface
     * @throws \Exception
     */
    public function getStartingDay(): \DateTimeInterface{
        return new \DateTimeImmutable("{$this->year}-{$this->month}-01");

    }


    /**
     * Retourne le mois en toute lettre (ex Mars 2018)
     * @return string
     *
     */
    public function toString() : string {
        return $this-> months[$this->month - 1]. ' ' . $this->year;

    }

    public function  toStringDay() : string{
        return $this->days[$this->day-1]. ' ' . $this->months[$this->month - 1]. ' '. $this->year;
    }

    /**
     * renvoie le nb de semaine dans le mois
     * @return int
     */
    public function getWeeks() : int {
        $start = $this->getStartingDay();
        $end =  $start->modify('+1 month -1 day');
        $startWeek = intval($start->format('W'));
        $endWeek =intval($end->format('W'));
        if ($endWeek ===1){
            $endWeek =intval($end ->modify('- 7 days')->format('W')) + 1;
        }
        $weeks = $endWeek - $startWeek + 1;
        if ($weeks < 0){
            $weeks = intval($end->format('W'));
        }
        return $weeks;
    }

    /**
     * Est-ce que le jour est dans le mois en cours ?
     * @param \DateTimeInterface $date
     * @return bool
     * @throws \Exception
     */
    public function withinMonth (\DateTimeInterface $date):bool{
        return $this->getStartingDay()->format('Y-m') === $date->format('Y-m');
    }

    /**
     * renvoie le mois suivant
     * @return Month
     * @throws \Exception
     */
    public function nextMonth(): Month{
        $month = $this->month +1;
        $year=$this->year;
        if($month > 12){
            $month = 1;
            $year += 1;
        }
        return new Month($month, $year);
    }

    /**
     * renvoie le mois précédant
     * @return Month
     * @throws \Exception
     */
    public function previousMonth(): Month{
        $month = $this->month -1;
        $year=$this->year;
        if($month < 1){
            $month = 12;
            $year -= 1;
        }
        return new Month($month, $year);
    }

    public function nextDay(): Month{
        $day = $this->day +1;
        $month = $this->month;
        $year=$this->year;
        if($day > 7){
            $day = 1;
            $month += 1;
            if($month > 12){
                $month = 1;
                $year += 1;
            }
        }
        return new Month($day, $month, $year);
    }

    public function previousDay(): Month{
        $day = $this->day -1;
        $month = $this->month;
        $year=$this->year;
        if($day < 1){
            $day = 7;
            $month -= 1;
            if($month < 1){
                $month = 12;
                $year -= 1;
            }
        }
        return new Month($month, $year);
    }
}

