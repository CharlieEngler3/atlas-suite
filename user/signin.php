<?php 
  session_start();
?>

<html>
  <head>
    <title>Sign In</title>
    
    <link rel="stylesheet" type="text/css" href="../style/dark.css"/>
    
    <script>
      function Reload()
      {
        location.href = "signin.php";
      }
    </script>
    
    <a href='../index.php'>Home</a>
    <a href='../index.php'>Sign Up</a>
  </head>
<?php 
  if(!isset($_SESSION['username']))
  {
?>
  <body>
    <h1>Sign In</h1>
    
    <form action="#" method="POST" class="signup_form" autocomplete=off>
      <input type="text" class="signup" name="username" placeholder="Username"/>
      <br/>
      <input type="text" style="color:transparent;" class="signup" name="password" placeholder="Password"/>
      <br/>
      <input type="submit" value="Sign In" class="signup_submit"/>
    </form>
    
    <h3>
      New? <a href='signup.php'>Sign Up</a>
    </h3>
  </body>
</html>

<?php
  }
  else
  {
	echo "<div class='notification' onclick='location.href=\"signout.php\"'>You are signed in <h4>(Click to sign out)</h4></div>";
  }

  if(isset($_POST['username']) && isset($_POST['password']) && !isset($_SESSION['username']))
  {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $servername = "localhost";
    $server_user = "root";

    $conn = new mysqli($servername, $server_user, "", "users");

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $password = md5($password);

    $resultUsername = $conn->query("SELECT * FROM user_info WHERE username = '$username'");
    
    $resultEmail = $conn->query("SELECT * FROM user_info WHERE email = '$username'");
    
    if($resultUsername->num_rows == 0 && $resultEmail->num_rows == 0)
    {
      echo "<div class='notification' onclick='Reload()'>Couldn't sign in, user doesn't exist. <h4>(Click to dismiss)</h4></div>";
    }
    else if($resultUsername->num_rows != 0)
    {
      $row = $resultUsername->fetch_assoc();
      
      if($row["password"] == $password)
      {
		$_SESSION['username'] = $username;

        echo "<div class='notification' onclick='location.href=\"../index.php\"'>Signed in <h4>(Click to dismiss)</h4></div>";
      }
      else
      {
        echo "<div class='notification' onclick='Reload()'>Passwords don't match. <h4>(Click to dismiss)</h4></div>";
      }
    }
    else if($resultEmail->num_rows != 0)
    {
      $row = $resultEmail->fetch_assoc();
      
      if($row["password"] == $password)
      {
        $_SESSION['username'] = $row["username"];
        
        echo "<div class='notification' onclick='location.href=\"../index.php\"'>Signed in <h4>(Click to dismiss)</h4></div>";
      }
      else
      {
        echo "<div class='notification' onclick='Reload()'>Passwords don't match.<h4>(Click to dismiss)</h4></div>";
      }
    }
    
    $conn->close();
  }
?>