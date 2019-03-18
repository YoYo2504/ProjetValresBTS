<?php
class App{

    static $db = null;

    static function getDatabase(){
        if(!self::$db){
            self::$db = new database('root', 'YoYo250497', 'planningFormation');
        }

        return self::$db;
    }
}