<?php
    session_start();

    $servername = "localhost";
    $server_user = "root";

    $conn = new mysqli($servername, $server_user, "", "notifications");
    
    if(isset($_POST['new_notification']))
    {
        $username = $_POST['username'];
        $text = $_POST['text'];

        $original_url = $_POST['original_url'];

        $conn->query("INSERT INTO notifications (username, text, seen) VALUES ('$username', '$text', false)");

        echo "<script>location.href='".$original_url."';</script>";
    }
    else if(isset($_POST['saw_notification']))
    {
        $username = $_POST['username'];
        $id = $_POST['id'];

        $conn->query("UPDATE notifications SET seen = true WHERE username = '$username' AND id = '$id'");
    }
    else if(isset($_POST['remove_notification']))
    {
        $username = $_POST['username'];
        $id = $_POST['id'];

        $conn->query("DELETE FROM notifications WHERE username = '$username' AND id = '$id'");
    }
    else if(isset($_POST['change_notification']))
    {
        $username = $_POST['username'];
        $id = $_POST['id'];
        $text = $_POST['change_notification'];

        $conn->query("UPDATE notifications SET text = '$text' WHERE username = '$username' AND id = '$id'");
    }
?>

<html>
    <head>
        <link rel='stylesheet' type='text/css' href='style/dark.css'>

        <meta name='viewport' content='width=device-width, initial-scale=1'>

        <title>Notifications</title>

        <div class="user_bar">
            <a href='index.php'>Home</a>
        </div>
    </head>

    <body>
        <h1 style="font-size:17vw;">Notifications</h1>

        <?php
            if(isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];

                $result = $conn->query("SELECT * FROM notifications WHERE username = '$username'");

                while($row = $result->fetch_assoc())
                {
                    echo "<form action='#' class='notification' method='POST'>";
                    echo "<div class='notification_text'>".$row['text']."</div>";
                    echo "<input type='hidden' name='username' value='".$username."'>";
                    echo "<input type='hidden' name='id' value='".$row['id']."'>";
                    if($row['seen'] == 0)
                    {
                        echo "<input type='submit' class='mark_as_seen' name='saw_notification' value='Mark as Seen'>";
                    }
                    else
                    {
                        echo "<input type='submit' class='remove_notification' name='remove_notification' value='Remove'>";
                    }
                    echo "</form>";
                    echo "</div>";
                }

                if($result->num_rows == 0)
                {
                    echo '<div class="no_notifications">No Notifications</div>';
                }
            }
            else
            {
                echo "<div class='notification'>Please <a href='user/signin.php'>Sign In</a> for this feature.</div>";
            }
        ?>
    </body>
</html>