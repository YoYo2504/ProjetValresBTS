<?php
namespace Calendar;
use App\Validator;
class  EventValidator extends Validator {
    /**
     * @param array $data
     * @return array bool
     */
    public function validates($data){
        parent::validates($data);
        $this->validate('descriptionName', 'minLength', 3);
        $this->validate('date', 'date');
        $this->validate('start', 'beforeTime', 'end');
        //$this->validate('end', 'afterTime', 'start');
        return $this->errors;
    }
}