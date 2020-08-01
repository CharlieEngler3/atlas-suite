<?php
	session_start();

	unset($_SESSION['username']);

	echo "<script>location.href='../index.php';</script>"
?>