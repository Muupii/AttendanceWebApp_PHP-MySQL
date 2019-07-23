<?php
session_start();
if (isset($_SESSION['user']) != "") {
    header("location: index.php");
}
require_once("./config/properties.php");
require_once("./class/registerAction.php");
require_once("./class/loginAction.php");

$action = new registerAction();
$loginAction = new loginAction();
$eventId = null;


if (isset($_POST['eventId'])) {
    $eventId = $_POST['eventId'];
}

if ($eventId === 'register') {
        $action->register($_POST);
        $loginAction->login($_POST);
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
                    <td><input type="password" name="password"></td>
                </tr>
            </table>
            <input type="hidden" name="eventId" value="register">
            <input type="submit" value="welcome!">
        </form>
    </div>
</body>
</html>