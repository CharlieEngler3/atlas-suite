<?php
	session_start();

	$title = $_POST['title'];
	$body = $_POST['body'];
  	$images = $_POST['images'];
	$user = $_SESSION['username'];
  
	$servername = "localhost";
  	$server_user = "root";

  	$conn = new mysqli($servername, $server_user, "", "forums");

	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}

  	$images = str_replace(" ", "⎖", $images);

	$result = $conn->query("INSERT INTO posts(title, body, image_links, user) VALUES ('$title', '$body', '$images', '$user')");

	$conn->close();
?>