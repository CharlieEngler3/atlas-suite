<?php
    session_start(); 

    include("../../../password.php");

    $conn = new mysqli($servername, $server_user, $serverpassword, "connect");

    if(!isset($_POST['message']) || !isset($_POST['connectedUser']))
    {
        echo "<script>window.history.back();</script>";
    }
    else
    {
        $receiving = $_POST['connectedUser'];
        $username = $_SESSION['username'];
        $message = $_POST['message'];
        $time = time();

        $conn->query("INSERT INTO chat(username, message, receiving, time) VALUES ('$username', '$message', '$receiving', '$time')");

        echo "<script>location.href='index.php?ConnectedUser=".$receiving."';</script>";
    }
?>