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
            function SubmitForm(title, notes, name, action)
            {
                location.href = "edit.php?title=" + title + "&notes=" + notes + "&name=" + name + "&action=" + action;
            }

            function CreateTask()
            {
                var parent = document.getElementById("tasks");

                var newTask = document.createElement("INPUT");

                newTask.setAttribute("type", "text");
                newTask.className = "task_notes_form";
                newTask.placeholder = "Task";
                newTask.name = "notes[]";

                var hidden = document.createElement("INPUT");

                hidden.setAttribute("type", "hidden");
                hidden.name = "notes[]";
                hidden.value = "✗";

                parent.appendChild(hidden);
                parent.appendChild(newTask);
                parent.appendChild(document.createElement("BR"));
            }

            function RemoveTask()
            {
                var parent = document.getElementById("tasks");

                if(parent.childNodes.length > 7)
                {
                    parent.removeChild(parent.childNodes[parent.childNodes.length-1]);
                    parent.removeChild(parent.childNodes[parent.childNodes.length-1]);
                    parent.removeChild(parent.childNodes[parent.childNodes.length-1]);
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
                <input type="button" onclick="RemoveTask();" class="task_remove" value="Remove Task">
                <input type="text" class="task_title_form" placeholder="Title" name="title">
                <div id="tasks">
                    <input type="hidden" name="notes[]" value="✗">
                    <input type="text" class="task_notes_form" placeholder="Task" name="notes[]">
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

                    for($i = 0; $i < count($notestemp); $i++)
                    {
                        $exploded = explode("✓", $notestemp[$i]);

                        if(count($exploded) > 1)
                        {
                            for($j = 0; $j < count($exploded); $j++)
                            {
                                if($j == 0)
                                {
                                    array_push($unchecked, $exploded[$j]);
                                }
                                else
                                {
                                    array_push($checked, $exploded[$j]);
                                }
                            }
                        }
                        else
                        {
                            array_push($unchecked, $notestemp[$i]);
                        }
                    }

                    echo "<form method='POST' action='edit.php' class='task'>";
                    echo "<input type='hidden' name='title' value='".$row['title']."'>";
                    echo "<div class='task_title'>".$row['title']."</div>";

                    for($i = 0; $i < count($unchecked); $i++)
                    {
                        if($unchecked[$i] != "")
                        {
                            echo "<div class='task_notes' onclick='SubmitForm(\"".$row['title']."\", \"".$row['notes']."\", \"".$unchecked[$i]."\", \"check\");'><input type='checkbox' class='task_notes' value='".$unchecked[$i]."'/>";
                            echo "<label for='".$unchecked[$i]."'>".$unchecked[$i]."</label></div>";
                        }
                    }

                    for($i = 0; $i < count($checked); $i++)
                    {
                        if($checked[$i] != "")
                        {
                            echo "<div style='text-decoration: line-through;' class='task_notes' onclick='SubmitForm(\"".$row['title']."\", \"".$row['notes']."\", \"".$checked[$i]."\", \"uncheck\");'><input type='checkbox' class='task_notes' value='".$checked[$i]."' checked/>";
                            echo "<label for='".$checked[$i]."'>".$checked[$i]."</label></div>";
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