<?php
session_start();
if (isset($_SESSION['user']) == "") {
    header("Location: index.php");
}
require_once("./config/properties.php");
require_once("./class/attendanceAction.php");
$action = new attendanceAction();
$action->leavingNow($_SESSION['user']);
$action->leavingDate($_SESSION['user']);
$action->updateTotalSeconds($_SESSION['user']);
header("Location: index.php");