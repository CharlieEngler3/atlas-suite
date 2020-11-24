<?php
  session_start();
?>
<html>
	<head>
		<title>Search History</title>
		
		<link rel="stylesheet" type="text/css" href="../style/dark.css"/>

		<meta name='viewport' content='width=device-width, initial-scale=1'>
		
		<div class="user_bar">
			<a href='profile.php'>Back</a>
		</div>
	</head>
	<body>
		<h1>Search History</h1>
		<h3>(Click items to delete them from your search history.)</h3>
		<br>

		<div class='history'>
		
		<?php
		
		include("../../password.php");
		
		$conn = new mysqli($servername, $server_user, $serverpassword, "users");
		
		if(isset($_SESSION['username']))
		{
			$username = $_SESSION['username'];
		
			$result = $conn->query("SELECT * FROM browsing_history WHERE username='$username'");

			if($result->num_rows > 0)
			{
				$row = $result->fetch_assoc();

				if(!is_string($row['search_term']))
				{
					$history = array_values($row['search_term']);
				}
				else
				{
					$history = array();
					array_push($history, $row['search_term']);
				}
				
				for($i = 0; $i < count($history); $i++)
				{
					echo "<form action='#' method='POST'><input type='hidden' value='".$history[$i]."' name='term'/><input type='hidden' value='".$username."' name='username'/><input type='submit' class='delete_button' value='".$history[$i]."'/></form>";
				}
			}
		}
		
		if(isset($_POST['term']))
		{
			$term = $_POST['term'];
			$username = $_POST['username'];
			
			$conn->query("DELETE FROM browsing_history WHERE search_term='$term' AND username='$username'");
			
			echo "<script>location.href='history.php';</script>";
		}
		?>

		</div>
		
	</body>
</html>