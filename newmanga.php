<html>
<?php 
	include "config.php";
	session_start();
	if(!isset($_SESSION["ID"])) {
		header("Location: /login.php");
		return;
	}
?>
	<head>
		<link href="style.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
		<title>OxFamily</title>
	</head>
	<body>
		<nav class="navbar">
			<div class="logo">
				<img src="img/logo.png" width="72" height="45" alt="">
			</div>
			<div class="nav_container">
				<div class="nav_elements">
					<li><a class="elements" href="index.php">Anime</a></li>
					<li> <a class="elements" href="serietv.php"> Serie TV </a> </li>
					<li> <a class="elements" href="manga.php"> Manga </a> </li>
					<li> <a class="elements" href="new.php"> New anime </a> </li>
					<li> <a class="elements" href="newtv.php"> New serie </a> </li>
					<li class="active"> <a class="elements" href="newmanga.php"> New manga</a> </li>
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
						else {
							echo "<a href=\"login.php\"> Login </a>";
						}
					?>
				</span>
			</div>
		</nav>
		<div class="inv_sup_separator"></div>
		<div id="main_wrap">
			<div id="line"> </div>
			<div id="container_wrap">
				<form action="processes/uploadmanga.php" method="post" enctype="multipart/form-data">
					<p> Aggiungi nuovo manga</p>
					Titolo: <input name="title" type="txt" required autocomplete="off"> </input>
					<br />
					<br />
					Sinossi: <br /> <br /> <textarea name="sinossi" rows="4" cols="50" required placeholder="Descrizione"></textarea>
					<br />
					<br />
					Copertina: <input type="file" name="image"> </input>
					<input type="submit"> </input>
					<br />
					<br />
				</form>
				<br />
				<form action="processes/edittv.php" method="post" enctype="multipart/form-data">
					<p> Modifica manga</p>
					Titolo:   <select name="title">
									<option selected disabled value="empty"> Seleziona </option>
									<?php
										$sql = "SELECT Titolo FROM $anime ORDER BY Titolo";
										$query = mysqli_query($conn, $sql);
										$result = mysqli_fetch_array($query);
										do {
											echo "<option value=\"".$result["Titolo"]."\">".$result["Titolo"]."</option>";
										} while($result = mysqli_fetch_array($query));
									?>
							  </select>
					<br />
					<br />
					Nuovo titolo: <input name="newtitle" type="txt" autocomplete="off"> </input>
					<br />
					<br />
					Nuova sinossi: <input name="trailer" type="txt" autocomplete="off"> </input>
					<br />
					<br />					
					Nuova copertina: <input type="file" name="image"> </input>
					<br>
					<br />					
					<input type="submit"> </input>
				</form>
				<br />
				<br />
			</div>
		</div>
		<div class="inv_inf_separator"></div>
	</body>
	<script>
		function openProfile() {
			window.location.href="profile.php";
		}

		
	</script>
</html>