<?php
	include "../config.php";
	if(isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") { //Se esistono i parametri passati dalla pagina precedente
		
		//Inserire condizione se gia' loggato
		
		$username = mysqli_real_escape_string($conn,$_POST["username"]); //aggiusta la stringa
		$password = mysqli_real_escape_string($conn,$_POST["password"]); //aggiusta la stringa
		$sql = "SELECT * FROM $utenti WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($conn, $sql);
		$count = mysqli_num_rows($result);
		$authorize = $count == 1;
		if($authorize) {
			session_start();
			$row = mysqli_fetch_array($result);
			$_SESSION["ID"] = $row["ID"];
			$_SESSION["Username"] = $username;
			$_SESSION["Nome"] = $row["Nome"];
			$_SESSION["Password"] = $password;
			$_SESSION["avatar_image"] = $row["avatar_image"];
			$_SESSION["Staff"] = $row["Staff"];
			$sql = "UPDATE $utenti SET Status='ONLINE' WHERE ID='".$_SESSION["ID"]."'";
			$result = mysqli_query($conn, $sql);
			header("Location: ../index.php");
		}
		
		else {
			header("Location: ../login.php?error_login");
		}
    }
    else {
        header("Location: ../index.php");
    }
?>