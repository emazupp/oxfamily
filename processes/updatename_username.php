<?php
	include "../config.php";
	session_start();
	if(!isset($_SESSION["ID"])) {
		header("Location: /login.php");
		return;
	}

	if(isset($_POST["newname"]) && isset($_POST["newusername"])) {
		$newname = mysqli_real_escape_string($conn,$_POST["newname"]);
		$newusername = mysqli_real_escape_string($conn,$_POST["newusername"]);
		$sql = "UPDATE $utenti SET Nome='$newname' WHERE ID='".$_SESSION["ID"]."'";
		mysqli_query($conn, $sql);
		$sql2 = "UPDATE $utenti SET Username='$newusername' WHERE ID='".$_SESSION["ID"]."'";
		mysqli_query($conn, $sql2);
		$_SESSION["Nome"]=$newname;
		$_SESSION["Username"]=$newusername;
		header("Location: ../profile.php?done");
	}
?>