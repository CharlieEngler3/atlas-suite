<?php
    session_start();

?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../style/dark.css">

        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Edit Tasks</title>

        <a href="index.php">Back</a>
    </head>
</html>

<?php

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    $title = $_POST['title'];

    if(isset($_POST['delete']))
    {
        $conn->query("DELETE FROM tasks WHERE title='$title'");

        echo "<script>location.href='index.php';</script>";
    }

    if(isset($_POST['edit']))
    {
        $result = $conn->query("SELECT * FROM tasks WHERE title='$title'");

        while($row = $result->fetch_assoc())
        {
            echo "<form method='POST' action='#' class='task' autocomplete='off'>";
            echo "<input type='text' class='task_title_form' name='new_title' value='".$row['title']."'>";
            echo "<input type='text' class='task_notes_form' value='".$row['notes']."' name='new_notes'>";
            echo "<input type='hidden' name='old_title' value='".$title."'>";
            echo "<input type='submit' value='Submit Changes' class='task_create'>";
            echo "</form>";
        }
    }

    if(isset($_POST['new_title']) && isset($_POST['new_notes']))
    {
        $new_title = $_POST['new_title'];
        $new_notes = $_POST['new_notes'];
        $title = $_POST['old_title'];

        $conn->query("UPDATE tasks SET title='$new_title', notes='$new_notes' WHERE title='$title'");

        echo "<script>location.href='index.php'</script>";
    }
?>