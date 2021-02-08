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

		<script>
			function addCustomPrelude(parent, offset)
			{
				if(!document.getElementById("customPrelude"))
				{
					let custom = document.createElement("INPUT");
					custom.setAttribute("type", "text");
					custom.setAttribute("name", "prelude[]");
					custom.setAttribute("placeholder", "Custom");
					custom.setAttribute("id", "customPrelude");
					custom.setAttribute("class", "custom_prelude");
					if(offset > 0)
					{
						custom.setAttribute("value", offset);
					}

					let customSubmit = document.createElement("INPUT");
					customSubmit.setAttribute("type", "submit");
					customSubmit.setAttribute("value", "Submit");
					customSubmit.setAttribute("id", "customPreludeSubmit");
					customSubmit.setAttribute("class", "submit_prelude");

					parent.appendChild(custom);
					parent.appendChild(customSubmit);
				}
			}

			function removeCustomPrelude(parent)
			{
				if(document.getElementById("customPrelude"))
				{
					document.getElementById("customPrelude").remove();
					document.getElementById("customPreludeSubmit").remove();
				}

				parent.submit();
			}
		</script>
	</head>

	<body>
		<h1>Profile</h1>
		<div class='profile_name'><?php echo $_SESSION['username']; ?></div>
    <form class='set_status' action='#' method='POST'>
        <label for='status'>Set your status: </label>
        <br/>
        <select id='status' name='status' onchange="this.form.submit();">
            <option value='online'>Online</option>
            <option value='away'>Away</option>
            <option value='invisible'>Invisible</option>
            <option value='offline'>Offline</option>
        </select>
    </form>
    
    <form class='set_status' action='#' method='POST'>
        <label for='visibility'>Set your visibility: </label>
        <br/>
        <select id='visibility' name='visibility' onchange="this.form.submit();">
            <option value='public'>Public</option>
            <option value='private'>Private</option>
        </select>
    </form>

		<button onclick='location.href="history.php"' class="history">Search History</button>
		
		<div class="prelude">
			<form action="#" method="POST">
				<h3>Select how long before a task is due to receive notifications:</h3>
				<select id='prelude' name='prelude[]' class="prelude_dropdown">
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='0'>Same Day</option>
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='1'>1 Day Before</option>
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='2'>2 Days Before</option>
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='3'>3 Days Before</option>
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='4'>4 Days Before</option>
					<option onclick="removeCustomPrelude(this.parentElement.parentElement)" value='5'>5 Days Before</option>
					<option onclick="addCustomPrelude(this.parentElement.parentElement, 0)" value=''>Custom</option>
				</select>
			</form>
		</div>
    
    
	</body>
</html>

<?php
	$username = $_SESSION['username'];

	include("../../password.php");
    
  $conn = new mysqli($servername, $server_user, $serverpassword, "users");

	if(isset($_POST['prelude']))
	{
      $prelude = intval(implode("", $_POST['prelude']));

      $conn->query("UPDATE user_info SET task_notification_prelude = '$prelude' WHERE username = '$username'");
	}

	$result = $conn->query("SELECT * FROM user_info WHERE username = '$username'");

	while($row = $result->fetch_assoc())
	{
      $prelude = $row['task_notification_prelude'];

      if($prelude <= 5)
      {
        echo "<script>document.getElementById('prelude').value = ".$prelude.";</script>";
      }
      else
      {
        echo "<script>document.getElementById('prelude').value = '';addCustomPrelude(document.getElementById('prelude').parentElement, ".$prelude.")</script>";
      }
	}

  if(isset($_POST['status']))
  {
      $status = $_POST['status'];
    
      $conn->query("UPDATE user_info SET status='$status' WHERE username='$username'");
  }

  if(isset($_POST['visibility']))
  {
      $visibility = $_POST['visibility'];
    
      $conn->query("UPDATE user_info SET visibility='$visibility' WHERE username='$username'");
  }

  $result = $conn->query("SELECT * FROM user_info WHERE username='$username'");

  while($row = $result->fetch_assoc())
  {
      $status = $row['status'];
      $visibility = $row['visibility'];
  }

  echo "<script>document.getElementById('status').value = '".$status."';</script>";
  echo "<script>document.getElementById('visibility').value = '".$visibility."';</script>";
?>