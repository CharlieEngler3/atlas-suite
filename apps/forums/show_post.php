<?php
  session_start();

  $title = $_POST['title'];

  $servername = "localhost";
  $server_user = "root";

  $conn = new mysqli($servername, $server_user, "", "forums");

  $result = $conn->query("SELECT * FROM posts WHERE title = '$title'");

  $row = $result->fetch_assoc();
?>

<html>
  <head>
    <title><?php echo $title; ?></title>
    
    <link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <a href='index.php'>Home</a>

    <?php
      if(isset($_SESSION['username']))
      {
        if($row['user'] == $_SESSION['username'])
        {
          ?>
            <form id="editSubmit" method="POST" action="edit.php"><input type="hidden" name="title" value="<?php echo $title; ?>"/></form>
          <?php

          echo "<a style='cursor:pointer;' onclick='submitEdit()'>Edit</a>";
        }
      }
    ?>
  </head>
  
  <body>
    <h1><u>
      <?php echo $title; ?>
    </u></h1>
    <div class='author'>
      By: <?php echo $row['user'] ?>
    </div>
    
    <div class='post'>
      <?php echo $row['body']; ?>
      
      <div class='images'>
        Click on images to expand them.
        <br>
        <br>
        <?php
          $image_links = explode("⎖", $row['image_links']);

          for($i = 0; $i < sizeof($image_links); $i++)
          {
            echo "<img onclick='ExpandImage(\"".$image_links[$i]."\")' src='".$image_links[$i]."' height='10%'>";
          }
        ?>
      </div>
    </div>
    
    <h3>
      Comments:
    </h2>
    
    <div class="comments">
      <?php
        if(isset($_SESSION['username']))
        {
      ?>
          <form action="comment.php" method="POST" autocomplete=off>
            <input type="text" name="comment" style="font-size:2vw;" placeholder="Add a comment"/>
            <input type="hidden" name="title" value="<?php echo $title; ?>"/>
            <input type="submit" style="font-size:2vw;" value="Submit"/>
          </form>
      <?php
        }
      ?>
      
      <?php
        $comments = $row['comments'];
        $users = $row['comment_users'];
      
        $commentArray = explode("⎖", $comments);
        $userArray = explode("⎖", $users);
        
        for($i = 0; $i < sizeof($commentArray); $i++)
        {
          if($commentArray[$i] != "")
          {
            echo "<div class='comment'>".$commentArray[$i]."<div class='comment_user'>By: ".$userArray[$i]."</div></div>";
          }
        }
      ?>
    </div>
    
    <div class="browse">
      
    </div>

    <script>
      function submitEdit()
      {
        var frm = document.getElementById("editSubmit");

        frm.submit();
      }
      
      function ExpandImage(link)
      {
        var expandedImage = document.createElement("IMG");
        expandedImage.class = "expanded_image";
        expandedImage.onclick = "MinimizeImage()";
        expandedImage.id = "expanded_image";
        expandedImage.src = link.toString();
      }
      
      function MinimizeImage()
      {
        document.getElementById('expanded_image').remove();
      }
    </script>
  </body>
</html>