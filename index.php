<?php
	session_start();

	include("../password.php");

	echo "<div id='get_notis'>";
	//include("get_notifications.php");
	echo "</div>";
?>

<html>
	<head>
		<title>Atlas Suite</title>

		<link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"/> 
		<link rel="stylesheet" type="text/css" href="style/dark.css"/>
		<script src="required/jquery-3.5.1.min.js" type="text/javascript"></script>

		<meta name='viewport' content='width=device-width, initial-scale=1'>

		<script type="text/javascript">
			$(function() {
				startRefresh();
			});

			function startRefresh(){
				setTimeout(startRefresh, 1000);
				$("#get_notis").load(location.href + " #get_notis");
				$("#show_notis").load(location.href + " #show_notis");
			}
		</script>
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
			<button class="icon" onclick="location.href='apps/calculator/'"><h4>Calculator</h4></button>
			<button class="icon" onclick="location.href='apps/forums/'"><h4>Forums</h4></button>
			<button class="icon" onclick="location.href='apps/gpa_calculator/'"><h4>GPA<br/>Calculator</h4></button>

			<button class="icon" onclick="location.href='apps/pomodoro_timer/'"><h4>Pomodoro<br/>Timer</h4></button>
			<button class="icon" onclick="location.href='apps/task_manager/'"><h4>Task<br/>Manager</h4></button>
			<button class="icon" onclick="location.href='notifications.php'"><h4 id="show_notis">
					<?php 
						if(isset($num_notifications))
						{
							echo "<div class='num_notifications'>".$num_notifications."</div>";
						}
						else
						{
							echo "<a href='user/signin.php'>Signed Out</a>";
						}
					?>
					<?php
						if(isset($num_notifications))
						{
							if($num_notifications != 1)
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
			</h4></button>
		</div>
	</body>
</html>
