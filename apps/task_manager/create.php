<?php
    session_start();

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    $username = $_SESSION['username'];

    $notes = implode("", $_POST['notes']);

    $title = str_replace("'", '’', $_POST['title']);
    $notes = str_replace("'", '’', $notes);

    $conn->query("INSERT INTO tasks (title, notes, user) VALUES ('$title', '$notes', '$username')");

    echo "<script>location.href='index.php';</script>";
?>