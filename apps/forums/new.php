<html>
    <head>
        <script>
            function SubmitForm()
            {
                  var frm = document.getElementById("editSubmit");

                  frm.submit();
            }
        </script>
    </head>
</html>

<?php
    session_start();

    $title = $_POST['title'];
    $body = $_POST['body'];
    $images = implode("⎖", $_POST['images']);
    $user = $_SESSION['username'];

    include("../../../password.php");

    $conn = new mysqli($servername, $server_user, $serverpassword, "forums");

    if ($conn->connect_error) 
    {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("INSERT INTO posts(title, body, image_links, user, visibility) VALUES ('$title', '$body', '$images', '$user', 'public')");

    $conn->close();

    echo "<script>location.href = 'browse.php';</script>";
?>