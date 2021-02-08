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
      
        <script>
            function scroll(){
                window.scrollTo(0,document.body.scrollHeight);
            }
        </script>
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
                    <a class='disconnect_link' href="index.php">Disconnect</a>

                    <?php
                        $connectedUser = $_GET['ConnectedUser'];

                        $result = $conn2->query("SELECT * FROM chat WHERE (username='$username' AND receiving='$connectedUser') OR (username='$connectedUser' AND receiving='$username')");

                        echo "<div id='messages' class='connect_messages'>";

                        while($row = $result->fetch_assoc())
                        {
                            $finalMessage = $row['message'];
                          
                            if(strpos($row['message'], "http://") !== false)
                            {
                                $linkPos = strpos($row['message'], "http://");
                                $endLinkPos = strlen($row['message']);
                              
                                if(strpos($row['message'], " ", $linkPos) !== false)
                                {
                                    $endLinkPos = strpos($row['message'], " ", $linkPos);
                                }
                              
                                $link = substr($row['message'], $linkPos, $endLinkPos-$linkPos);
                                  
                                $finalMessage = substr_replace($row['message'], "<a href='".$link."'>".$link, $linkPos);
                                
                                if($endLinkPos == strlen($row['message']))
                                {
                                    $finalMessage = $finalMessage."</a>";
                                }
                                else
                                {
                                    $finalMessage = substr_replace($finalMessage, "</a>", $endLinkPos);
                                }
                            }
                          
                            if(strpos($row['message'], "https://") !== false)
                            {
                                $linkPos = strpos($row['message'], "https://");
                                $endLinkPos = strlen($row['message']);
                              
                                if(strpos($row['message'], " ", $linkPos) !== false)
                                {
                                    $endLinkPos = strpos($row['message'], " ", $linkPos);
                                }
                              
                                $link = substr($row['message'], $linkPos, $endLinkPos-$linkPos);
                                  
                                $finalMessage = substr_replace($row['message'], "<a href='".$link."'>".$link, $linkPos);
                                
                                if($endLinkPos == strlen($row['message']))
                                {
                                    $finalMessage = $finalMessage."</a>";
                                }
                                else
                                {
                                    $finalMessage = substr_replace($finalMessage, "</a>", $endLinkPos);
                                }
                            }
                            
                            echo "<p class='connect_message_author'>".$row['username'].":</p><p class='connect_message'>".$finalMessage."</p><br/>";
                        }

                        echo "</div>";

                        echo "<form action='send.php' method='post' class='message_bar'>";
                        echo "<input type='hidden' name='connectedUser' value='".$connectedUser."'/>";
                        echo "<input type='text' class='connect_message' name='message' autocomplete='off' placeholder='Message ".$connectedUser."'/>";
                        echo "<input type='submit' class='connect_submit' value='Send'/>";
                        echo "</form>";
                  
                        echo "<script>scroll();</script>";
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