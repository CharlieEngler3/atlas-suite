<?php
    session_start();

	include("../../../password.php");

	$servername = "localhost";
	$server_user = "root";
  
	$conn = new mysqli($servername, $server_user, $serverpassword, "task_manager");
	  
    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../style/dark.css">

        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Task Manager</title>

        <div class="user_bar">
            <a href="../../index.php">Home</a>
        </div>

        <?php
            if(!isset($_SESSION['username']))
            {
        ?>
                <div class="user_bar">
                    <a href='../../user/signin.php'>Sign In</a>
                </div>
        <?php
                
            }
            else
            {
        ?>
                <div class="user_bar">
                    <a href='../../user/profile.php'>Profile</a>
                </div>
        <?php
            }
        ?>

        <script>
            function SubmitForm(title, notes, dates, name, date, action)
            {
                location.href = "edit.php?title=" + title + "&notes=" + notes + "&dates=" + dates + "&name=" + name + "&date=" + date + "&action=" + action;
            }

            function CreateTask()
            {
                var parent = document.getElementById("tasks");

                var newTask = document.createElement("INPUT");

                newTask.setAttribute("type", "text");
                newTask.className = "task_notes_form";
                newTask.placeholder = "Task";
                newTask.name = "notes[]";

                var newDate = document.createElement("INPUT");

                newDate.setAttribute("type", "date");
                newDate.className = "task_notes_date";
                newDate.name = "date[]";

                var deleteButton = document.createElement("INPUT");

                deleteButton.setAttribute("type", "button");
                deleteButton.className = "task_notes_delete";
                deleteButton.value = "x";
                deleteButton.setAttribute("onclick", "RemoveTask(" + (parent.childElementCount+5) + ")");

                var hidden = document.createElement("INPUT");

                hidden.setAttribute("type", "hidden");
                hidden.name = "notes[]";
                hidden.value = "✗";

                parent.appendChild(hidden);
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
                parent.removeChild(parent.childNodes[offset]);

                var otherDeleteBtns = document.getElementsByClassName("task_notes_delete");

                for(let i = 0; i < otherDeleteBtns.length; i++)
                {
                    let rmVal = otherDeleteBtns[i].getAttribute("onclick");

                    let rmOffset = parseInt(rmVal.substring(rmVal.lastIndexOf("(") + 1, rmVal.lastIndexOf(")")));

                    if(rmOffset > offset)
                    {
                        rmOffset -= 5;

                        otherDeleteBtns[i].setAttribute("onclick", "RemoveTask(" + rmOffset + ")");
                    }
                }
            }
        </script>
    </head>

    <body>
        <h1>Task Manager</h1>
        <?php
            if(isset($_SESSION['username']))
            {
        ?>
            <form class="create_task" action="create.php" method="POST">
                <input type="button" onclick="CreateTask();" class="task_add" value="Add Task">
                <br/>
                <input type="text" class="task_title_form" placeholder="Title" name="title">
                <div id="tasks">
                    <input type="hidden" name="notes[]" value="✗">
                    <input type="text" class="task_notes_form" placeholder="Task" name="notes[]">
                    <input type="date" class="task_notes_date" name="date[]">
                    <br>
                </div>
                <input type="submit" class="task_create" value="Create">
            </form>
        <?php
            }
            else
            {
        ?>
                    <h2 class="new_user_prompt">Please <a href='../../user/signin.php'>Sign In</a> for this feature.</h2>
        <?php
            }
        ?>

        <?php
            if(isset($_SESSION['username']))
            {
                $result = $conn->query("SELECT * FROM tasks WHERE user = '$username'");

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

                    echo "<form method='POST' action='edit.php' class='task'>";
                    echo "<input type='hidden' name='title' value='".$row['title']."'>";
                    echo "<div class='task_title'>".$row['title']."</div>";
                    
                    

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
                            echo "<div class='task_notes' onclick='SubmitForm(\"".$row['title']."\", \"".$row['notes']."\", \"".$row['dates']."\", \"".$unchecked[$i]."\", \"".$uncheckedDates[$i]."\", \"check\");'><input type='checkbox' class='task_notes' id='".$unchecked[$i]."' value='".$unchecked[$i]."'/>";
                            echo "<label for='".$unchecked[$i]."'>".$unchecked[$i]."</label><input type='date' class='task_date' readonly value='".$uncheckedDates[$i]."'></div>";
                        }
                    }
                    
                    if(count($checked) > 0)
                    {
                        for($i = 1; $i < count($uncheckedDates); $i++)
                        {
                            if($uncheckedDates[$i] == $uncheckedDates[$i-1])
                            {
                                $uncheckedDates[$i-1] = $uncheckedDates[$i-1].($i-1);
                            }
                        }

                        $checked = array_combine($checkedDates, $checked);
                        ksort($checked);
                        sort($checkedDates);

                        for($i = 0; $i < count($uncheckedDates); $i++)
                        {
                            if(strlen($uncheckedDates[$i]) > 10)
                            {
                                $uncheckedDates[$i] = substr_replace($uncheckedDates[$i] ,"", -1);
                            }
                        }

                        $checked = array_values($checked);

                        for($i = 0; $i < count($checked); $i++)
                        {
                            echo "<div style='text-decoration: line-through;' class='task_notes' onclick='SubmitForm(\"".$row['title']."\", \"".$row['notes']."\", \"".$row['dates']."\", \"".$checked[$i]."\", \"".$checkedDates[$i]."\", \"uncheck\");'><input type='checkbox' class='task_notes' id='".$checked[$i]."' value='".$checked[$i]."' checked/>";
                            echo "<label for='".$checked[$i]."'>".$checked[$i]."</label><input type='date' class='task_date' readonly value='".$checkedDates[$i]."'></div>";
                        }
                    }
                    
                    echo "<input type='submit' name='edit' class='task_edit' value='Edit'>";
                    echo "<input type='submit' name='delete' class='task_delete' value='Delete'>";
                    echo "</form>";
                }
            }
        ?>
    </body>
</html>