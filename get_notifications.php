<?php
	include("../password.php");

    $servername = "localhost";
    $server_user = "root";

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
					if(strpos($row['text'], $unchecked[$i]) !== false)
					{
						$new = false;
					}
				}

				$notificationPrelude = $conn3->query("SELECT * FROM user_info WHERE username='$username'");

				while($row = $notificationPrelude->fetch_assoc())
				{
					$prelude = $row['task_notification_prelude'];
				}

				$time = date_modify(date_create($uncheckedDates[$i]), "-".strval($prelude)." days");

				$time = $time->format("Y-m-d");

				if(date("Y-m-d") == $time && $new)
				{
					$text = "Task set for today: ~".$unchecked[$i].";";

					//$conn2->query("INSERT INTO notifications (username, text, seen) VALUES ('$username', '$text', 0)");
				}
			}
		}
	}

	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];

		$result = $conn2->query("SELECT * FROM notifications WHERE username='$username' AND seen=0");

		$num_notifications = $result->num_rows;
	}
?>