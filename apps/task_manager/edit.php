<?php
    session_start();

    //print_r($_POST);
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../style/dark.css">

        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Edit Tasks</title>

        <div class="user_bar">
            <a href="index.php">Back</a>
        </div>
    </head>
</html>

<?php

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    $checkbox_text = "<br/><input type=checkbox name=check onclick=SubmitForm(this);>";
    $checkedbox_text = "<br/><input type=checkbox name=check onclick=SubmitForm(this); checked>";

    if(isset($_POST['title']))
    {
        $title = $_POST['title'];
    }
    
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
            $notes = str_replace($checkbox_text, ":check:", $row['notes']);

            $notes = str_replace($checkedbox_text, ":checked:", $notes);

            echo "<form method='POST' action='#' class='create_task' autocomplete='off'>";
            echo "<input type='text' class='task_title_form' name='new_title' value='".$row['title']."'>";
            echo "<br/>";
            echo "<input type='text' class='task_notes_form' value='".$notes."' name='new_notes'>";
            echo "<br/>";
            echo "<input type='hidden' name='old_title' value='".$title."'>";
            echo "<input type='submit' value='Submit Changes' class='task_create'>";
            echo "</form>";
        }
    }

    if(isset($_POST['new_title']) && isset($_POST['new_notes']))
    {
        $new_title = str_replace("'", '’', $_POST['new_title']);
        $new_notes = str_replace("'", '’', $_POST['new_notes']);

        $new_notes = str_replace(":check:", $checkbox_text, $new_notes);

        $new_notes = str_replace(":checked:", $checkedbox_text, $new_notes);

        $title = $_POST['old_title'];

        $conn->query("UPDATE tasks SET title='$new_title', notes='$new_notes' WHERE title='$title'");

        echo "<script>location.href='index.php'</script>";
    }

    if(!isset($_POST['new_title']) && !isset($_POST['new_notes']) && !isset($_POST['edit']) && !isset($_POST['delete']))
    {
        $result = $conn->query("SELECT * FROM tasks WHERE title='$title'");

        while($row = $result->fetch_assoc())
        {
            $notes = str_replace($checkedbox_text, $checkbox_text, $row['notes']);

            if(isset($_POST['check']))
            {
                $notes = str_replace($checkbox_text, $checkedbox_text, $row['notes']);
            }

            $conn->query("UPDATE tasks SET notes='$notes' WHERE title='$title'");
        }

        echo "<script>location.href='index.php'</script>";
    }
?>