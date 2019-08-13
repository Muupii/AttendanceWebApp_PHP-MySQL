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
    $elapsedSeconds = $attendanceAction->getElapsedSeconds($_SESSION['user']);
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
    <a href="index.php" class="title">Attendance</a>
    <p>Attendance number of people: <?php echo $attendanceNumber ?></p>
    
    <?php if (isset($_SESSION['user']) != "") { ?>
    
    <p>username: <?php echo $name; ?></p>
    
    <a href="logout.php" class="btn">logout</a>

        <?php if ($attendance == 0) { ?>

        <p>Are you attendance?</p>
        <a href="/attendance.php" class="btn">yes</a>

        <?php } else { ?>
        <p>elapsed time: <?php echo $elapsedSeconds; ?> seconds</p>
        <p>Are you leaving a lab?</p>
        <a href="/leaving.php" class="btn">yes</a>
        
        <?php } ?>

    <a href="/attendeesList.php" class="btn menu">Attendees List</a>
    <a href="/ranking.php" class="btn menu">Ranking</a>
    <?php } else { ?>
    
    <a href="/login.php" class="btn">login</a>
    <a href="/register.php" class="btn">new comer</a>
    
    <?php } ?>
</body>
</html>
