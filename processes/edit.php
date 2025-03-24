<?php
	
	include "../config.php";
	
	if(isset($_POST["title"])) {
		if($_POST["title"] != "empty") {
			$title = $_POST["title"];
			$newtitle = mysqli_real_escape_string($conn, $_POST["newtitle"]);
			$sql = "";
			if($newtitle == "") {
				$newtitle = $title;
			}
			$target_dir = "../img/";
			$target_file = $target_dir . basename($_FILES["image"]["name"]);
			$check = getimagesize($_FILES["image"]["tmp_name"]);
			$sql = "UPDATE $anime SET Titolo='$newtitle' WHERE Titolo='$title'";
			
			if(basename($_FILES["image"]["name"] != "")) {
				if (file_exists($target_file)) {
					//Sovrascrivi file
					header("Location: ../new.php?error_file_exists");
					return;
				}
				if($check !== false) {
					if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
						$sql_ = "SELECT img_name FROM $anime WHERE Titolo='$title'";
						$query = mysqli_query($conn, $sql_);
					    $result = mysqli_fetch_array($query);
					    $image_to_remove = $result["img_name"];
						unlink("../img/".$image_to_remove);
						$image_name = $_FILES["image"]["name"];
						$sql = "UPDATE $anime SET Titolo='$newtitle', img_name='$image_name' WHERE Titolo='$title'";
					}
					else {
						header("Location: ../new.php?error_upload_file");
						return;
					}
				} 
				else {
					header("Location: ../new.php?error_file_not_image");
					return;
				}				
			}
			if($sql == "") {
				header("Location: ../new.php");
				return;
			}
			if(mysqli_query($conn, $sql)) {
				header("Location: ../new.php?success_file_edited");
			}
			else {
				header("Location: ../new.php?error_sql");
			}
		}
		else {
			header("Location: ../index.php?error_no_selected_title");
		}
	}
	else {
		header("Location: ../index.php");
	}
?>