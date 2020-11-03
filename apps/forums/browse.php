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
    
    <form action='#' method='POST'>
      <?php
        if(!isset($_SESSION['synthetic_hidden']))
        {
          $_SESSION['synthetic_hidden'] = false;
        }

        if(isset($_POST['hide_synthetic']))
        {
          $_SESSION['synthetic_hidden'] = true;

          
        }

        if(isset($_POST['unhide_synthetic']))
        {
          $_SESSION['synthetic_hidden'] = false;
        }

        if(!$_SESSION['synthetic_hidden'])
        {
      ?>
          <input type='submit' name='hide_synthetic' class='hide_synthetic' value='Hide Synthetic Results'>
      <?php
        }
        else
        {
      ?>
          <input type='submit' name='unhide_synthetic' class='unhide_synthetic' value='Show Synthetic Results'>
      <?php
        }
      ?>
    </form>

      <?php

        if(isset($_SESSION['username']))
        {
          $user = $_SESSION['username'];
        }

        include("../../../password.php");
      
        $conn = new mysqli($servername, $server_user, $serverpassword, "forums");
        $conn2 = new mysqli($servername, $server_user, $serverpassword, "users");

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

        if($_SESSION['synthetic_hidden'] == true)
        {
          $preferenceArray = array();
        }

        $randomSearch = false;
    
        ?>
        <div class='browse_results'>
          <?php

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
                    
                    echo "<form method='POST' action='show_post.php'><input type='submit' name='title' value='".$searchTerm."'/></form><br/>";
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

              echo "<form method='POST' action='show_post.php'><input type='hidden' value='".$searchTerm."' name='title'/><input type='submit' value='".$searchTerm."'/></form><br/>";
            }
          }
        ?>
      </div>
  </body>
</html>