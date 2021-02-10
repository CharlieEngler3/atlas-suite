<?php 
    session_start(); 

    include("../../../password.php");
  
    $conn = new mysqli($servername, $server_user, $serverpassword, "users");
    $conn2 = new mysqli($servername, $server_user, $serverpassword, "connect");
?>

<html>
    <head>
        <title>Connect</title>
      
        <div class="user_bar">
        	  <a href='../../index.php'>Home</a>
      	</div>
      
        <?php
            if(!isset($_SESSION['username']))
            {
        ?>
                <div class="user_bar">
                    <a href="../../user/signin.php">Sign In</a>
                </div>
        <?php
            }
            else
            {
        ?>
                <div class="user_bar">
                    <a href="../../user/profile.php">Account</a>
                </div>
        <?php
            }
        ?>

        <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

      	<meta name='viewport' content='width=device-width, initial-scale=1'>
    </head>

    <body>
        <h1>Message a user:</h1>
      
        <?php
            include('search.php');
      
            if(isset($_SESSION['username']))
            {
                $username = $_SESSION['username'];

                $result = $conn->query("SELECT * FROM user_info WHERE visibility='public' AND username!='$username'");

                echo "<div class='connect_user_list'>";

                while($row = $result->fetch_assoc())
                {
                    echo "<a class='connect_user' href='connect.php?ConnectedUser=".$row['username']."'>".$row['username']."</a>";
                }

                echo "</div>";
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