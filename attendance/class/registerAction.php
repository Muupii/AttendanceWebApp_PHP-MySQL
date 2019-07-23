<?php
class registerAction {
    public $pdo;

    function __construct(){
        try {
            $this->pdo = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
            // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function register($data) {
        $smt = $this->pdo->prepare('insert into list (name, password, attendance) values(:name, :password, 0)');
        $smt->bindParam(':name',$data['name'], PDO::PARAM_STR);
        $smt->bindParam(':password',$data['password'], PDO::PARAM_STR);
        $smt->execute();
    }
   
    

}