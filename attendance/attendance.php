<?php
session_start();
if (isset($_SESSION['user']) == "") {
    header("Location: index.php");
}
require_once("./config/properties.php");
require_once("./class/attendanceAction.php");
$action = new attendanceAction();
$action->attendanceNow($_SESSION['user']);
$action->attendanceDate($_SESSION['user']);
header("Location: index.php");