<!DOCTYPE html>
<html>
<?php 
	include "config.php";
    session_start();
	if($_GET["ID"] > 6) {
		echo "L'utente non esiste";
		return;
	}		
?>
	<head>
		<link href="style.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<title>OxFamily</title>
	</head>

	<body>
		<nav id="nav" class="navbar">
			<div class="logo">
				<img src="img/logo.png" width="72" height="45" alt="">
			</div>
			<div class="nav_container">
				<div class="nav_elements">
					<li> <a class="elements" href="index.php">Anime</a></li>
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
				<div class="profilesavatar_img">
					<?php
						$ID = $_GET["ID"];
						$sql = "SELECT Nome,Username,avatar_image FROM $utenti WHERE ID = $ID";
						$result = mysqli_query($conn, $sql);
						$row = mysqli_fetch_array($result);
						echo "<img id=\"avatar\" src=\"avatar_img/".$row["avatar_image"]."\" width=\"170\" height=\"170\" alt=\"avatar\">"; 
					?>
				</div>
				<div class="profilename_box">
				<?php
					echo "<h1 id=\"profiles_username\">".$row["Username"]."</h1>";
					echo "<p id=\"profiles_name\">".$row["Nome"].", Italy</p>";
				?>
				</div>
			</div>

			<div id="profilecontainer_right">
				<div class="profilecontent_right">
					<span>Statistiche</span><br>
					<div id="profilestatistics">
						
					</div>
				</div>
				<div id="profilestable_right">
					<span>Ricerca per titolo:</span>
					<input type="text" id="myInput" onkeyup="myFunction()" placeholder="Inserisci qui il titolo..." title="Type in a name">
					<div id="right_table">
						<?php 
							$ID = $_GET["ID"];
							$sql = "WITH cte AS ( SELECT v.Cod, v.voto FROM $utenti u JOIN $votare v ON v.ID = u.ID WHERE u.ID = $ID ) SELECT a.titolo, a.Cod, cte.voto, a.img_name FROM $anime a LEFT JOIN cte ON cte.Cod = a.Cod ORDER BY cte.voto DESC";
							$result = mysqli_query($conn, $sql);
							$row = mysqli_fetch_array($result);
							$first = true;
							
							echo "<table id=\"myTable\">";
							echo "<tr>";
								echo "<th> </th>";
								echo "<th style=\"min-width: 200px;\"> Titolo </th>";
								echo "<th> Voto </th>";
							echo "</tr>";
							do {
								if($first) {
									echo "<tr> \n";
									echo "<td> <div class=\"profileanime_img\"> <img src=\"img/" .$row["img_name"] . "\"width=\"70\" height=\"70\"></div> </td> \n";
									echo "<td> <font color=\"red\">" . $row["titolo"] . "</font> </td> \n";
									echo "<form action=\"processes/vote.php\" id=\"edit_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <input class=\"profiletext_vote\" name=\"vote\" required type=\"text\" form=\"edit_form".$row["Cod"]."\" placeholder=\"".$row["voto"]."...\"</td> \n";
									echo "</tr> \n"; 
									$first = false;
								}
								else {
									echo "<tr> \n";
									echo "<td> <div class=\"profileanime_img\"> <img src=\"img/" .$row["img_name"] . "\"width=\"70\" height=\"70\"></div> </td> \n";
									echo "<td>" . $row["titolo"] . "</td> \n";
									echo "<form action=\"processes/vote.php\" id=\"edit_form".$row["Cod"]."\" method=\"post\" enctype=\"multipart/form-data\" autocomplete=\"off\"></form>";
									echo "<td> <input required class=\"profiletext_vote\" name=\"vote\" type=\"text\" form=\"edit_form".$row["Cod"]."\" placeholder=\"".$row["voto"]."...\"</td> \n";
									echo "</tr> \n";
								}
							} while($row = mysqli_fetch_array($result));
						?>
					<div id="right_table">
				</div>
			</div>
		</div>
		<!--footer
		<div class="inv_inf_separator"></div>
		<footer id="footer">
			<div id="topfooter">
				<div id="topfooter_container">
					<div class="topfooter_content_wrap">
						<div class="topfooter_content_container">
							<div class="topfooter_title_content">
								<span style="font-size: 20px; color: #888;" id="topfooter_title">
									Utenti
								</span>
							</div>
							<div class="topfooter_content">
								<?php 
									$sql="SELECT Nome, avatar_image,Status FROM utenti WHERE Staff=0";
									$query = mysqli_query($conn, $sql);
									$result = mysqli_fetch_array($query);
									if($result!=null) {
										do{
											$status = $result["Status"];
											echo 
											"<div class=\"topfooter_content_users\">
												<div class=\"topfooter_content_avatarimg\">
													<div class=\"topfooter_avatarimg\">
														<img id=\"avatar\" src=\"avatar_img/".$result["avatar_image"]."\" width=\"40\" height=\"40\">
													</div>
												</div>
												<div class=\"topfooter_user\">
													<span style=\"font-size: 15;\">
														".$result["Nome"]."
													</span>
												</div>
											</div>";
										}while($result = mysqli_fetch_array($query));
									}
								?>
							</div>
						</div>
					</div>

					<div class="topfooter_content_wrap">
						<div class="topfooter_content_container">
							<div class="topfooter_title_content">
								<span style="font-size: 20px; color: #888;" id="topfooter_title">
									Staff
								</span>
							</div>
							<div class="topfooter_content">
								<?php 
									$sql="SELECT Nome, avatar_image,Status FROM utenti WHERE Staff=1";
									$query = mysqli_query($conn, $sql);
									$result = mysqli_fetch_array($query);
									if($result!=null) {
										do{
											$status = $result["Status"];
											echo 
											"<div class=\"topfooter_content_users\">
												<div class=\"topfooter_content_avatarimg\">
													<div class=\"topfooter_avatarimg\">
														<img id=\"avatar\" src=\"avatar_img/".$result["avatar_image"]."\" width=\"40\" height=\"40\">
													</div>
												</div>
												<div class=\"topfooter_user\">
													<span style=\"font-size: 15;\">
														".$result["Nome"]."
													</span>
												</div>
											</div>";
										}while($result = mysqli_fetch_array($query));
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="downfooter">
				<div id="downfooter_followus_wrap">
					<div id="downfooter_followus_container">
						<div id="downfooter_followus">
							<span id="downfooter_followus_text">Seguici su</span>
						</div>
						<div id="downfooter_followus_socialbutton">
							<a href="https://instagram.com">						
								<div class="socialbutton">
									<img src="img/instagramlogo.png" width="30" height="30">
								</div>
							</a>
							<a href="https://www.youtube.com/">
								<div class="socialbutton">
									<img src="img/youtubelogo.png" width="30" height="30">
								</div>
							</a>
							<a href="https://discord.gg/3ZGdWN2z7u">
								<div class="socialbutton">
									<img src="img/discordlogo.png" width="30" height="30">
								</div>
							</a>
						</div>
					</div>
				</div>
				<div id="downfooter_line"></div>
				<div class="container_copyright">
					<span id="copyright_terms">
						Copyright © 2021 OxFamily. All rights reserved. <br>
						<span style="font-size: 12px;">
							OxFamily.altervista.org is property of OxFamily. All files on this site are property of OxFamily.
						</span>
					</span>
				</div>
			</div>
		</footer>-->
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

	</script>
</html>