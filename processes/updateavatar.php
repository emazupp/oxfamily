<?php
	include "../config.php";
	session_start();
	$target_dir = "../avatar_img/";
	$ID = $_SESSION["ID"];
	$target_file = $target_dir . $ID."_" . basename($_FILES["image"]["name"]);
	$_FILE["image"]["name"] = $ID."_".$_FILE["image"]["name"];
	$check = getimagesize($_FILES["image"]["tmp_name"]);
	if(basename($_FILES["image"]["name"] != "")) {
		if (file_exists($target_file)) {
			header("Location: ../profile.php?error_file_exists");
			return;
		}
		if($check !== false) {
			if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
				$sql_ = "SELECT avatar_image FROM $utenti WHERE ID='$ID'";
				$query = mysqli_query($conn, $sql_);
				$result = mysqli_fetch_array($query);
				$image_to_remove = $result["avatar_image"];
				if($image_to_remove != "standard_avatar.jpg")
					unlink("../avatar_img/".$image_to_remove);
				$image_name = $ID."_".$_FILES["image"]["name"];
				$sql = "UPDATE $utenti SET avatar_image = '$image_name' WHERE ID=$ID";
				$_SESSION["avatar_image"] = $image_name;
			}
			else {
				header("Location: ../profile.php?error_upload_file");
				return;
			}
		} 
		else {
			header("Location: ../profile.php?error_file_not_image");
			return;
		}	
		if(mysqli_query($conn, $sql)) {
			header("Location: ../profile.php?success_file_edited");
		}
		else {
			header("Location: ../profile.php?error_sql");
		}	
	}
	else {
		echo "qualcosa è andato storto";
	}
?>