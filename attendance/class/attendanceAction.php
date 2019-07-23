<?php
class attendanceAction {
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

    public function attendance($id) {
        $smt = $this->pdo->prepare('select attendance from list where id=:id');
        $smt->bindParam(':id',$id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['attendance'];
    }
   
    public function attendanceNow($id) {
        $smt = $this->pdo->prepare('update list set attendance = 1 where id = :id');
        $smt->bindParam(':id',$id, PDO::PARAM_INT);
        $smt->execute();
    }

    public function attendanceDate($id) {
        $date = date('Y-m-d H:i:s');
        $smt = $this->pdo->prepare('update list set attendanceDate = :date where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->bindParam(':date', $date, PDO::PARAM_STR);
        $smt->execute();
    }

    public function getAttendanceDate($id) {
        $smt = $this->pdo->prepare('select attendanceDate from list where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['attendanceDate'];
    }

    public function leavingNow($id) {
        $smt = $this->pdo->prepare('update list set attendance = 0 where id = :id');
        $smt->bindParam(':id',$id, PDO::PARAM_INT);
        $smt->execute();
    }

    public function leavingDate($id) {
        $date = date('Y-m-d H:i:s');
        $smt = $this->pdo->prepare('update list set leavingDate = :date where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->bindParam(':date', $date, PDO::PARAM_STR);
        $smt->execute();
    }

    public function getLeavingDate($id) {
        $smt = $this->pdo->prepare('select leavingDate from list where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['leavingDate'];
    }

    public function getTotalSeconds($id) {
        $smt = $this->pdo->prepare('select COALESCE(totalSeconds, 0) from list where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['COALESCE(totalSeconds, 0)'];
    }

    public function updateTotalSeconds($id) {
        $attendanceDate = $this->getAttendanceDate($id);
        $leavingDate = $this->getLeavingDate($id);
        $seconds = strtotime($leavingDate) - strtotime($attendanceDate);
        $totalSeconds = $seconds + $this->getTotalSeconds($id);
        $smt = $this->pdo->prepare('update list set totalSeconds = :totalSeconds where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->bindParam(':totalSeconds', $totalSeconds, PDO::PARAM_INT);
        $smt->execute();
    }

    public function getElapsedSeconds($id) {
        $attendanceDate = $this->getAttendanceDate($id);
        $elapsedSeconds = strtotime("now") - strtotime($attendanceDate);
        return $elapsedSeconds;
    }

    public function updateElapsedTotalSeconds($id) {
        $elapsedSeconds = $this->getElapsedSeconds($id);
        $totalSeconds = $this->getTotalSeconds($id);
        $elapsedTotalSeconds = $elapsedSeconds + $totalSeconds;
        
        $smt = $this->pdo->prepare('update list set elapsedTotalSeconds = :elapsedTotalSeconds where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->bindParam(':elapsedTotalSeconds', $elapsedTotalSeconds, PDO::PARAM_INT);
        $smt->execute();
    }

    public function getElapsedTotalSeconds($id) {
        $smt = $this->pdo->prepare('select COALESCE(elapsedTotalSeconds, 0) from list where id = :id');
        $smt->bindParam(':id', $id, PDO::PARAM_INT);
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['COALESCE(elapsedTotalSeconds, 0)'];
    }


    public function countAttendance() {
        $smt = $this->pdo->prepare('select count(*) from list where attendance = 1');
        $smt->execute();
        $result = $smt->fetch(PDO::FETCH_ASSOC);
        return $result['count(*)'];
    }
    
    public function getAttendeesNames() {
        foreach($this->pdo->query('SELECT name FROM list where attendance = 1') as $row) {    
            $results[] = $row['name'];
            }
        return $results;
    }

    public function getRankingIds() {
        foreach($this->pdo->query('SELECT id FROM list order by totalSeconds DESC') as $row) {    
            $results[] = $row['id'];
            }
        return $results;
    }

    public function getElapsedRankingIds() {
        foreach($this->pdo->query('SELECT id FROM list order by elapsedTotalSeconds DESC') as $row) {    
            $results[] = $row['id'];
            }
        return $results;
    }
}