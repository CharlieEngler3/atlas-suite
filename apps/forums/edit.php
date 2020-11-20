<?php
  $title = $_POST['title'];
  $id = $_POST['post_id'];

	include("../../../password.php");

	$conn = new mysqli($servername, $server_user, $serverpassword, "forums");
	
  $result = $conn->query("SELECT * FROM posts WHERE title='$title' AND id='$id'");

  $row = $result->fetch_assoc();

  $bodyText = $row['body'];

  $image_links = $row['image_links'];

  $image_links = str_replace("⎖", " ", $image_links);
?>

<html>
  <head>
    <title>Edit - <?php echo $title; ?></title>
    
    <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <div class="user_bar">
      <form id="backSubmit" method="POST" action="show_post.php">
        <input type="hidden" name="title" value="<?php echo $title; ?>"/>
        <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
      </form>
      <a style='cursor:pointer;' onclick='submitBack()'>Back to <?php echo $title; ?></a>
    </div>

    <div class="user_bar">
      <a style='cursor:pointer;' href="edit.php?title=<?php echo $title; ?>&post_id=<?php echo $id; ?>&delete=true">Delete</a>
    </div>
  </head>
  
  <body>
    <h1>Edit Mode</h1>
    
    <form class="post" action="#" method="POST">
      <input type="text" class="edit_post_text" name="newTitle" maxlength="100" value="<?php echo $title; ?>"/>
      <textarea id="newBody" class="edit_post_body" name="body" maxlength="3000"><?php echo $bodyText; ?></textarea>
      <input type='text' class="edit_post_text" name='images' value='<?php echo $image_links ?>' placeholder='Put image links here divided by spaces'/>
      <input type="hidden" name="title" value="<?php echo $title; ?>"/>
      <input type="hidden" name="post_id" value="<?php echo $id; ?>"/>
      <input type="submit" class="edit_post_submit" value="Update Post"/>
    </form>
  </body>
</html>

<?php
  if(isset($_POST['body']))
  {
    $body = $_POST['body'];
    $id = $_POST['post_id'];
    
    $conn->query("UPDATE posts SET body='$body' WHERE title='$title' AND id='$id'");
  }

  if(isset($_POST['newTitle']))
  {
    $newTitle = $_POST['newTitle'];
    $id = $_POST['post_id'];
    
    $conn->query("UPDATE posts SET title='$newTitle' WHERE title='$title' AND id='$id'");
  }

  if(isset($_POST['images']))
  {
    $images = $_POST['images'];
    $id = $_POST['post_id'];
    
    $images = str_replace(" ", "⎖", $images);
    
    $conn->query("UPDATE posts SET image_links='$images' WHERE title='$title' AND id='$id'");
  }

  if(isset($_POST['newTitle']) || isset($_POST['body']))
  {
    echo "<form id='autoSubmit' action='show_post.php' method='POST'><input type='hidden' name='title' value='".$newTitle."'/><input type='hidden' name='post_id' value='".$id."'/></form>";
  }

  if(isset($_GET['delete']))
  {
    $title = $_GET['title'];
    $id = $_GET['post_id'];

    $conn->query("DELETE FROM posts WHERE title='$title' AND id='$id'");

    echo "<script>location.href = 'index.php';</script>";
  }
?>

<script type="text/javascript">

  function formAutoSubmit()
  {
    var frm = document.getElementById("autoSubmit");

    frm.submit();
  }

  window.onload = formAutoSubmit();
  
  function submitBack()
  {
    var frm = document.getElementById("backSubmit");

    frm.submit();
  }

</script>