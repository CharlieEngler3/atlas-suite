<?php
  session_start();
?>
<html>
  <head>
    <title>Search History</title>
    
    <link rel="stylesheet" type="text/css" href="../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <div class="user_bar">
        <a href='profile.php'>Back</a>
    </div>
  </head>
  <body>
    <h1>Search History</h1>
    <h3>(Click items to delete them from your search history.)</h3>
    <br>

    <div class='history'>
    
    <?php
      
      include("../../password.php");
      
      $conn = new mysqli($servername, $server_user, $serverpassword, "users");
      
      if(isset($_SESSION['username']))
      {
        $username = $_SESSION['username'];
    
        $result = $conn->query("SELECT * FROM user_info WHERE username='$username'");

        $row = $result->fetch_assoc();

        $history = explode("⎖", $row['previous_searches']);
        
        if($history[0] != "")
        {
          for($i = 0; $i < sizeof($history); $i++)
          {
            echo "<form action='#' method='POST'><input type='hidden' value='".$history[$i]."' name='term'/><input type='submit' class='delete_button' value='".$history[$i]."'/></form>";
          }
        }
      }
      
    ?>
      
    </form>
    
    <?php
      if(isset($_POST['term']))
      {
        $term = $_POST['term'];
        
        $result = $conn->query("SELECT * FROM user_info WHERE username='$username'");
        
        $row = $result->fetch_assoc();
        
        $search_results = explode("⎖", $row['previous_searches']);
        
        if (($key = array_search($term, $search_results)) !== false) 
        {
          unset($search_results[$key]);
        }
        
        $previous_searches = implode("⎖", $search_results);
        
        $conn->query("UPDATE user_info SET previous_searches='$previous_searches' WHERE username='$username'");
        
        echo "<script>location.href='history.php';</script>";
      }
    ?>

    </div>
    
  </body>
</html>