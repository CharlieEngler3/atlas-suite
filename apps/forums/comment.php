<?php
	session_start();

	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
		$post_id = $_POST['post_id'];
	}

	if(isset($_GET['title']))
	{
		$title = $_GET['title'];
		$post_id = $_GET['post_id'];
	}
?>
<html>
	<head>
		<title><?php echo $title." Comments"; ?></title>

		<link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

		<meta name='viewport' content='width=device-width, initial-scale=1'>

		<div class='user_bar'>
			<a href="show_post.php?title=<?php echo $title; ?>&post_id=<?php echo $post_id;?>">Back</a>
		</div>

		<script type="text/javascript">
			function formAutoSubmit(){
				var frm = document.getElementById("autoSubmit");
				frm.submit();
			}
			window.onload = formAutoSubmit();
		</script>
	</head>
<?php
	if(isset($_SESSION['username']))
	{
		$username = $_SESSION['username'];
	}

	include("../../../password.php");

	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");
	$conn2 = new mysqli($servername, $server_user, $serverpassword, "notifications");
  
	if(isset($_POST['comment']) && !isset($_POST['reply_to']))
	{
		$title = $_POST['title'];
		$comment = $_POST['comment'];
		$post_id = $_POST['post_id'];

		if(isset($_POST['edited_comment']))
		{
			$edited_comment = $_POST['edited_comment'];

			$conn->query("UPDATE comments SET comment='$comment' WHERE comment='$edited_comment' AND username='$username'");

			echo "<script>location.href = 'show_post.php?title=".$title."';</script>";
		}
		else
		{
			$conn->query("INSERT INTO comments (post, post_id, comment, replying_to, username) VALUES ('$title', '$post_id', '$comment', '', '$username')");

			$notification_text = $username." commented on your post, \"".$title."\"";

			$result = $conn->query("SELECT * FROM posts WHERE title='$title'");
			
			while($row = $result->fetch_assoc())
			{
				if($username != $row['user'])
				{
					$user = $row['user'];

					$conn2->query("INSERT INTO notifications (username, text, seen) VALUES ('$user', '$notification_text', false)");
				}
			}

			echo "<script>location.href = 'show_post.php?title=".$title."';</script>";
		}
	}

	if(isset($_POST['reply_to']))
	{
		$comment = $_POST['comment'];
		$reply_to = $_POST['reply_to'];
		$title = $_POST['title'];
		$postUsername = $_POST['postUsername'];
		$post_id = $_POST['post_id'];

		$result = $conn->query("SELECT replies FROM comments WHERE id='$reply_to' AND post='$title' AND post_id='$post_id' AND username='$postUsername'");

		while($row = $result->fetch_assoc())
		{
			$replies = $row['replies'] + 1;
		}

		$conn->query("INSERT INTO comments(post, post_id, comment, replying_to, username) VALUES ('$title', '$post_id', '$comment', '$reply_to', '$username')");
		$conn->query("UPDATE comments SET replies='$replies' WHERE id='$reply_to' AND post='$title' AND post_id='$post_id' AND username='$postUsername'");

		$notification_text = $username." replied to your comment, \"".$comment."\"";

		$result = $conn->query("SELECT * FROM comments WHERE post='$title' AND post_id='$post_id' AND id='$reply_to'");
		
		while($row = $result->fetch_assoc())
		{
			if($username != $row['username'])
			{
				$user = $row['username'];

				$conn2->query("INSERT INTO notifications(username, text, seen) VALUES ('$user', '$notification_text', false)");
			}
		}

		echo "<script>location.href = 'show_post.php?title=".$title."';</script>";
	}

	if(isset($_GET['reply']))
	{
		$title = $_GET['title'];
		$comment = $_GET['comment'];
		$post_id = $_GET['post_id'];

		$result = $conn->query("SELECT * FROM comments WHERE comment='$comment'");

		while($row = $result->fetch_assoc())
		{
			$reply_to = $row['id'];
			$username = $row['username'];
		}

		?>
			<form action="#" class="comments" method="POST" autocomplete=off>
				<input type="text" name="comment" class='comment_field' maxlength="300" placeholder="Add a reply"/>
				<input type="hidden" name="reply_to" value="<?php echo $reply_to; ?>"/>
				<input type="hidden" name="title" value="<?php echo $title; ?>"/>
				<input type="hidden" name="postUsername" value="<?php echo $username; ?>"/>
				<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
				<input type="submit" class='submit_comment' value="Submit"/>
			</form>
		<?php
	}

	if(isset($_GET['replies']))
	{
		echo "<div class='comments'>Replies";

		$title = $_GET['title'];
		$comment = $_GET['comment'];
		$commentUser = $_GET['username'];
		$post_id = $_GET['post_id'];

		$result = $conn->query("SELECT * FROM comments WHERE post='$title' AND post_id='$post_id' AND comment='$comment' AND username='$commentUser'");

		while($row = $result->fetch_assoc())
		{
			$commentID = $row['id'];
		}

		$result = $conn->query("SELECT * FROM comments WHERE replying_to='$commentID'");

		while($row = $result->fetch_assoc())
		{
			echo "<div class='comment'>".$row['comment']."<div class='comment_user'>By: ".$row['username']." ";
			if(isset($_SESSION['username']))
			{
				if($row['username'] == $_SESSION['username'])
				{
					echo "<a href='comment.php?title=".$title."&post_id=".$post_id."&edit_comment=".$row['comment']."'>Edit</a>";
					echo " ";
					echo "<a href='comment.php?title=".$title."&post_id=".$post_id."&delete_comment=".$row['comment']."'>Delete</a>";
				}
			}
			
			echo "</div></div>";
		}
		
		echo "</div>";
	}

	if(isset($_GET['edit_comment']))
	{
		$title = $_GET['title'];
		$comment = $_GET['edit_comment'];
		$post_id = $_GET['post_id'];

		?>
			<form action="#" class='comments' method="POST" autocomplete=off>
				<input type="text" name="comment" class='comment_field' maxlength="300" value="<?php echo $comment; ?>"/>
				<input type="hidden" name="edited_comment" value="<?php echo $comment; ?>"/>
				<input type="hidden" name="title" value="<?php echo $title; ?>"/>
				<input type="hidden" name="post_id" value="<?php echo $post_id; ?>"/>
				<input type="submit" class='submit_comment' value="Submit"/>
			</form>

		<?php
	}

	if(isset($_GET['delete_comment']))
	{
		$title = $_GET['title'];
		$comment = $_GET['delete_comment'];
		$post_id = $_GET['post_id'];

		?>
			<h3>Would you like to delete this comment and all of its replies?
		<?php

		echo "</br>";
		echo "</br>";
		echo "<a href='comment.php?title=".$title."&post_id=".$post_id."&deleting_comment=".$comment."'>Yes</a>";
		echo "<pre style='display:inline-block';>&#9;</pre>";
		echo "<a href='show_post.php?title=".$title."'>No</a>";
		echo "</h3>";
	}

	if(isset($_GET['deleting_comment']))
	{
		$title = $_GET['title'];
		$comment = $_GET['deleting_comment'];
		$post_id = $_GET['post_id'];

		$result = $conn->query("SELECT * FROM comments WHERE post='$title' AND post_id='$post_id' AND comment='$comment' AND username='$username'");

		while($row = $result->fetch_assoc())
		{
			$id = $row['id'];

			$conn->query("DELETE FROM comments WHERE replying_to='$id'");
		}

		$conn->query("DELETE FROM comments WHERE post='$title' AND post_id='$post_id' AND comment='$comment' AND username='$username'");

		print_r($post_id);

		echo "<script>location.href = 'show_post.php?title=".$title."';</script>";
	}
?>
</html>