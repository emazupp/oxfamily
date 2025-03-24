<?php
	include "../config.php";
	session_start();
	if(!isset($_SESSION["ID"])) {
		header("Location: ../login.php");
		return;
	}

	if(isset($_POST["title"]) && isset($_POST["trailer"])) {
		$trailer = mysqli_real_escape_string($conn, $_POST["trailer"]);
		$title = mysqli_real_escape_string($conn, $_POST["title"]);
		$target_dir = "../imgtv/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$check = getimagesize($_FILES["image"]["tmp_name"]);
		$sql = "";
		
		if (file_exists($target_file)) {
			  echo $target_file;
			  header("Location: ../newtv.php?error_file_exists");
		}
		
		if($check !== false) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				$image_name = $_FILES["image"]["name"];
				$sql = "INSERT INTO $serietv (Titolo,img_name, trailer) VALUES ('$title', '$image_name', '$trailer')";
			}
			else {
				//Chi minchia a fare ca boh.
				//$sql = "INSERT INTO $anime (Titolo) VALUES '$title'";
			}
	    } else {
			header("Location: ../newtv.php?error_file_not_image");
			return;
		}
		if(mysqli_query($conn, $sql)) {
			header("Location: ../newtv.php?success_file_uploaded");
		}
		else {
			header("Location: ../newtv.php?error_sql");
		}
	}
	else {
		header("Location: ../serietv.php");
	}
?>