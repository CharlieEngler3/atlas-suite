<?php 
  session_start();
?>

<html>
	<head>
    <title>Profile</title>

    <link rel="stylesheet" type="text/css" href="../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <div class="user_bar">
      <a href='../index.php'>Home</a>
    </div>

    <div class="user_bar">
      <a href='../apps/forums/index.php'>Forums</a>
    </div>

    <div class="user_bar">
      <a href="signout.php">Sign Out</a>
    </div>
  </head>
    
  <body>
    <h1>Profile</h1>
    <div class='profile_name'><?php echo $_SESSION['username']; ?></div>
    
    <div class="profile">
      <button onclick='location.href="history.php"'>Search History</button>
    </div>
  </body>
</html>