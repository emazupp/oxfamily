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
		<div id="svg_circle">
			<svg id="dark-light" viewBox="0 0 24 24" stroke="grey" stroke-width="1" fill="transparent" stroke-linecap="round" stroke-linejoin="round" width="30px" heigth="30px">
				<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
			</svg>
		</div>
		<nav class="navbar" id="nav">
			<div class="logo">
				<img src="img/logo.png" width="72" height="45" alt="">
			</div>
			<div class="nav_container">
				<div class="nav_elements">
					<li><a class="elements" href="index.php">Anime</a></li>
					<li> <a class="elements" href="serietv.php"> Serie TV </a> </li>
					<li> <a class="elements" href="manga.php"> Manga </a> </li>
					<li class="active"> <a class="elements" href="new.php"> New anime </a> </li>
					<li> <a class="elements" href="newtv.php"> New serie </a> </li>
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
						else {
							echo "<a href=\"login.php\"> Login </a>";
						}
					?>
				</span>
			</div>
		</nav>
		<div class="inv_sup_separator"></div>
		<div id="main_form_wrap">
			<div id="line"> </div>
			<div id="container_form_wrap">
				<form id="create_form_body"action="processes/upload.php" method="post" enctype="multipart/form-data">
					<h1 class="h1_newanime"> Aggiungi nuovo anime</h1>
					<div id="field_separator">
						<label id="form_field_label"> Titolo </label>
						<input name="title" class="textbox_new" type="txt" required autocomplete="off" > </input>
					</div>
					<div id="field_separator">
						<label id="form_field_label"> Codice Trailer </label> 
						<input name="trailer" class="textbox_new" type="txt" required autocomplete="off"> </input>
					</div>
					<div id="field_separator">
						<label id="form_field_label"> Copertina: </label> 
							<div id="upload_dropzone">
								<span id="upload_dropzone_span" class="upload_dropzone_span_class"> Aggiungi copertina... </span>
								<input type="file" name="image" id="field_file" class="field_file_class" onchange="fileUploaded(1);"> </input>
								<label id="file_name_tag" class="file_name_tag_class"> Nome file</label>
							</div>
					</div>
					<div id="field_separator">
						<input type="submit" class="button-create" value="Aggiungi"> </input>
					</div>
					<div id="field_separator">
						<?php 
							if(isset($_GET["success_file_uploaded"]))
								echo "<span class=\"success_file_uploaded\">Anime caricato con successo. </span>"; 
							if(isset($_GET["error_sql"]))
								echo "<span class=\"error_sql_upload\">Errore: qualcosa e' andato storto. </span>";
							if(isset($_GET["error_file_not_image"]))
								echo "<span class=\"error_sql_upload\">Errore: Il file caricato non e' un immagine. </span>"; 
							if(isset($_GET["error_file_exists"]))
								echo "<span class=\"error_sql_upload\">Errore: Questo nome dell'immagine esiste gia'. Prova a cambiare nome. </span>"; 
						?>
					</div>
				</form>
				<div class="vertical_line"> 
				</div>
				<form id="edit_form_body" action="processes/edit.php" method="post" enctype="multipart/form-data">
					<h1 class="h1_newanime"> Modifica anime</h1>
					<div id="field_separator">
					<label id="form_field_label"> Titolo </label>
					   <select class="select_new" name="title" onchange='location = "new.php?selected_title="+this.value;'>
									<option selected disabled value="empty"> Seleziona </option>
									<?php
										$sql = "SELECT Titolo,trailer,img_name FROM $anime ORDER BY Titolo";
										$query = mysqli_query($conn, $sql);
										$result = mysqli_fetch_array($query);
										$title = "";
										$trailer = "";
										do {
											if(isset($_GET["selected_title"]) && $_GET["selected_title"] == $result["Titolo"]) {
												echo "<option value=\"".$result["Titolo"]."\" selected>".$result["Titolo"]."</option>";
												$title = $result["Titolo"];
												$trailer = $result["trailer"];
												$image = $result["img_name"];
											}
											else
												echo "<option value=\"".$result["Titolo"]."\">".$result["Titolo"]."</option>";
										} while($result = mysqli_fetch_array($query));
									?>
						</select>
					</div>
					<div id="field_separator">
						<label id="form_field_label"> Nuovo titolo: </label>
						<input name="newtitle" class="textbox_new" type="txt" autocomplete="off" value="<?php echo $title;?>"></input>
					</div>
					<div id="field_separator">
						<label id="form_field_label"> Nuovo codice trailer: </label>
						<input name="trailer" class="textbox_new" type="txt" autocomplete="off" value="<?php echo $trailer;?>"> </input>
					</div>
					<div id="field_separator">					
						<label id="form_field_label"> Nuova copertina </label>
							<div id="upload_dropzone">
								<span id="upload_dropzone_span" class="upload_dropzone_span_class"> Aggiungi copertina... </span>
								<input type="file" name="image" id="field_file" class="field_file_class" onchange="fileUploaded(2);"> </input>
								<label id="file_name_tag" class="file_name_tag_class"> Nome file</label>
							</div>						
					</div>	
					<div id="field_separator">					
						<input type="submit" class="button-edit" value="Applica modifiche"> </input>
					</div>
					<div id="field_separator">
						<?php 
							if(isset($_GET["success_file_edited"]))
								echo "<span class=\"success_file_uploaded\">Modifiche applicate. </span>"; 
							if(isset($_GET["error_sql_edit"]))
								echo "<span class=\"error_sql_upload\">Errore: qualcosa e' andato storto. </span>";
							if(isset($_GET["error_file_not_image"]))
								echo "<span class=\"error_sql_upload\">Errore: Il file caricato non e' un immagine. </span>"; 
							if(isset($_GET["error_file_exists_edit"]))
								echo "<span class=\"error_sql_upload\">Errore: Questo nome dell'immagine esiste gia'. Prova a cambiare nome. </span>"; 
						?>
					</div>
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
		
		function fileUploaded(form) {	
			var form_id = "";
			if(form==1)
				form_id = "create_form_body";
			else
				form_id = "edit_form_body";
			var fullPath = document.getElementById(form_id).getElementsByClassName("field_file_class")[0].value;
			if (fullPath) {
				var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
				var filename = fullPath.substring(startIndex);
				if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
					filename = filename.substring(1);
				}
				document.getElementById(form_id).getElementsByClassName("upload_dropzone_span_class")[0].style.display = "none";
				document.getElementById(form_id).getElementsByClassName("file_name_tag_class")[0].style.display = "block";
				document.getElementById(form_id).getElementsByClassName("file_name_tag_class")[0].textContent = filename;
			}
		}
		
		//darkMode
		let darkMode = localStorage.getItem('darkMode');
		const darkModeToggle = document.querySelector('#svg_circle') 

		function enableDarkMode() {
			document.getElementById("nav").style.setProperty("background", "#1c2125");
			document.body.style.setProperty("background", "#121619");
			document.getElementById("container_form_wrap").style.setProperty("background-color", "#1c2125");
			document.getElementById("container_form_wrap").style.setProperty("color", "white");
			//document.getElementById("topfooter").style.setProperty("background", "#1c2125");
			//document.getElementById("topfooter").style.setProperty("color", "#d1d1d1");
			//document.getElementById("downfooter").style.setProperty("background", "linear-gradient(to top, rgba(28, 33, 37, 1) 50%, rgba(18, 22, 25, 1) 100%)");*/
			document.getElementsByClassName("h1_newanime")[0].style.setProperty("color", "#ddd")
			document.getElementsByClassName("h1_newanime")[1].style.setProperty("color", "#ddd")
			document.getElementsByClassName("select_new")[0].style.setProperty("background-color", "#1c2125")
			document.getElementsByClassName("select_new")[0].style.setProperty("color", "white")
			for(var i = 0; i<document.getElementsByClassName("textbox_new").length; i++) {
				document.getElementsByClassName("textbox_new")[i].style.setProperty("background", "#1c2125");
				document.getElementsByClassName("textbox_new")[i].style.setProperty("color", "white");
			}				
			for(var i = 0; i<document.getElementsByClassName("modal-content").length; i++){
				document.getElementsByClassName("modal-content")[i].style.setProperty("background-color", "#121619");
				document.getElementsByClassName("modal-content")[i].style.setProperty("color", "#d1d1d1");
			}
			document.getElementById("svg_circle").style.setProperty("background-color", "#323a4b");
			document.getElementById("dark-light").style.fill="#ffce45";
			localStorage.setItem('darkMode', 'enabled');
		}

		function disableDarkMode() {
			document.getElementById("nav").style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.body.style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.getElementById("container_form_wrap").style.setProperty("background-color", "#fff");
			/*document.getElementById("topfooter").style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.getElementById("topfooter").style.setProperty("color", "#000");*/
			//document.getElementById("downfooter").style.setProperty("background", "linear-gradient(180deg, rgba(82, 173, 230, 0.5), rgba(82, 173, 230, 1))");
			for(var i = 0; i<document.getElementsByClassName("modal-content").length; i++){
				document.getElementsByClassName("modal-content")[i].style.setProperty("background-color", "#fefefe");
				document.getElementsByClassName("modal-content")[i].style.setProperty("color", "#000");
			}
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