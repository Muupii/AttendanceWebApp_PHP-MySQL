<?php
session_start();
if (isset($_SESSION['user']) != "") {
    require_once("./config/properties.php");
    require_once("./class/nameAction.php");
    require_once("./class/attendanceAction.php");
    $action = new nameAction();
    $name=$action->name($_SESSION['user']);
    
    $attendanceAction = new attendanceAction();
    $attendanceAction->updateElapsedTotalSeconds($_SESSION['user']);
    $attendance = $attendanceAction->attendance($_SESSION['user']);
    $attendanceNumber = $attendanceAction->countAttendance();
    if ($attendance==0) {
        $ids = $attendanceAction->getRankingIds();
    } else {
        $ids = $attendanceAction->getElapsedRankingIds();
    }
    
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
    <div class="list">
    <p>ranking</p>
    <?php if ($attendance == 0) { ?>
        <ol>
        <?php foreach ($ids as $id) : ?>
        
            <li><?php echo $action->name($id); ?> : <?php echo $attendanceAction->getTotalSeconds($id); ?> seconds</li>
        
        <?php endforeach; ?>
        </ol>
    <?php } else { ?>

        <ol>
        <?php foreach ($ids as $id) : ?>
        
            <li><?php echo $action->name($id); ?> : <?php echo $attendanceAction->getElapsedTotalSeconds($id); ?> seconds</li>
        
        <?php endforeach; ?>
        </ol>

    <?php } ?>

    </div>
</body>
</html>
