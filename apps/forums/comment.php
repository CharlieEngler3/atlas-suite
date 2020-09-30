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