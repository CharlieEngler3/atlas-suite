<?php
    session_start();
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../style/dark.css">

        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Edit Tasks</title>

        <div class="user_bar">
            <a href="index.php">Back</a>
        </div>

        <script>
            function CreateTask()
            {
                var parent = document.getElementById("tasks");

                var newTask = document.createElement("INPUT");

                newTask.setAttribute("type", "text");
                newTask.className = "task_notes_form";
                newTask.placeholder = "Task";
                newTask.name = "new_notes_unchecked[]";

                var newDate = document.createElement("INPUT");

                newDate.setAttribute("type", "date");
                newDate.className = "task_notes_date";
                newDate.name = "date[]";

                parent.appendChild(newTask);
                parent.appendChild(newDate);
                parent.appendChild(document.createElement("BR"));
            }

            function RemoveTask()
            {
                var parent = document.getElementById("tasks");

                parent.removeChild(parent.childNodes[parent.childNodes.length-1]);
                parent.removeChild(parent.childNodes[parent.childNodes.length-1]);
            }
        </script>
    </head>
</html>

<?php

    include("../../../password.php");

    $servername = "localhost";
    $server_user = "root";

    $conn = new mysqli($servername, $server_user, $serverpassword, "task_manager");
    
    $checkbox_text = "<br/><div onclick='SubmitForm(this);'><input type=checkbox name=check></div>";
    $checkedbox_text = "<br/><div onclick='SubmitForm(this);'><input type=checkbox name=check checked></div>";

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
            $notestemp = explode("✗", $row['notes']);
            $checked = array();
            $unchecked = array();

            $datestemp = explode("✗", $row['dates']);
            $checkedDates = array();
            $uncheckedDates = array();

            for($i = 0; $i < count($notestemp); $i++)
            {
                $exploded = explode("✓", $notestemp[$i]);
                $explodedDates = explode("✓", $datestemp[$i]);

                if(count($exploded) > 1)
                {
                    for($j = 0; $j < count($exploded); $j++)
                    {
                        if($j == 0)
                        {
                            if($exploded[$j])
                            {
                                array_push($unchecked, $exploded[$j]);
                            }
                        }
                        else
                        {
                            if($exploded[$j])
                            {
                                array_push($checked, $exploded[$j]);
                            }
                        }
                    }
                }
                else
                {
                    if($notestemp[$i])
                    {
                        array_push($unchecked, $notestemp[$i]);
                    }
                }

                if(count($explodedDates) > 1)
                {
                    for($j = 0; $j < count($explodedDates); $j++)
                    {
                        if($j == 0)
                        {
                            if($explodedDates[$j])
                            {
                                array_push($uncheckedDates, $explodedDates[$j]);
                            }
                        }
                        else
                        {
                            if($explodedDates[$j])
                            {
                                array_push($checkedDates, $explodedDates[$j]);
                            }
                        }
                    }
                }
                else
                {
                    if($datestemp[$i])
                    {
                        array_push($uncheckedDates, $datestemp[$i]);
                    }
                }
            }

            echo "<form method='POST' action='#' class='create_task' autocomplete='off'>";

    ?>
            <input type="button" onclick="CreateTask();" class="task_add" value="Add Task">
            <input type="button" onclick="RemoveTask();" class="task_remove" value="Remove Task">
    <?php

            echo "<input type='text' class='task_title_form' name='new_title' value='".$title."'>";
            echo "<br/>";
            echo "<div id='tasks'>";

            for($i = 0; $i < count($unchecked); $i++)
            {
                echo "<input type='text' class='task_notes_form' value='".$unchecked[$i]."' name='new_notes_unchecked[]'><input type='date' name='new_dates_unchecked[]' value='".$uncheckedDates[$i]."'><br>";
            }

            for($i = 0; $i < count($checked); $i++)
            {
                echo "<input type='text' style='text-decoration: line-through;' class='task_notes_form' value='".$checked[$i]."' name='new_notes_checked[]'><input type='date' name='new_dates_checked[]' value='".$checkedDates[$i]."'><br>";
            }

            echo "</div>";
            echo "<input type='hidden' name='old_title' value='".$title."'>";
            echo "<input type='submit' value='Submit Changes' class='task_create'>";
            echo "</form>";
        }
    }

    if(isset($_POST['new_title']) && (isset($_POST['new_notes_unchecked']) || isset($_POST['new_notes_checked'])) && (isset($_POST['new_dates_unchecked']) || isset($_POST['new_dates_checked'])))
    {
        if(isset($_POST['new_notes_unchecked']))
        {
            $new_notes_unchecked = implode("✗", $_POST['new_notes_unchecked']);
        }
        else
        {
            $new_notes_unchecked = "";
        }

        if(isset($_POST['new_notes_checked']))
        {
            $new_notes_checked = implode("✓", $_POST['new_notes_checked']);
        }
        else
        {
            $new_notes_checked = "";
        }

        if(isset($_POST['new_dates_unchecked']))
        {
            $new_dates_unchecked = implode("✗", $_POST['new_dates_unchecked']);
        }
        else
        {
            $new_dates_unchecked = "";
        }

        if(isset($_POST['new_dates_checked']))
        {
            $new_dates_checked = implode("✓", $_POST['new_dates_checked']);
        }
        else
        {
            $new_dates_checked = "";
        }

        $new_title = str_replace("'", '’', $_POST['new_title']);
        $new_notes_unchecked = str_replace("'", '’', $new_notes_unchecked);
        $new_notes_checked = str_replace("'", '’', $new_notes_checked);

        $final_notes = "✗".$new_notes_unchecked."✓".$new_notes_checked;

        $final_dates = "✗".$new_dates_unchecked."✓".$new_dates_checked;

        $title = $_POST['old_title'];

        $conn->query("UPDATE tasks SET title='$new_title', notes='$final_notes', dates='$final_dates' WHERE title='$title'");

        echo "<script>location.href='index.php'</script>";
    }

    if(isset($_GET['title']) && isset($_GET['name']) && isset($_GET['action']))
    {
        $title = $_GET['title'];
        $notes = $_GET['notes'];
        $dates = $_GET['dates'];
        $name = $_GET['name'];
        $date = $_GET['date'];
        $action = $_GET['action'];

        if($action == "check")
        {
            $notes = str_replace("✗".$name, "✓".$name, $notes);
            $dates = str_replace("✗".$date, "✓".$date, $dates);

            $conn->query("UPDATE tasks SET notes='$notes', dates='$dates' WHERE title='$title'");
        }
        
        if($action == "uncheck")
        {
            $notes = str_replace("✓".$name, "✗".$name, $notes);
            $dates = str_replace("✓".$date, "✗".$date, $dates);

            $conn->query("UPDATE tasks SET notes='$notes', dates='$dates' WHERE title='$title'");
        }

        echo "<script>location.href='index.php'</script>";
    }
?>