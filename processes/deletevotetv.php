<?php
	include "../config.php";
	session_start();
	if(isset($_SESSION["ID"])) {
		if(isset($_POST["cod"])) {
			$ID = $_SESSION["ID"];
			$Cod = $_POST["cod"];
			$sql = "DELETE FROM $votaretv WHERE ID='$ID' AND Cod='$Cod'";
			if(mysqli_query($conn, $sql)) {
				header("Location: ../profile.php?voti_serie&success_vote_deleted");
			}
			else {
				header("Location: ../profile.php?voti_serie&error");
			}
		}
		else {
			header("Location: ../index.php");
		}
	}
	else {
		header("Location: ../login.php");
	}
?>