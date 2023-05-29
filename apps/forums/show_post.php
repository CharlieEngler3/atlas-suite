<?php
  	session_start();

	if(isset($_POST['title']))
	{
		$title = $_POST['title'];
		$id = $_POST['post_id'];
	}
	  
	if(isset($_GET['title']))
	{
		$title = $_GET['title'];
		$id = $_GET['post_id'];
	}

	if(isset($_SESSION['username']))
	{
		$user = $_SESSION['username'];
	}

	include("../../../password.php");
  
	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");

	$result = $conn->query("SELECT * FROM posts WHERE title='$title' AND id='$id'");

	while($row = $result->fetch_assoc())
	{
		$user = $row['user'];
		$body = $row['body'];
		$image_links = $row['image_links'];
		$visibility = $row['visibility'];
	}
?>

<html>
  <head>
	<title><?php echo $title; ?></title>
	
	<link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

	<meta name='viewport' content='width=device-width, initial-scale=1'>
	
	<div class='user_bar'>
		<a href='../../index.php'>Home</a>
	</div>

	<div class='user_bar'>
		<a href='index.php'>Forums</a>
	</div>
	
	<?php
		if(isset($_SESSION['username']))
		{
			if($user == $_SESSION['username'])
			{
				echo "<div class='user_bar'><a onclick='submitEdit()'>Edit</a></div>";

				?>
					<form id="editSubmit" method="POST" action="edit.php">
						<input type="hidden" name="title" value="<?php echo $title; ?>"/>
						<input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
					</form>
				<?php
			}
			else
			{
				if($visibility == "private")
				{
					echo "<script>location.href='index.php';</script>";
				}
			}
		}
		else
		{
			if($visibility == "private")
			{
				echo "<script>location.href='index.php';</script>";
			}
		}
	?>
  </head>
  
	<body>
		<h1><u>
			<?php echo $title; ?>
		</u></h1>
		<div class='author'>
			By: <?php echo $user ?>
		</div>

		<div class='ratings'>
			<?php
				if(isset($_SESSION['username']))
				{
					echo "<a href='like_post.php?post_id=".$id."&like_value=1' class='rating'>🖒</a>";
					echo "<a href='like_post.php?post_id=".$id."&like_value=-1' class='rating'>🖓</a>";
				}
			?>
		</div>
		
		<div class='post'>
			<?php 
				echo $body; 

				if($image_links != "")
				{
			?>
			
			<div id='images' class='images'>
				Click on images to expand them.
				<br>
				<br>
				<?php
					$image_links_arr = explode("⎖", $image_links);

					for($i = 0; $i < sizeof($image_links_arr); $i++)
					{
					echo "<img onclick='ExpandImage(\"".$image_links_arr[$i]."\");' src='".$image_links_arr[$i]."'>";
					}
				?>
			</div>

			<?php
				}
			?>
		</div>

		
		
		<div class="comments">
			<h3>
				Comments:
			</h3>

			<?php
				if(isset($_SESSION['username']))
				{
			?>
					<form action="comment.php" method="POST" autocomplete=off>
						<input type="text" name="comment" class='comment_field' maxlength="300" placeholder="Add a comment"/>
						<input type="hidden" name="title" value="<?php echo $title; ?>"/>
						<input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
						<input type="submit" class='submit_comment' value="Submit"/>
					</form>
			<?php
				}
			?>
		
			<?php
				$result = $conn->query("SELECT * FROM comments WHERE post='$title' AND post_id='$id'");

				if($result)
				{
					while($row = $result->fetch_assoc())
					{
						if($row['replying_to'] == 0)
						{
							echo "<div class='comment'>".$row['comment']."<div class='comment_user'>By: ".$row['username']." ";
							if(isset($_SESSION['username']))
							{
								if($row['username'] == $_SESSION['username'])
								{
									echo "<a href='comment.php?title=".$title."&post_id=".$id."&edit_comment=".$row['comment']."&username=".$row['username']."'>Edit</a>";
									echo " ";
									echo "<a href='comment.php?title=".$title."&post_id=".$id."&delete_comment=".$row['comment']."&username=".$row['username']."'>Delete</a>";
								}

								echo " ";
								echo "<a href='comment.php?title=".$title."&post_id=".$id."&comment=".$row['comment']."&reply=true'>Reply</a>";
							}

							if($row['replies'] > 0)
							{
								echo "<br/><a href='comment.php?title=".$title."&post_id=".$id."&comment=".$row['comment']."&username=".$row['username']."&replies=true'>Replies</a>";
							}

							echo "</div></div>";
						}
					}
				}
			?>
		</div>

		<script>
			function submitEdit()
			{
				var frm = document.getElementById("editSubmit");

				frm.submit();
			}
			
			function ExpandImage(link)
			{
				if(!document.getElementById("expanded_image"))
				{
				var expandedImage = document.createElement("IMG");
				expandedImage.className = "expanded_image";
				expandedImage.onclick = function() {document.getElementById("expanded_image").remove();};
				expandedImage.id = "expanded_image";
				expandedImage.src = link.toString();

				document.body.appendChild(expandedImage);
				}
			}
		</script>
	</body>
</html>