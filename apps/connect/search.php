<?php
    include("../../../password.php");
  
    $conn = new mysqli($servername, $server_user, $serverpassword, "users");

    if(isset($_GET['searched_user']))
    {
        ?>
        
        <form action="#" method="GET" class='user_search'>
            <input type="text" name="searched_user" placeholder="Search for a user"/>
        </form>

        <?php
      
        $searchedUser = $_GET['searched_user'];
        
        $result = $conn->query("SELECT * FROM user_info WHERE username LIKE '%$searchedUser%'");
      
        echo "<h2>Search Results</h2>";
        echo "<div class='connect_user_list' style='border-bottom:2px solid white;'>";
      
        while($row = $result->fetch_assoc())
        {
            echo "<a class='connect_user' href='connect.php?ConnectedUser=".$row['username']."'>".$row['username']."</a>";
        }
      
        echo "</div>";
    }
    else
    {
        ?>
        
        <form action="#" method="GET" class='user_search'>
            <input type="text" name="searched_user" placeholder="Search for a user"/>
        </form>

        <?php
    }
?>