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

	include("../../../password.php");
  
	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");
	  
	$result = $conn->query("SELECT * FROM posts WHERE title = '$title'");

	while($row = $result->fetch_assoc())
	{
		$user = $row['user'];
		$body = $row['body'];
		$image_links = $row['image_links'];
		$comments = $row['comments'];
		$comment_users = $row['comment_users'];
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
			<form id="editSubmit" method="POST" action="edit.php"><input type="hidden" name="title" value="<?php echo $title; ?>"/></form>
		  <?php
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
				<input type="text" name="comment" class='comment_field' placeholder="Add a comment"/>
				<input type="hidden" name="title" value="<?php echo $title; ?>"/>
				<input type="submit" class='submit_comment' value="Submit"/>
			</form>
	  <?php
		}
	  ?>
	  
		<?php
			$commentArray = explode("⎖", $comments);
			$userArray = explode("⎖", $comment_users);
			
			for($i = 0; $i < sizeof($commentArray); $i++)
			{
				if($commentArray[$i] != "")
				{
				echo "<div class='comment'>".$commentArray[$i]."<div class='comment_user'>By: ".$userArray[$i]." ";
				if(isset($_SESSION['username']))
				{
					if($userArray[$i] == $_SESSION['username'])
					{
						echo "<a href='comment.php?title=".$title."&edit_comment=".$commentArray[$i]."'>Edit</a>";
					}
				}
				
				echo "</div></div>";
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