<?php
    session_start();

    $username = $_SESSION['username'];

    $post_id = $_GET['post_id'];
    $like_value = $_GET['like_value'];

    include("../../../password.php");
  
	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");

    $result = $conn->query("SELECT * FROM likes WHERE username='$username' AND post_id='$post_id'");
    
    if($like_value > 1)
    {
        $like_value = 1;
    }
    else if($like_value < -1)
    {
        $like_value = -1;
    }

    if(empty($result))
    {
        $conn->query("INSERT INTO likes(username,post_id,value) VALUES ('$username','$post_id','$like_value')");
    }
    else if(!empty($result) && $result->num_rows == 0)
    {
        $conn->query("INSERT INTO likes(username,post_id,value) VALUES ('$username','$post_id','$like_value')");
    }
    else if(!empty($result) && $result->num_rows > 0)
    {
        $conn->query("UPDATE likes SET value='$like_value' WHERE username='$username' AND post_id='$post_id'");
    }

    $result = $conn->query("SELECT * FROM posts WHERE id='$post_id'");

    while($row = $result->fetch_assoc())
    {
        $title = $row['title'];
    }

    echo "<script>location.href='show_post.php?post_id=".$post_id."&title=".$title."';</script>";
?>