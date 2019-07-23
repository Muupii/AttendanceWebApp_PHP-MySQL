<?php
class nameAction {
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

    public function name($id) {
        $smt = $this->pdo->prepare('select name from list where id=:id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        $name = $result['name'];
        return $name;
    }
}