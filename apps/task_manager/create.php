<?php
    session_start();

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    $username = $_SESSION['username'];

    $title = str_replace("'", '’', $_POST['title']);
    $notes = str_replace("'", '’', $_POST['notes']);

    $conn->query("INSERT INTO tasks (title, notes, user) VALUES ('$title', '$notes', '$username')");

    echo "<script>location.href='index.php';</script>";
?>