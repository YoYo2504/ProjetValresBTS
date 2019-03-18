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

    public function  getDescriptionName(): string {
        return $this->descriptionName;
    }

    public function  getDescription(): string{
        return $this->description ?? '';
    }

    public function  getStartEvent(): \DateTimeInterface{
        return new \DateTimeImmutable($this->startEvent);
    }

    public function  getEndEvent(): \DateTimeInterface{
        return new \DateTimeImmutable($this->endEvent);
    }

    public function setDescriptionName(string $descriptionName){
        $this->descriptionName =$descriptionName ;
    }

    public function setDescription(string $description){
        $this->description=$description ;
    }

    public function setStart(string $startEvent){
        $this->startEvent = $startEvent;
    }

    public function setEnd(string $endEvent){
        $this->endEvent=$endEvent ;
    }

}