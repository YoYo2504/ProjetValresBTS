<?php
namespace Calendar;
class Event{

    private $id;

    private $descriptionName;

    private $description;

    private $startEvent;

    private $endEvent;

    public function  getId(): int{
        return $this->id;
    }

    public function  getDescriptionName(){
        return $this->descriptionName;
    }

    public function  getDescription(){
        return $this->description ?? '';
    }

    public function  getStartEvent(): \DateTimeInterface{
        return new \DateTimeImmutable($this->startEvent);
    }

    public function  getEndEvent(): \DateTimeInterface{
        return new \DateTimeImmutable($this->endEvent);
    }

    public function setDescriptionName($descriptionName){
        $this->descriptionName =$descriptionName ;
    }

    public function setDescription($description){
        $this->description=$description ;
    }

    public function setStart($startEvent){
        $this->startEvent = $startEvent;
    }

    public function setEnd($endEvent){
        $this->endEvent=$endEvent ;
    }

    public function setEndEvent($endEvent){
        $this->endEvent=$endEvent ;
    }

    public function setStartEvent($startEvent){
        $this->startEvent = $startEvent;
    }

}