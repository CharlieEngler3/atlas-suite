<?php 
  session_start(); 

	include("../../../password.php");
  
  $conn = new mysqli($servername, $server_user, $serverpassword, "forums");
  $conn2 = new mysqli($servername, $server_user, $serverpassword, "notifications");
?>

<html>
	<head>
    	<title>Forums</title>
      
      <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

      <meta name='viewport' content='width=device-width, initial-scale=1'>
        
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

              <div class="user_bar">
                <a href="../../user/signout.php">Sign Out</a>
              </div>
            <?php
          }
        ?>
    </head>
    
    <body>
      <h1>Forums</h1>

      <div class="browse_menu">
        <input type='submit' onclick="location.href='browse.php';" value="Browse">
      </div>
      
      <div class="search_menu">
            <form method='post' action='search.php' style='text-align:center;' autocomplete='off'>
              <input type='text' name='search_term' placeholder='Search Term' pattern="([^\W+]([a-zA-Z0-9$_#@!\^,.\?|~;: ])+).{3,300}$"/>
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
                <input type='text' name='title' placeholder='Title' pattern="([^\W+]([a-zA-Z0-9$_#@!\^,.\?|~;: ])+).{3,300}$"/>
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

			<h3 class="new_user_prompt">Please <a href='../../user/signin.php'>Sign in</a> for this feature</h3>

			<?php
				}

			?>
      </div>
    </body>
</html>