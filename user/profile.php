<?php 
  session_start();
?>

<html>
	<head>
    <title>Profile</title>

    <link rel="stylesheet" type="text/css" href="../style/dark.css"/>
    
    <div class="user_bar">
      <a href='../apps/forums/index.php'>Back</a>
    </div>
  </head>
    
  <body>
    <h1><?php echo $_SESSION['username']; ?>'s Profile</h1>
    
    <div class="profile">
      <button onclick='location.href="history.php"'>Search History</button>
    </div>
  </body>
</html>