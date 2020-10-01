<?php
    session_start();

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    $checkbox_text = "<br/><input type=checkbox name=check onclick=SubmitForm(this);>";

    $username = $_SESSION['username'];

    $title = str_replace("'", '’', $_POST['title']);
    $notes = str_replace("'", '’', $_POST['notes']);

    $notes = str_replace(":check:", $checkbox_text, $notes);

    $result = $conn->query("INSERT INTO tasks (title, notes, user) VALUES ('$title', '$notes', '$username')");

    echo "<script>location.href='index.php';</script>";
?>