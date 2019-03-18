<?php
class database{

/*
    const SERVER = '127.0.0.1';
    const NAME ='planningFormation';
    const USERNAME = 'root';
    const PASS='YoYo250497';

    public function __construct(){
        try{
            $pdo2 = new PDO('mysql:dname=' . SERVER . ';host=' . NAME ,USERNAME, PASS);
            $pdo2 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            $pdo2 ->query('SET CHARACTER SET UTF8');
            $pdo2->query('SET NAMES UTF8');
        }catch (Exception $ex){
            echo 'Exception reçue : ',  $ex->getMessage(), "\n";
        }
    }*/
// AVANT
    private $pdo2;

    public function __construct($login, $password, $database_name, $host = 'localhost'){
        $this->pdo2 = new PDO("mysql:dbname=$database_name; host =  $host",$login, $password);
        $this->pdo2 -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo2->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
    }

    /**
     * @param $query
     * @param bool|array $params
     * @return bool|PDOStatement
     *
     */
    public function query($query, $params = false){
        if($params){
            $req = $this->pdo2->prepare($query);
            $req->execute($params);
        }else{
            $req= $this->pdo2->query($query);
        }
        try{
            return $req;
        }catch (Exception $ex){
            echo 'Exception reçu:', $ex->getMessage(), "\n";
        }


    }

    public function lastInsertId(){
        return $this->pdo2->lastInsertId();
    }
}