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
                    <h1>Connect With A User:</h1>
        <?php

                    $result = $conn->query("SELECT * FROM user_info WHERE visibility='public' AND username!='$username'");

                    while($row = $result->fetch_assoc())
                    {
                        echo "<a href='index.php?ConnectedUser=".$row['username']."'>".$row['username']."</a>";
                        echo "<br>";
                    }
                }
                else
                {
        ?>
                    <a href="index.php">Disconnect</a>

                    <div>
                        <?php
                            $connectedUser = $_GET['ConnectedUser'];

                            $result = $conn2->query("SELECT * FROM chat WHERE username='$username' OR receiving='$username'");

                            while($row = $result->fetch_assoc())
                            {
                                echo "<p>".$row['message']." - ".$row['username']."</p>";
                            }
                            
                            echo "<form action='send.php' method='post'>";
                            echo "<input type='hidden' name='connectedUser' value='".$connectedUser."'/>";
                            echo "<input type='text' name='message' placeholder='Message ".$connectedUser."'/>";
                            echo "<input type='submit' value='Send'/>";
                            echo "</form>";
                        ?>
                    </div>
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