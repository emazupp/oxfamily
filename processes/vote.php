<?php
	include "../config.php";
	session_start();
	if(isset($_SESSION["ID"])) {
		if(isset($_POST["cod"])) {
			$ID = $_SESSION["ID"];
			$Cod = $_POST["cod"];
			$vote = $_POST["vote"];
			$sql = "INSERT INTO $votare (ID, Cod, Voto) VALUES ('$ID', '$Cod', '$vote') ON DUPLICATE KEY 
			UPDATE voto='$vote'";
			if(mysqli_query($conn, $sql)) {
				header("Location: ../profile.php?success_vote_added");
			}
			else {
				header("Location: ../new.php?error");
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