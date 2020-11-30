<?php
	function is_session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
	
	if ( is_session_started() === FALSE ) session_start();

	include("../password.php");

	$conn = new mysqli($servername, $server_user, $serverpassword, "task_manager");
	$conn2 = new mysqli($servername, $server_user, $serverpassword, "notifications");
	$conn3 = new mysqli($servername, $server_user, $serverpassword, "users");
	
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];

		$result = $conn->query("SELECT * FROM tasks WHERE user='$username'");

		while($row = $result->fetch_assoc())
		{
			$notestemp = explode("✗", $row['notes']);
			$unchecked = array();

			$datestemp = explode("✗", $row['dates']);
			$uncheckedDates = array();

			for($i = 0; $i < count($notestemp); $i++)
			{
				$exploded = explode("✓", $notestemp[$i]);
				$explodedDates = explode("✓", $datestemp[$i]);

				if(count($exploded) > 1)
				{
					for($j = 0; $j < count($exploded); $j++)
					{
						if($j == 0)
						{
							if($exploded[$j])
							{
								array_push($unchecked, $exploded[$j]);
							}
						}
					}
				}
				else
				{
					if($notestemp[$i])
					{
						array_push($unchecked, $notestemp[$i]);
					}
				}

				if(count($explodedDates) > 1)
				{
					for($j = 0; $j < count($explodedDates); $j++)
					{
						if($j == 0)
						{
							if($explodedDates[$j])
							{
								array_push($uncheckedDates, $explodedDates[$j]);
							}
						}
					}
				}
				else
				{
					if($datestemp[$i])
					{
						array_push($uncheckedDates, $datestemp[$i]);
					}
				}
			}

			for($i = 0; $i < count($uncheckedDates); $i++)
			{
				$new = true;
				$checkNotis = $conn2->query("SELECT * FROM notifications WHERE username='$username'");

				while($row = $checkNotis->fetch_assoc())
				{
					if(strpos($row['link'], $unchecked[$i]) !== false)
					{
						$new = false;
					}
				}

				$notificationPrelude = $conn3->query("SELECT * FROM user_info WHERE username='$username'");

				while($row = $notificationPrelude->fetch_assoc())
				{
					$prelude = $row['task_notification_prelude'];
				}

				date_default_timezone_set("America/New_York");

				$time = date_modify(date_create($uncheckedDates[$i]), "-".strval($prelude)." days");

				$time = $time->format("Y-m-d");

				if(date("Y-m-d") == $time && $new)
				{
					$text = "Task set for today: ::linkopen::".$unchecked[$i]."::linkclose::";

					$link = "apps/task_manager/index.php#".$unchecked[$i];

					$conn2->query("INSERT INTO notifications(username, text, link, seen) VALUES ('$username', '$text', '$link', false)");
				}
			}
		}
	}

	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];

		$result = $conn2->query("SELECT * FROM notifications WHERE username='$username' AND seen=false");

		$num_notifications = $result->num_rows;
	}
?>