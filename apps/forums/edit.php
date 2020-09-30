<?php
  $title = $_POST['title'];

  $servername = "localhost";
  $server_user = "root";

  $conn = new mysqli($servername, $server_user, "", "forums");

  $result = $conn->query("SELECT * FROM posts WHERE title = '$title'");

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
      <form id="backSubmit" method="POST" action="show_post.php"><input type="hidden" name="title" value="<?php echo $title; ?>"/></form>
      <a style='cursor:pointer;' onclick='submitBack()'>Back to <?php echo $title; ?></a>
    </div>
  </head>
  
  <body>
    <h1>Edit Mode</h1>
    
    <form action="#" method="POST">
      <input type="text" name="newTitle" value="<?php echo $title; ?>"/>
      <textarea id="newBody" name="body"><?php echo $bodyText; ?></textarea>
      <input type='text' name='images' style='font-size:2vw;' value='<?php echo $image_links ?>' placeholder='Put image links here divided by spaces'/>
      <input type="hidden" name="title" value="<?php echo $title; ?>"/>
      <input type="submit" value="Update Post"/>
    </form>
  </body>
</html>

<?php
  if(isset($_POST['body']))
  {
    $body = $_POST['body'];
    
    $conn->query("UPDATE posts SET body='$body' WHERE title='$title'");
  }

  if(isset($_POST['newTitle']))
  {
    $newTitle = $_POST['newTitle'];
    
    $conn->query("UPDATE posts SET title='$newTitle' WHERE title='$title'");
  }

  if(isset($_POST['images']))
  {
    $images = $_POST['images'];
    
    $images = str_replace(" ", "⎖", $images);
    
    $conn->query("UPDATE posts SET image_links='$images' WHERE title='$title'");
  }

  if(isset($_POST['newTitle']) || isset($_POST['body']))
  {
    echo "<form id='autoSubmit' action='show_post.php' method='POST'><input type='hidden' name='title' value='".$newTitle."'/></form>";
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