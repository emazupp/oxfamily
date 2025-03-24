<?php
	session_start();
	if(isset($_SESSION["ID"])) {
		if($_SESSION["ID"] != null){
			header("Location: index.php");
		}
	}
?>

<html>
	<head>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Pushster&display=swap" rel="stylesheet">
		<link rel="stylesheet" href="login.css">
		<link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
		<title> Login </title>
	</head>
	
	<body>
		<center>
			<form method="post" action="/processes/loginprocess.php">
				<div id="container_form">	
					<p id="oxfamily" style="font-family: 'Pushster', cursive; font-size: 25px; float: left; margin: 0; padding-left: 15px; padding-bottom: 5px;">oxfamily</p>
					<div id="form">
						
						<img id="avatar_img" src="avatar_img/avatar_login.png" width="100" height="100" alt="avatar"> <br>
						<div id="error_message">
							<?php
								if(isset($_GET["error_login"])) {
									echo "<p style=\"color: red; margin: 0;\"> Username o password non corretti. Riprova.</p>";
								}
							?>
						</div>
						
						<input type="text" name="username" required placeholder="username" id="username_login"> <br> <br>
						<input type="password" name="password" required placeholder="password" id="password_login"> <br> <br>
						<input type="submit" name="login" value="Login" id="btn_login"> <br>
						<p id="bottom_text" style="">Not a member? You might don't deserve it.</p>
						<div id="svg_circle">
							<svg id="dark-light" viewBox="0 0 24 24" stroke="grey" stroke-width="1" fill="transparent" stroke-linecap="round" stroke-linejoin="round" width="30px" heigth="30px">
     							<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
     						</svg>
						</div>
					</div>
				</div>
			</form>
		</center>
	</body>

	<script>
		//darkMode
		let darkMode = localStorage.getItem('darkMode');
		const darkModeToggle = document.querySelector('#svg_circle') 

		function enableDarkMode() {
			document.body.style.setProperty("background", "#121619");
			document.getElementById("oxfamily").style.setProperty("color","#fff");
			document.getElementById("form").style.setProperty("background-color", "#1c2125");
			document.getElementById("bottom_text").style.setProperty("color", "#fff");
			document.getElementById("svg_circle").style.setProperty("background-color", "#323a4b");
			document.getElementById("dark-light").style.fill="#ffce45";
			document.getElementById("username_login").style.setProperty("color", "#fff");
			document.getElementById("password_login").style.setProperty("color", "#fff");
			localStorage.setItem('darkMode', 'enabled');
		}

		function disableDarkMode() {
			document.body.style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.getElementById("oxfamily").style.setProperty("color", "#000");
			document.getElementById("form").style.setProperty("background-color", "#fff");
			document.getElementById("bottom_text").style.setProperty("color", "#000");
			document.getElementById("svg_circle").style.setProperty("background-color", "#fafafa");
			document.getElementById("dark-light").style.fill="transparent";
			document.getElementById("username_login").style.setProperty("color", "#000");
			document.getElementById("password_login").style.setProperty("color", "#000");
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
