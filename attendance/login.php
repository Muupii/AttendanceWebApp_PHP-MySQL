<?php
ob_start();
session_start();
if( isset($_SESSION['user']) != "") {
  header("Location: index.php");
}
require_once("./config/properties.php");
require_once("./class/loginAction.php");

$action = new loginAction();

$eventId = null;


if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
}

if ($eventId === 'login') {
    $action->login($_POST);
    header("location: index.php");
    $eventId = null;
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
    <div class="container">
        <a href="index.php" class="title">Attendance in Umeken</a>
        <form action="" method="post" id="form">
            <table align="center">
                <tr>
                    <td>user name</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>password</td>
                    <td><input type="text" name="password"></td>
                </tr>
            </table>
            <input type="hidden" name="eventId" value="login">
            <input type="submit" value="login">
            
        </form>
    </div>
</body>
</html>