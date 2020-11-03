<?php
    session_start();

	include("../../../password.php");
  
	$conn = new mysqli($servername, $server_user, $serverpassword, "task_manager");
	  
    $username = $_SESSION['username'];

    $notesArr = $_POST['notes'];
    $datesArr = array();
    $tempDatesArr = $_POST['date'];

    $tempDatesArr2 = $tempDatesArr;

    $in1 = 0;

    for($i = 0; $i < count($notesArr); $i++)
    {
        if($i&1)
        {
            array_push($datesArr, $tempDatesArr[$in1]);

            $in1++;
        }
        else
        {
            array_push($datesArr, $notesArr[$i]);
        }
    }

    foreach (array_keys($notesArr, '') as $key) 
    {
        unset($notesArr[$key-1]);
        unset($notesArr[$key]);
        unset($datesArr[$key-1]);
        unset($datesArr[$key]);
    }

    $notes = implode("", $notesArr);

    $date = implode("", $datesArr);

    $title = str_replace("'", '’', $_POST['title']);
    $notes = str_replace("'", '’', $notes);

    $conn->query("INSERT INTO tasks (title, notes, user, dates) VALUES ('$title', '$notes', '$username', '$date')");

    echo "<script>location.href='index.php';</script>";
?>