<?php
	include "../config.php";
	session_start();
	$sql = "UPDATE $utenti SET Status='OFFLINE' WHERE ID='".$_SESSION["ID"]."'";
	$result = mysqli_query($conn, $sql);
	$_SESSION = array();
	session_unset();
	session_destroy();
	header("Location: ../index.php");
?>