<?php
  session_start();

  $title = $_POST['title'];
  $comment = $_POST['comment'];

  $user = $_SESSION['username'];

  $servername = "localhost";
  $server_user = "root";

  $conn = new mysqli($servername, $server_user, "", "forums");

  $comment = $comment."⎖";
  $commentUser = $user."⎖";

  $commentResult = $conn->query("SELECT * FROM posts WHERE title='$title'");

  if($commentResult->num_rows != 0)
  {
    $commentRow = $commentResult->fetch_assoc();

    $allComments = $commentRow['comments'];
  }
  else
  {
    $allComments = "";
  }

  $usersResult = $conn->query("SELECT * FROM posts WHERE title='$title'");
  
  if($usersResult->num_rows != 0)
  {
    $usersRow = $usersResult->fetch_assoc();

    $allUsers = $usersRow['comment_users'];
  }
  else
  {
    $allUsers = "";
  }

  $allComments = $allComments.$comment;
  $allUsers = $allUsers.$commentUser;

  $conn->query("UPDATE posts SET comments='$allComments' WHERE user='$user'");
  $conn->query("UPDATE posts SET comment_users='$allUsers' WHERE user='$user'");

  echo "<form id='autoSubmit' action='show_post.php' method='POST'><input type='hidden' name='title' value='".$title."'/></form>";
?>

<script type="text/javascript">

  function formAutoSubmit()
  {
    var frm = document.getElementById("autoSubmit");

    frm.submit();
  }

  window.onload = formAutoSubmit();

</script>