<?php 
    session_start(); 

    include("../../../password.php");
  
    $conn = new mysqli($servername, $server_user, $serverpassword, "users");
    $conn2 = new mysqli($servername, $server_user, $serverpassword, "connect");
?>

<html>
    <head>
        <title>Connect</title>

        <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

      	<meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>

    <body>
        <?php
            if(isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];

                if(!isset($_GET['ConnectedUser']))
                {
        ?>
                    <h1>Message A User:</h1>
        <?php

                    $result = $conn->query("SELECT * FROM user_info WHERE visibility='public' AND username!='$username'");

                    echo "<div class='connect_user_list'>";
                  
                    while($row = $result->fetch_assoc())
                    {
                        echo "<a class='connect_user' href='index.php?ConnectedUser=".$row['username']."'>".$row['username']."</a>";
                    }
                  
                    echo "</div>";
                }
                else
                {
        ?>
                    <a href="index.php">Disconnect</a>

                    <?php
                        $connectedUser = $_GET['ConnectedUser'];

                        $result = $conn2->query("SELECT * FROM chat WHERE (username='$username' AND receiving='$connectedUser') OR (username='$connectedUser' AND receiving='$username')");

                        echo "<div class='connect_messages'>";

                        while($row = $result->fetch_assoc())
                        {
                            echo "<p class='connect_message_author'>".$row['username'].":</p><p class='connect_message'>".$row['message']."</p><br/>";
                        }

                        echo "</div>";

                        echo "<form action='send.php' method='post' class='message_bar'>";
                        echo "<input type='hidden' name='connectedUser' value='".$connectedUser."'/>";
                        echo "<input type='text' class='connect_message' name='message' autocomplete='off' placeholder='Message ".$connectedUser."'/>";
                        echo "<input type='submit' class='connect_submit' value='Send'/>";
                        echo "</form>";
                    ?>
        <?php        
                }
            }
            else
            {
        ?>
                <h3 class="new_user_prompt">Please <a href='../../user/signin.php'>Sign in</a> for this feature</h3>
        <?php
            }
        ?>
    </body>
</html>