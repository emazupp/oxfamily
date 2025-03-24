<!DOCTYPE html>
<html>
<?php 
	include "config.php";
    session_start();
?>
	<head>
		<link href="style.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<title>OxFamily</title>
	</head>

	<body>
		<div id="svg_circle" style="height: 30px; width: 30px;">
			<svg id="dark-light" viewBox="0 0 24 24" stroke="grey" stroke-width="1" fill="transparent" stroke-linecap="round" stroke-linejoin="round" width="30px" heigth="30px">
				<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
			</svg>
		</div>
		<nav id="nav" class="navbar">
			<div class="logo">
				<img src="img/logo.png" width="72" height="45" alt="">
			</div>
			<div class="nav_container">
				<div class="nav_elements">
					<li><a class="elements" href="index.php">Anime</a></li>
					<li> <a class="elements" href="serietv.php"> Serie TV </a> </li>
					<li> <a class="elements" href="manga.php"> Manga </a> </li>
					<li> <a class="elements" href="new.php"> New anime </a> </li>
					<li> <a class="elements" href="newtv.php"> New serie</a> </li>
					<li> <a class="elements" href="newmanga.php"> New manga</a> </li>
				</div>
			</div>
			<div class="avatar_wrap">
				<?php
					if(isset($_SESSION["ID"])) {
						echo "<img onclick=\"openProfile()\" id=\"avatar\" src=\"avatar_img/".$_SESSION["avatar_image"]."\" width=\"52\" height=\"52\" alt=\"avatar\">";
					}
					else {
						echo "<img id=\"avatar\" src=\"avatar_img/standard_avatar.jpg\" width=\"52\" height=\"52\" alt=\"avatar\">";
					}
				?>
			</div>
			<div class="username_wrap">
				<span id="session_username">
					<?php 
						if(isset($_SESSION["ID"])) {
							echo $_SESSION["Nome"];
						}
					?>
				</span>
			</div>
		</nav>
		<div class="inv_sup_separator"></div>
		<div id="profilemain_wrap">
			<div id="profilecontainer_left">
				<div class="profileavatar_img">
					<?php
						echo "<img id=\"avatar\" src=\"avatar_img/".$_SESSION["avatar_image"]."\" width=\"170\" height=\"170\" alt=\"avatar\">"; 
					?>
				</div>
				<div class="profileupdate_img">
					<form action="processes/updateavatar.php" method="post" enctype="multipart/form-data">

						<div id="container_inputfile">
							<input type="file" name="image" id="file" class="inputfile">
							<div id="material_icons">
								<span id="icon" class="material-icons">
									filter_drama
								</span>
							</div>
							<label id="label_uploadfile" for="file">
								<span>Scegli immagine</span>
							</label>
						</div>
						
						<input type="submit" class="profile_senduploadbutton" value="send">
					</form>
				</div>

				<div class="profileform">
					<form action="processes/updatename_username.php" method="post" enctype="multipart/form-data" autocomplete="off">
						<br>
						<span style="font-size: 14px;">Cambia nome:</span><br>
						<input name="newname" class="profiletext" type="text" maxlength="30" required placeholder="Nuovo nome...">
					<br>
						<span style="font-size: 14px;">Cambia username:</span><br>
						<input name="newusername" class="profiletext" type="text" maxlength="30" required placeholder="Nuovo username...">
						<input class="profile" type="submit" value="send">
					</form>
					<br>
					<form action="processes/updatepassword.php" method="post" enctype="multipart/form-data" autocomplete="off">
						<span style="font-size: 14px;">Cambia password:</span><br>
						<input name="currentpassword" class="profiletext" type="text" maxlength="30" required placeholder="Password attuale..."><br>
						<input name="newpassword" class="profiletext" type="text" maxlength="30" required placeholder="Nuova password..."><br>
						<input name="confirmnewpassword" class="profiletext" type="text" maxlength="30" required placeholder="Conferma nuova password...">
						<input class="profile" type="submit" value="send">
					</form>
					<br>
					<form action="processes/logout.php">
						<span style="font-size: 14px;">Vuoi disconnetterti?</span> 
						<input type="submit" id="profilelogout_button" value="Logout">
					</form>
				</div>
			</div>

			<div id="profilecontainer_right">
				<div class="profilecontent_right">
				<div class="toggler_anime_serie">
					<li <?php if(!isset($_GET["voti_serie"]) && !isset($_GET["voti_manga"])) echo "class=\"active\";"?>> <a class="toggler" href="profile.php">Voti Anime</a></li>
					<li <?php if(isset($_GET["voti_serie"])) echo "class=\"active\";"?>> <a class="toggler" href="profile.php?voti_serie"> Voti Serie TV </a> </li>
					<li <?php if(isset($_GET["voti_manga"])) echo "class=\"active\";"?>> <a class="toggler" href="profile.php?voti_manga"> Voti Manga </a> </li>
				</div>
				</div>
				<div id="profiletable_right">
					<!-- <span>Ricerca per titolo:</span> -->
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Ricerca il titolo..." title="Type in a name">
					<div id="right_table">
						<?php 
							$ID = $_SESSION["ID"];
							$tabella = $anime;
							$votare_tab = $votare;
							$img_dir = "img";
							$vote_page = "vote.php";
							$deletevote_page = "deletevote.php";
							
							if(isset($_GET["voti_serie"])) {
								$tabella = $serietv;
								$votare_tab = $votaretv;
								$img_dir = "imgtv";
								$vote_page = "votetv.php";
								$deletevote_page = "deletevotetv.php";
							}
							
							if(isset($_GET["voti_manga"])) {
								$tabella = $manga;
								$votare_tab = $votaremanga;
								$img_dir = "imgmanga";
								$vote_page = "votemanga.php";
								$deletevote_page = "deletevotemanga.php";
							}							
							
							
							/*$serieTV_page = isset($_GET["voti_serie"]);
							$votare_tab = $serieTV_page ? $votaretv : $votare;
							$tabella = $serieTV_page ? $serietv : $anime;
							$img_dir = $serieTV_page ? "imgtv" : "img";
							$vote_page = $serieTV_page ? "votetv.php" : "vote.php";
							$deletevote_page = $serieTV_page ? "deletevotetv.php" : "deletevote.php";*/
							$sql = "WITH cte AS ( SELECT v.Cod, v.voto FROM $utenti u JOIN $votare_tab v ON v.ID = u.ID WHERE u.ID = $ID ) SELECT a.titolo, a.Cod, cte.voto, a.img_name FROM $tabella a LEFT JOIN cte ON cte.Cod = a.Cod ORDER BY cte.voto DESC";
							$result = mysqli_query($conn, $sql);
							$row = mysqli_fetch_array($result);
							$first = true;
							
							echo "<table id=\"myTable\">";
							echo "<tr>";
								echo "<th> </th>";
								echo "<th style=\"min-width: 200px;\"> Titolo </th>";
								echo "<th> Voto </th>";
								echo "<th> Modifica </th>";
								echo "<th> Elimina </th>";
							echo "</tr>";
							do {
								if($first) {
									echo "<tr> \n";
									echo "<td> <div class=\"profileanime_img\"> <img src=\"$img_dir/" .$row["img_name"] . "\"width=\"70\" height=\"70\"></div> </td> \n";
									echo "<td> <font color=\"red\">" . $row["titolo"] . "</font> </td> \n";
									echo "<form action=\"processes/$vote_page\" id=\"edit_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <input class=\"profiletext_vote\" name=\"vote\" required type=\"text\" form=\"edit_form".$row["Cod"]."\" placeholder=\"".$row["voto"]."...\"</td> \n";
									echo "<td> <div class=\"profile_edit_img\"> <button class=\"profileeditbutton\" name=\"cod\" type=\"submit\" form=\"edit_form".$row["Cod"]."\" value='".$row["Cod"]."'><img class=\"profile_editimage\" src=\"img/edit.png\" width=\"30\" height=\"30\"> </button> </div> </td> \n";
									echo "<form action=\"processes/$deletevote_page\" id=\"delete_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <div class=\"profile_trash_img\"> <button onclick=\"return confirm('Sei sicuro di voler eliminare questo voto?')\" class=\"profiletrashbutton\" name=\"cod\" type=\"submit\" form=\"delete_form".$row["Cod"]."\" value='".$row["Cod"]."'> <img class=\"profile_trashimage\" src=\"img/trash.png\" width=\"30\" height=\"30\"></div> </td> \n"; 
									echo "</tr> \n"; 
									$first = false;
								}
								else {
									echo "<tr> \n";
									echo "<td> <div class=\"profileanime_img\"> <img src=\"$img_dir/" .$row["img_name"] . "\"width=\"70\" height=\"70\"></div> </td> \n";
									echo "<td>" . $row["titolo"] . "</td> \n";
									echo "<form action=\"processes/$vote_page\" id=\"edit_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <input required class=\"profiletext_vote\" name=\"vote\" type=\"text\" form=\"edit_form".$row["Cod"]."\" placeholder=\"".$row["voto"]."...\"</td> \n";
									echo "<td> <div class=\"profile_edit_img\"> <button class=\"profileeditbutton\" name=\"cod\" type=\"submit\" form=\"edit_form".$row["Cod"]."\" value='".$row["Cod"]."'><img class=\"profile_editimage\" src=\"img/edit.png\" width=\"30\" height=\"30\"> </button> </div> </td> \n";
									echo "<form action=\"processes/$deletevote_page\" id=\"delete_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <div class=\"profile_trash_img\"> <button onclick=\"return confirm('Sei sicuro di voler eliminare questo voto?')\" class=\"profiletrashbutton\" name=\"cod\" type=\"submit\" form=\"delete_form".$row["Cod"]."\" value='".$row["Cod"]."'> <img class=\"profile_trashimage\" src=\"img/trash.png\" width=\"30\" height=\"30\"></div> </td> \n";
									echo "</tr> \n";
								}
							} while($row = mysqli_fetch_array($result));
						?>
					</div>
				</div>
			</div>
		</div>
	</body>

	<script>
		function myFunction() {
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById("myInput");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("myTable");
		  tr = table.getElementsByTagName("tr");
		  for (i = 0; i < tr.length; i++) {
		    td = tr[i].getElementsByTagName("td")[1];
		    if (td) {
		      txtValue = td.textContent || td.innerText;
		      if (txtValue.toUpperCase().indexOf(filter) > -1) {
		        tr[i].style.display = "";
		      } else {
		        tr[i].style.display = "none";
		      }
		    }       
		  }
		}

		//darkMode
		let darkMode = localStorage.getItem('darkMode');
		const darkModeToggle = document.querySelector('#svg_circle');

		function enableDarkMode() {
			document.getElementById("nav").style.setProperty("background", "#1c2125");
			document.body.style.setProperty("background", "#121619");
			document.getElementById("profilecontainer_left").style.setProperty("background-color", "#1c2125");
			document.getElementById("profilecontainer_left").style.setProperty("color", "#fff");
			for(var i = 0; i<document.getElementsByClassName("profiletext").length; i++) {
				document.getElementsByClassName("profiletext")[i].style.setProperty("background", "#1c2125");
				document.getElementsByClassName("profiletext")[i].style.setProperty("color", "#fff");
			}
			for(var i = 0; i<document.getElementsByClassName("profiletext_vote").length; i++) {
				document.getElementsByClassName("profiletext_vote")[i].style.setProperty("background-color", "#1c2125");
				document.getElementsByClassName("profiletext_vote")[i].style.setProperty("color", "#fff");
				document.getElementsByClassName("profile_editimage")[i].src="img/edit-dark.png";;
				document.getElementsByClassName("profile_trashimage")[i].src="img/trash-dark.png";;
			}
			document.getElementById("profilecontainer_right").style.setProperty("background-color", "#1c2125");
			document.getElementById("profilecontainer_right").style.setProperty("color", "#fff");
			document.getElementById("myInput").style.setProperty("background", "#1c2125");
			document.getElementById("myInput").style.setProperty("color", "#fff");
			document.getElementById("svg_circle").style.setProperty("background-color", "#323a4b");
			document.getElementById("dark-light").style.fill="#ffce45";
			localStorage.setItem('darkMode', 'enabled');
		}

		function disableDarkMode() {
			document.getElementById("nav").style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.body.style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.getElementById("profilecontainer_left").style.setProperty("background-color", "#fff");
			document.getElementById("profilecontainer_left").style.setProperty("color", "#000");
			for(var i = 0; i<document.getElementsByClassName("profiletext").length; i++) {
				document.getElementsByClassName("profiletext")[i].style.setProperty("background", "#fff");
				document.getElementsByClassName("profiletext")[i].style.setProperty("color", "#000");
			}
			for(var i = 0; i<document.getElementsByClassName("profiletext_vote").length; i++) {
				document.getElementsByClassName("profiletext_vote")[i].style.setProperty("background-color", "#fff");
				document.getElementsByClassName("profiletext_vote")[i].style.setProperty("color", "#000");
				document.getElementsByClassName("profile_editimage")[i].src="img/edit.png";;
				document.getElementsByClassName("profile_trashimage")[i].src="img/trash.png";;
			}
			document.getElementById("profilecontainer_right").style.setProperty("background-color", "#fff");
			document.getElementById("profilecontainer_right").style.setProperty("color", "#000");
			document.getElementById("myInput").style.setProperty("background", "#fff");
			document.getElementById("myInput").style.setProperty("color", "#000");
			document.getElementById("svg_circle").style.setProperty("background-color", "#fafafa");
			document.getElementById("dark-light").style.fill="transparent";
			localStorage.setItem('darkMode', null);
		}

		if (darkMode === 'enabled') {
			enableDarkMode();
		}

		darkModeToggle.addEventListener('click', () => {
			darkMode = localStorage.getItem('darkMode');
			if(darkMode !== 'enabled') {
				enableDarkMode();
			}else {
				disableDarkMode();
			}
		});


	</script>
</html>