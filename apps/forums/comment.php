<?php
	session_start();

	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
	}

	if(isset($_GET['title']))
	{
		$title = $_GET['title'];
	}
?>
<html>
	<head>
		<title><?php echo $title." Edit Comment"; ?></title>

		<link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

		<meta name='viewport' content='width=device-width, initial-scale=1'>

		<div class='user_bar'>
			<a href="show_post.php?title=<?php echo $title; ?>">Back</a>
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
  	$username = $_SESSION['username'];

	include("../../../password.php");

	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");
  
	if(isset($_POST['comment']))
	{
		$title = $_POST['title'];
		$comment = $_POST['comment'];

		if(isset($_POST['edited_comment']))
		{
			$edited_comment = $_POST['edited_comment'];

			$result = $conn->query("SELECT * FROM posts WHERE title='$title'");

			while($row = $result->fetch_assoc())
			{
				$comments = $row['comments'];

				$title = $_POST['title'];

				$comments = str_replace($edited_comment, $_POST['comment'], $comments);

				$conn->query("UPDATE posts SET comments='$comments' WHERE title='$title'");

				echo "<script>location.href='show_post.php?title=".$title."'</script>";
			}
		}
		else
		{
			$comment = $comment."⎖";
			$commentUser = $username."⎖";

			$result = $conn->query("SELECT * FROM posts WHERE title='$title'");

			if($result->num_rows != 0)
			{
				$row = $result->fetch_assoc();

				$allComments = $row['comments'];
				$allUsers = $row['comment_users'];
			}
			else
			{
				$allComments = "";
				$allUsers = "";
			}

			$allComments = $allComments.$comment;
			$allUsers = $allUsers.$commentUser;

			echo $allComments."<br>";
			echo $allUsers."<br>";

			$conn->query("UPDATE posts SET comments='$allComments' WHERE user='$username'");
			$conn->query("UPDATE posts SET comment_users='$allUsers' WHERE user='$username'");
		}

		echo "<form id='autoSubmit' action='show_post.php' method='POST'><input type='hidden' name='title' value='".$title."'/></form>";
	}

	if(isset($_GET['edit_comment']))
	{
		$title = $_GET['title'];
		$comment = $_GET['edit_comment'];

		?>
			<form action="#" class='comments' method="POST" autocomplete=off>
				<input type="text" name="comment" class='comment_field' value="<?php echo $comment; ?>"/>
				<input type="hidden" name="edited_comment" value="<?php echo $comment; ?>"/>
				<input type="hidden" name="title" value="<?php echo $title; ?>"/>
				<input type="submit" class='submit_comment' value="Submit"/>
			</form>
		<?php
	}
?>
</html>