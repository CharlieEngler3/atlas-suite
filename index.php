<?php
	session_start();

    $servername = "localhost";
    $server_user = "root";

	$conn = new mysqli($servername, $server_user, "", "notifications");
	
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];

		$result = $conn->query("SELECT * FROM notifications WHERE username='$username' AND seen='false'");

		if($result->num_rows > 0)
		{
			$num_notifications = $result->num_rows;
		}
	}
?>

<html>
	<head>
		<title>Other Suite</title>

		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"/> 
		<link rel="stylesheet" type="text/css" href="style/dark.css"/>
	</head>

	<body>
		<h1>Atlas Suite</h1>

		<div style='text-align:center'>
			<?php
				if(!isset($_SESSION['username']))
				{
			?>
					<a href='user/signin.php' class='index-signin'>Sign In</a>
			<?php
				}
				else
				{
			?>
					<a href='user/profile.php' class='index-signin'><?php echo $_SESSION['username']; ?></a>
			<?php
				}
			?>
		</div>
			
		<div class="icon-list">
			<button class="icon" onclick="location.href='apps/calculator/'">Calculator</button>
			<button class="icon" onclick="location.href='apps/forums/'">Forums</button>
			<button class="icon" onclick="location.href='apps/gpa_calculator/'">GPA<br/>Calculator</button>

			<button class="icon" onclick="location.href='apps/pomodoro_timer/'">Pomodoro<br/>Timer</button>
			<button class="icon" onclick="location.href='apps/task_manager/'">Task<br/>Manager</button>
			<button class="icon" onclick="location.href='notifications.php'">
					<?php 
						if(isset($num_notifications))
						{
							echo "<div class='notification'>".$num_notifications."</div>";
						}
						else
						{
							echo "<a href='user/signin.php'>Signed Out</a>";
						}
					?>
					<?php
						if(isset($num_notifications))
						{
							if($num_notifications > 1)
							{
								echo "Notifications";
							}
							else
							{
								echo "Notification";
							}
						}
						else
						{
							echo "Notifications";
						}
					?>
			</button>
		</div>
	</body>
</html>