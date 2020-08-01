<?php 
  session_start(); 

  $servername = "localhost";
  $server_user = "root";

  $conn = new mysqli($servername, $server_user, "", "forums");
  $conn2 = new mysqli($servername, $server_user, "", "notifications");
?>

<html>
	<head>
    	<title>Forums</title>
      
      	<link rel="stylesheet" type="text/css" href="../../style/dark.css"/>
    </head>
    
    <body>
      <div class="user_bar">
        <a href='../../index.php' class='user_bar_link'>Home</a>
        
        <?php
          if(!isset($_SESSION['username']))
          {
            ?>
              <a href="../../user/signin.php" class='user_bar_link'>Sign In</a>
            <?php
          }
          else
          {
            ?>
              <a href="../../user/profile.php" class='user_bar_link'>Account</a>
			        <a href="../../user/signout.php" class='user_bar_link'>Sign Out</a>
            <?php
          }
        ?>
      </div>
      
      <h1>Forums</h1>

      <div class="browse_menu">
        <input type='submit' onclick="location.href='browse.php';" value="Browse">
      </div>
      
      <div class="search_menu">
            <form method='post' action='search.php' style='text-align:center;' autocomplete='off'>
              <input type='text' name='search_term' placeholder='Search Term' maxlength="30"/>
                <br/>
                <input type='submit' value='Search'/>
            </form>
      </div>
      <div class="new_menu">
			<?php
				if(isset($_SESSION['username']))
				{
			?>
            <form method='post' action='new.php' style='text-align:center;' autocomplete='off'>
                <input type='text' name='title' placeholder='Title' maxlength="30"/>
                <br/>
                <textarea name='body' placeholder='Write the body text of your post here.' maxlength="3000"></textarea>
                <br/>
                <textarea name='images' placeholder='Put image links here divided by spaces'></textarea>
                <input type='submit' value='Create'/>
            </form>

			<?php
				}
				else
				{
			?>

			<h2>Please <a href='../../user/signin.php' class="signin-link">Sign in</a> for this feature</h2>

			<?php
				}

			?>
      </div>
    </body>
</html>