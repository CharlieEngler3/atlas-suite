<?php
    session_start();

    $username = $_SESSION['username'];
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
                newTask.className = "edit_task_notes_form";
                newTask.placeholder = "Task";
                newTask.name = "new_notes_unchecked[]";

                var newDate = document.createElement("INPUT");

                newDate.setAttribute("type", "date");
                newDate.className = "task_notes_date";
                newDate.name = "new_dates_unchecked[]";

                var deleteButton = document.createElement("INPUT");

                deleteButton.setAttribute("type", "button");
                deleteButton.className = "task_notes_delete";
                deleteButton.value = "x";
                deleteButton.setAttribute("onclick", "RemoveTask(" + (parent.childElementCount) + ")");

                parent.appendChild(newTask);
                parent.appendChild(newDate);
                parent.appendChild(deleteButton);
                parent.appendChild(document.createElement("BR"));
            }

            function RemoveTask(offset)
            {
                var parent = document.getElementById("tasks");

                parent.removeChild(parent.childNodes[offset]);
                parent.removeChild(parent.childNodes[offset]);
                parent.removeChild(parent.childNodes[offset]);
                parent.removeChild(parent.childNodes[offset]);

                var otherDeleteBtns = document.getElementsByClassName("task_notes_delete");

                for(let i = 0; i < otherDeleteBtns.length; i++)
                {
                    let rmVal = otherDeleteBtns[i].getAttribute("onclick");

                    let rmOffset = parseInt(rmVal.substring(rmVal.lastIndexOf("(") + 1, rmVal.lastIndexOf(")")));

                    if(rmOffset > offset)
                    {
                        rmOffset -= 4;

                        otherDeleteBtns[i].setAttribute("onclick", "RemoveTask(" + rmOffset + ")");
                    }
                }
            }
        </script>
    </head>
</html>

<?php

    include("../../../password.php");

    $conn = new mysqli($servername, $server_user, $serverpassword, "task_manager");
    $conn2 = new mysqli($servername, $server_user, $serverpassword, "notifications");
    
    $checkbox_text = "<br/><div onclick='SubmitForm(this);'><input type=checkbox name=check></div>";
    $checkedbox_text = "<br/><div onclick='SubmitForm(this);'><input type=checkbox name=check checked></div>";

    if(isset($_POST['title']))
    {
        $title = $_POST['title'];
    }
    
    if(isset($_POST['delete']))
    {
        $result = $conn->query("SELECT * FROM tasks WHERE title='$title' AND user='$username'");

        while($row = $result->fetch_assoc())
        {
            $notestemp = explode("✗", $row['notes']);
            $unchecked = array();

            for($i = 0; $i < count($notestemp); $i++)
            {
                $exploded = explode("✓", $notestemp[$i]);

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
                    }
                }
                else
                {
                    if($notestemp[$i])
                    {
                        array_push($unchecked, $notestemp[$i]);
                    }
                }
            }

            for($i = 0; $i < count($unchecked); $i++)
            {
                $conn2->query("DELETE FROM notifications WHERE text LIKE '%$unchecked[$i]%' AND username='$username'");
            }
        }

        $conn->query("DELETE FROM tasks WHERE title='$title' AND user='$username'");

        echo "<script>location.href='index.php';</script>";
    }

    if(isset($_POST['edit']))
    {
        $result = $conn->query("SELECT * FROM tasks WHERE title='$title' AND user='$username'");

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
            <br/>
    <?php

            echo "<input type='text' class='task_title_form' name='new_title' maxlength='100' value='".$title."'>";
            echo "<br/>";
            echo "<div id='tasks'>";

            if(count($unchecked) > 0)
            {
                for($i = 1; $i < count($uncheckedDates); $i++)
                {
                    if($uncheckedDates[$i] == $uncheckedDates[$i-1])
                    {
                        $uncheckedDates[$i-1] = $uncheckedDates[$i-1].($i-1);
                    }
                }

                $unchecked = array_combine($uncheckedDates, $unchecked);
                ksort($unchecked);
                sort($uncheckedDates);

                for($i = 0; $i < count($uncheckedDates); $i++)
                {
                    if(strlen($uncheckedDates[$i]) > 10)
                    {
                        $uncheckedDates[$i] = substr_replace($uncheckedDates[$i] ,"", -1);
                    }
                }

                $unchecked = array_values($unchecked);

                for($i = 0; $i < count($unchecked); $i++)
                {
                    echo "<input type='text' class='edit_task_notes_form' value='".$unchecked[$i]."' maxlength='300' name='new_notes_unchecked[]'><input type='date' class='task_notes_date' name='new_dates_unchecked[]' value='".$uncheckedDates[$i]."'>";
                    echo "<input type='button' class='task_notes_delete' value='x' onclick='RemoveTask(".($i*4).")'>";
                    echo "<br>";
                }
            }

            if(count($checked) > 0)
            {
                $checked = array_combine($checkedDates, $checked);
                ksort($checked);
                sort($checkedDates);

                $checked = array_values($checked);

                for($i = 0; $i < count($checked); $i++)
                {
                    echo "<input type='text' style='text-decoration: line-through;' class='edit_task_notes_form' maxlength='300' value='".$checked[$i]."' name='new_notes_checked[]'><input type='date' class='task_notes_date' name='new_dates_checked[]' value='".$checkedDates[$i]."'>";
                    echo "<input type='button' class='task_notes_delete' value='x' onclick='RemoveTask(".($i*4).")'>";
                    echo "<br>";
                }
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

        $result = $conn2->query("SELECT * FROM notifications WHERE username='$username'");

        while($row = $result->fetch_assoc())
        {
            $numResults = 0;

            $notification = $row['text'];

            $unchecked = $_POST['new_notes_unchecked'];

            for($i = 0; $i < count($unchecked); $i++)
            {
                if(strpos($notification, $unchecked[$i]) !== false)
                {
                    $numResults++;
                }
            }

            if($numResults == 0)
            {
                $conn2->query("DELETE FROM notifications WHERE text='$notification' AND username='$username'");
            }
        }

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

            $conn->query("UPDATE tasks SET notes='$notes', dates='$dates' WHERE title='$title' AND user='$username'");

            $conn2->query("DELETE FROM notifications WHERE text LIKE '%$name%' AND username='$username'");
        }
        
        if($action == "uncheck")
        {
            $notes = str_replace("✓".$name, "✗".$name, $notes);
            $dates = str_replace("✓".$date, "✗".$date, $dates);

            $conn->query("UPDATE tasks SET notes='$notes', dates='$dates' WHERE title='$title' AND user='$username'");
        }

        echo "<script>location.href='index.php'</script>";
    }
?>