<?php
  session_start();
?>
<html>
  <head>
    <title>Browse Forums</title>
    
    <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <div class="user_bar">
        <a href='index.php'>Back</a>
    </div>
  </head>
  <body>
    <h1>Browse</h1>
    
    <div class='synthetic'>
      <form action='#' method='POST'>
        <input type='text' class='synthetic_message' alt="Use this if you aren't seeing as many results as you would like \n or if you would like to see unbiased results." value='Hide synthetic results?' readonly>
        <input type='checkbox' id='include' name='include' class='synthetic_check' value='true'>
        <input type='submit' value='Confirm' class='synthetic_submit'>
      </form>
    </div>

      <?php

        if(isset($_SESSION['username']))
        {
          $user = $_SESSION['username'];
        }

        $servername = "localhost";
        $server_user = "root";

        $conn = new mysqli($servername, $server_user, "", "forums");
        $conn2 = new mysqli($servername, $server_user, "", "users");

        if(isset($_SESSION['username']))
        {
          $result = $conn2->query("SELECT * FROM user_info WHERE username = '$user'");

          $row = $result->fetch_assoc();

          $preferenceArray = explode("⎖", $row["previous_searches"]);
        }
        else
        {
          $preferenceArray = array();
        }

        if(isset($_POST['include']))
        {
          if($_POST['include'] == "true")
          {
            $preferenceArray = array();

            echo "<script>document.getElementById('include').checked = true;</script>";
          }
        }
    
        
    
        $randomSearch = false;
    
        if(sizeof($preferenceArray) > 0)
        {  
          if($preferenceArray[0] != "")
          {
            for($i = 0; $i < sizeof($preferenceArray); $i++)
            {
              $currentPreference = $preferenceArray[$i];

              $result = $conn->query("SELECT * FROM posts WHERE title LIKE '%$currentPreference%' LIMIT 10");

              if($result->num_rows > 0)
              {
                while($searchReturns = $result->fetch_assoc())
                {
                  $searchTerm = $searchReturns['title'];
                  
                  echo "<form method='POST' action='show_post.php'><input type='hidden' value='".$searchTerm."' name='title'/><input type='submit' value='".$searchTerm."'/></form>";
                }
              }
              else
              {
                $randomSearch = true;
              }
            }
          }
          else
          {
            $randomSearch = true;
          }
        }
        
        if($randomSearch == true || sizeof($preferenceArray) == 0)
        {
          $result = $conn->query("SELECT * FROM posts WHERE 1 LIMIT 10");

          while($searchReturns = $result->fetch_assoc())
          {
            $searchTerm = $searchReturns['title'];

            echo "<form method='POST' action='show_post.php'><input type='hidden' value='".$searchTerm."' name='title'/><input type='submit' value='".$searchTerm."'/></form>";
          }
        }
      ?>
  </body>
</html>