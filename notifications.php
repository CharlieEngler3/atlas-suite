<?php
    session_start();

	include("../password.php");

	$conn = new mysqli($servername, $server_user, $serverpassword, "notifications");
    
    function get_string_between($string, $start, $end)
    {
        $string = ' ' . $string;
        $ini = strpos($string, $start);
        if ($ini == 0) return '';
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }    

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
        <h1>Notifications</h1>

        <?php
            if(isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];

                $result = $conn->query("SELECT * FROM notifications WHERE username = '$username'");

                while($row = $result->fetch_assoc())
                {
                    $text = $row['text'];

                    $tempText = get_string_between($text, "~", ";");

                    $text = str_replace("~", "<a href='apps/task_manager/index.php#".$tempText."'>", $text);
                    $text = str_replace(";", "</a>", $text);

                    echo "<form action='#' class='notification' method='POST'>";
                    echo "<div class='notification_text'>".$text."</div>";
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