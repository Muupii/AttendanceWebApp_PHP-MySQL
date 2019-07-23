<?php
session_start();
if (isset($_SESSION['user']) != "") {
    require_once("./config/properties.php");
    require_once("./class/nameAction.php");
    require_once("./class/attendanceAction.php");
    $action = new nameAction();
    $name=$action->name($_SESSION['user']);
    
    $attendanceAction = new attendanceAction();
    $attendance = $attendanceAction->attendance($_SESSION['user']);
    $attendanceNumber = $attendanceAction->countAttendance();
    $names = $attendanceAction->getAttendeesNames();
}



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Attendance</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <a href="index.php" class="title">Attendance in Umeken</a>
    <p>Attendance number of people: <?php echo $attendanceNumber ?></p>
    <div class="list">
    <ul>
    <?php foreach ($names as $name) : ?>
    
    <li><?php echo $name ?></li>
    
    <?php endforeach; ?>
    </ul>
    </div>
</body>
</html>