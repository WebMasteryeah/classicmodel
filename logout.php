<?php
    session_start();
    session_destroy();
    $nav = "";
    $title = "Logout";
    $content = "loggedout.php";
    include("master.php");
?>
