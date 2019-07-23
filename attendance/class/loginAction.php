<?php
class loginAction {
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

    public function login($data) {
        $smt = $this->pdo->prepare('select id,password from list where name=:name');
        $smt->bindParam(':name',$data['name'], PDO::PARAM_STR);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        $password = $result['password'];
        $id = $result['id'];
        if ($password == $data['password']) {
            $_SESSION['user'] = $id;
        }
    }
   
    

}