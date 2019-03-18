<?php
namespace Calendar;
use App\Validator;
class  EventValidator extends Validator {
    /**
     * @param array $data
     * @return array bool
     */
    public function validates(array $data){
        parent::validates($data);
        $this->validates('name', 'minLength', 3);
        $this->validates('date', 'date');
        $this->validates('start', 'beforeTime', 'end');
        return $this->errors;
    }
}