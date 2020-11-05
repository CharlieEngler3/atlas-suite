<?php 
  session_start();
?>

<html>
  <head>
    <title>Sign In</title>
    
    <link rel="stylesheet" type="text/css" href="../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <script>
      function Reload()
      {
        location.href = "signin.php";
      }
    </script>
    
    <div class="user_bar">
      <a href='../index.php'>Home</a>
    </div>

    <div class="user_bar">
      <a href='signup.php'>Sign Up</a>
    </div>
  </head>
<?php 
  if(!isset($_SESSION['username']))
  {
?>
  <body>
    <h1>Sign In</h1>
    
    <form action="#" method="POST" class="signup_form" autocomplete=off>
      <input type="text" name="username" pattern="([^\W+]([a-zA-Z0-9$_#@!\^,.\?|~;: ])+).{3,15}$" placeholder="Username or Email"/>
      <br/>
      <input type="password" name="password" placeholder="Password"/>
      <br/>
      <input type="submit" value="Sign In"/>
    </form>
    
    <h3 class="new_user_prompt">
      New? <br/><a href='signup.php'>Sign Up</a>
    </h3>
  </body>
</html>

<?php
  }
  else
  {
	echo "<div class='sign_in_prompt' onclick='location.href=\"signout.php\"'>You are signed in <h5>(Click to sign out)</h5></div>";
  }

  if(isset($_POST['username']) && isset($_POST['password']) && !isset($_SESSION['username']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    include("../../password.php");
    
    $conn = new mysqli($servername, $server_user, $serverpassword, "users");
      
    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $password = md5($password);

    $resultUsername = $conn->query("SELECT * FROM user_info WHERE username = '$username'");
    
    $resultEmail = $conn->query("SELECT * FROM user_info WHERE email = '$username'");
    
    if($resultUsername->num_rows == 0 && $resultEmail->num_rows == 0)
    {
      echo "<div class='sign_in_prompt' onclick='Reload()'>Couldn't sign in, user doesn't exist. <h5>(Click to dismiss)</h5></div>";
    }
    else if($resultUsername->num_rows != 0)
    {
      $row = $resultUsername->fetch_assoc();
      
      if($row["password"] == $password)
      {
		    $_SESSION['username'] = $username;

        echo "<div class='sign_in_prompt' onclick='location.href=\"../index.php\"'>Signed in <h5>(Click to dismiss)</h5></div>";
      }
      else
      {
        echo "<div class='sign_in_prompt' onclick='Reload()'>Passwords don't match. <h5>(Click to dismiss)</h5></div>";
      }
    }
    else if($resultEmail->num_rows != 0)
    {
      $row = $resultEmail->fetch_assoc();
      
      if($row["password"] == $password)
      {
        $_SESSION['username'] = $row["username"];
        
        echo "<div class='sign_in_prompt' onclick='location.href=\"../index.php\"'>Signed in <h5>(Click to dismiss)</h5></div>";
      }
      else
      {
        echo "<div class='sign_in_prompt' onclick='Reload()'>Passwords don't match.<h5>(Click to dismiss)</h5></div>";
      }
    }
    
    $conn->close();
  }
?>