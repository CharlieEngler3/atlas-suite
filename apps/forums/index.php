<?php 
    session_start(); 

    include("../../../password.php");

    $conn = new mysqli($servername, $server_user, $serverpassword, "forums");
    $conn2 = new mysqli($servername, $server_user, $serverpassword, "notifications");
?>

<html>
	<head>
    	<title>Forums</title>
      
      	<link rel="stylesheet" type="text/css" href="../../style/dark.css"/>

      	<meta name='viewport' content='width=device-width, initial-scale=1'>
        
      	<div class="user_bar">
        	<a href='../../index.php'>Home</a>
      	</div>
        
        <?php
          if(!isset($_SESSION['username']))
          {
            ?>
				<div class="user_bar">
					<a href="../../user/signin.php">Sign In</a>
              	</div>
            <?php
          }
          else
          {
            ?>
				<div class="user_bar">
					<a href="../../user/profile.php">Account</a>
				</div>

				<div class="user_bar">
					<a href="../../user/signout.php">Sign Out</a>
				</div>
            <?php
          }
        ?>

		<script>
			function AddImageLink()
			{
				var parent = document.getElementById("image_links");

                var newLink = document.createElement("INPUT");

                newLink.setAttribute("type", "text");
                newLink.className = "task_add";
                newLink.placeholder = "Image Link";
                newLink.name = "images[]";

                var deleteButton = document.createElement("INPUT");

                deleteButton.setAttribute("type", "button");
                deleteButton.className = "task_notes_delete";
                deleteButton.value = "x";
                deleteButton.setAttribute("onclick", "RemoveImageLink(" + (parent.childElementCount+1) + ")");

                parent.appendChild(newLink);
                parent.appendChild(deleteButton);
                parent.appendChild(document.createElement("BR"));
			}

			function RemoveImageLink(offset)
			{
				var parent = document.getElementById("image_links");

                parent.removeChild(parent.childNodes[offset]);
				parent.removeChild(parent.childNodes[offset]);
				parent.removeChild(parent.childNodes[offset]);

                var otherDeleteBtns = document.getElementsByClassName("task_notes_delete");

                for(let i = 0; i < otherDeleteBtns.length; i++)
                {
                    let rmVal = otherDeleteBtns[i].getAttribute("onclick");

                    let rmOffset = parseInt(rmVal.substring(rmVal.lastIndexOf("(") + 1, rmVal.lastIndexOf(")")));

                    if(rmOffset > offset)
                    {
                        rmOffset -= 3;

                        otherDeleteBtns[i].setAttribute("onclick", "RemoveImageLink(" + rmOffset + ")");
                    }
                }
			}
		</script>
    </head>
    
    <body>
		<h1>Forums</h1>

		<div class="browse_menu">
			<input type='submit' onclick="location.href='browse.php';" value="Browse">
		</div>
      
      	<div class="search_menu">
            <form method='post' action='search.php' style='text-align:center;' autocomplete='off'>
				<input type='text' name='search_term' placeholder='Search Term' maxlength="300"/>
				<br/>
				<input type='submit' value='Search'/>
            </form>
      	</div>

      	<div class="new_menu">
			<?php
				if(isset($_SESSION['username']))
				{
			?>
            <form method='post' action='new.php' style='text-align:center;' autocomplete='off'>
                <input type='text' name='title' placeholder='Title' maxlength="300"/>
                <br/>
                <textarea name='body' placeholder='Write the body text of your post here.' maxlength="3000"></textarea>
                <br/>
				<input type="button" class="task_add" onclick="AddImageLink()" value="Add Image Link"/>
				<div id="image_links">
				</div>
                <input type='submit' value='Create'/>
            </form>

			<?php
				}
				else
				{
			?>

			<h3 class="new_user_prompt">Please <a href='../../user/signin.php'>Sign in</a> for this feature</h3>

			<?php
				}
			?>
      	</div>
    </body>
</html>