<?php
    session_start();

    $servername = "localhost";
    $server_user = "root";
  
    $conn = new mysqli($servername, $server_user, "", "task_manager");

    if(isset($_SESSION['username']))
    {
        $username = $_SESSION['username'];
    }
?>

<html>
    <head>
        <link rel="stylesheet" type="text/css" href="../../style/dark.css">

        <title>Task Manager</title>

        <a href="../../index.php">Home</a>
        <?php
            if(!isset($_SESSION['username']))
            {
                echo "<a href='../../user/signin.php'>Sign In</a>";
            }
            else
            {
                echo "<a href='../../user/profile.php'>Profile</a>";
            }
        ?>
    </head>

    <body>
        <h1>Task Manager</h1>
        <?php
            if(isset($_SESSION['username']))
            {
        ?>
            <form class="new_task" action="create.php" method="POST">
                <input type="text" class="task_title_form" placeholder="Title of Task" name="title">
                <input type="text" class="task_notes_form" placeholder="Additional Notes" name="notes">
                <input type="submit" class="task_create" value="Create">
            </form>
        <?php
            }
            else
            {
                echo "<div class='new_task'><h2>Please <a href='../../user/signin.php'>Sign In</a> for this feature.</h2></div>";
            }
        ?>

        <?php
            if(isset($_SESSION['username']))
            {
                $result = $conn->query("SELECT * FROM tasks WHERE user = '$username'");

                while($row = $result->fetch_assoc())
                {
                    echo "<form method='POST' action='edit.php' class='task'>";
                    echo "<input type='submit' name='edit' class='task_edit' value='Edit'>";
                    echo "<input type='submit' name='delete' class='task_delete' value='X'>";
                    echo "<input type='hidden' name='title' value='".$row['title']."'>";
                    echo "<div class='task_title'>".$row['title']."</div>";
                    echo "<div class='task_notes'>".$row['notes']."</div>";
                    echo "</form>";
                }
            }
        ?>
    </body>
</html>