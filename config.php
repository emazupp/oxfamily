<?php
	//error_reporting(0);
	$host = "localhost";
	$user = "root";
	$password = "";
    $db_name = "my_oxfamily";	
	$utenti = "utenti";
	$anime = "anime";
	$votare = "votare";
	$serietv = "serietv";
	$votaretv = "votaretv";
	$manga = "manga";
	$votaremanga = "votaremanga";
	$conn = mysqli_connect($host, $user, $password, $db_name);
	if (!$conn) {
        echo "Connessione fallita, il server potrebbe essere spento o in manutenzione. Riprova piu' tardi.";
        exit;
	}
?>