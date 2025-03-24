<html>
<?php 
	include "config.php";
    session_start();		
?>
	<head>
		<link href="style.css" rel="stylesheet">
		<meta name="viewport" content="width=device-width">
		<link rel="shortcut icon" type="image/jpg" href="favicon.jpg">
		<title>OxFamily</title>
	</head>
	<body>
		<!-- <button id="loadbasic"> filtra </button> -->
		<div id="svg_circle">
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
					<li> <a class="elements" href="index.php"> Anime</a></li>
					<li class="active"> <a class="elements" href="serietv.php"> Serie TV </a> </li>
					<li> <a class="elements" href="manga.php"> Manga </a> </li>
					<li> <a class="elements" href="new.php"> New anime </a> </li>
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
		<div id="main_wrap">
			<div id="line"> </div>
 			<div id="container_wrap">
			<?php
				function getVotes($result, $utenti, $votaretv, $serietv, $conn) {
					$lista_finale = "";
					$sql2 = "WITH cte AS ( SELECT v.* FROM $serietv f JOIN $votaretv v ON v.Cod = f.Cod WHERE f.Titolo = '".$result["Titolo"]."') SELECT * FROM $utenti u LEFT JOIN cte ON cte.Id = u.Id ORDER BY voto DESC";
					/*$sql2 = "SELECT * FROM $utenti LEFT OUTER JOIN $votaretv ON $utenti.ID = $votaretv.ID
												  LEFT OUTER JOIN $serietv ON votare.Cod = $serietv.Cod
							WHERE Titolo = '".$result["Titolo"]."'";*/
					$query_votes = mysqli_query($conn, $sql2);
					$votes_result = mysqli_fetch_array($query_votes);
					do {
						$voto = $votes_result["Voto"];
						if($voto == NULL || $voto=="")
							$voto = "N/A";
						$lista_finale = "<p> ".$lista_finale.$votes_result["Nome"].": ".$voto."</p>";
					} while($votes_result = mysqli_fetch_array($query_votes));
					return $lista_finale;
				}
			
				$sql = "SELECT ROUND(AVG(Voto),2) AS Media ,Titolo,img_name, $serietv.Cod, trailer FROM $utenti INNER JOIN $votaretv ON $utenti.ID = $votaretv.ID
						RIGHT OUTER JOIN $serietv ON $votaretv.Cod = $serietv.Cod
						GROUP BY Titolo ORDER BY Media DESC";
				$query = mysqli_query($conn, $sql);
				$result = mysqli_fetch_array($query);
				if($result != null) {
					$i = 0;
					echo "<div id=\"container\">";
					do {
						if($i % 4 == 0 && $i!=0) {
							echo "</div>";
							echo "<div id=\"container\">";
						}
						$i++;
						$voto_medio = $result["Media"];
						if($voto_medio == NULL)
							$voto_medio = 0;
						echo "<div class=\"card_padding_rightleft\">
							<div id=\"card_title\">
								<span id=\"card_title_text\">".$result["Titolo"]."</span>
							</div>
						<div class=\"card\">
						  <div class=\"overlay\">
							<div id=\"vote_text\">Voto medio: ".$voto_medio."</div>
						  </div>
							<img onclick= \"openmodal(".$result["Cod"].")\" id=\"".$result["Titolo"]."\"class=\"imgcard\" src=\"imgtv/".$result["img_name"]."\">

							<div id=\"".$result["Cod"]."\" class=\"modal\">
							  <div class=\"modal-content\">
							    <span onclick=\"chiudi(".$result["Cod"].")\" class=\"close\">&times;</span>
								<div id=\"votes_list\">
							    <h2>".$result["Titolo"]."</h2>".
								getVotes($result, $utenti, $votaretv, $serietv, $conn)
								."</div>
								  <div class=\"youtube\" data-embed=\"".$result["trailer"]."\" id=\"".$result["Cod"]."\">
									<div class=\"play-button\"></div>
								  </div>
							  </div>
							</div>
						</div>
					</div>";
					}
					while($result = mysqli_fetch_array($query));
					echo "</div>";
				}
			?>

			</div>
			<div id="myID" class="bottomlogo hide"> 
				<img src="img/logo.png" width="96" height="60" alt=""> 
			</div>
			<div class="infobottomlogo">
				<span id="spaninfobuttonlogo">Torna su</span>
			</div>
		</div>
		
		<!--footer-->
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
									$sql="SELECT ID, Nome, avatar_image,Status FROM utenti WHERE Staff=0";
									$query = mysqli_query($conn, $sql);
									$result = mysqli_fetch_array($query);
									if($result!=null) {
										do{
											$status = $result["Status"];
											echo 
											"<div class=\"topfooter_content_users\">
												<div class=\"topfooter_content_avatarimg\">
													<div class=\"topfooter_avatarimg\">
														<img onClick=openProfiles(".$result["ID"]."); id=\"avatar\" src=\"avatar_img/".$result["avatar_image"]."\" width=\"40\" height=\"40\">
													</div>
												</div>
												<div class=\"topfooter_user\">
													<span class=\"users\" style=\"font-size: 15;\">
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
									$sql="SELECT ID, Nome, avatar_image,Status FROM utenti WHERE Staff=1";
									$query = mysqli_query($conn, $sql);
									$result = mysqli_fetch_array($query);
									if($result!=null) {
										do{
											$status = $result["Status"];
											echo 
											"<div class=\"topfooter_content_users\">
												<div class=\"topfooter_content_avatarimg\">
													<div class=\"topfooter_avatarimg\">
														<img onClick=openProfiles(".$result["ID"]."); id=\"avatar\" src=\"avatar_img/".$result["avatar_image"]."\" width=\"40\" height=\"40\">
													</div>
												</div>
												<div class=\"topfooter_user\">
													<span class=\"users\" style=\"font-size: 15; \">
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
						Copyright © 2022 OxFamily. All rights reserved. <br>
						<span style="font-size: 12px;">
							OxFamily.altervista.org is property of OxFamily. All files on this site are property of OxFamily.
						</span>
					</span>
				</div>
			</div>
		</footer>
	</body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script>
	( function() {

		  var youtube = document.querySelectorAll( ".youtube" );
		  
		  for (var i = 0; i < youtube.length; i++) {
			
			var source = "https://img.youtube.com/vi/"+ youtube[i].dataset.embed +"/sddefault.jpg";
			
			var image = new Image();
				image.src = source;
				image.addEventListener( "load", function() {
				  youtube[ i ].appendChild( image );
				}( i ) );
			
				youtube[i].addEventListener( "click", function() {

				  var iframe = document.createElement( "iframe" );
					  iframe.setAttribute( "frameborder", "0" );
					  iframe.setAttribute( "allowfullscreen", "" );
					  iframe.setAttribute( "src", "https://www.youtube.com/embed/"+ this.dataset.embed +"?rel=0&showinfo=0&autoplay=1&enablejsapi=1&version=3&playerapiid=ytplayer" );
					  iframe.setAttribute("class", "youtube-video"+this.getAttribute("id"));
					  this.innerHTML = "";
					  this.appendChild( iframe );
				} );  
		  };
} )();


		function openProfiles(id) {
			window.location.href="profiles.php?ID="+id;
		}
		
		function openProfile(type) {
			window.location.href="profile.php";
		}
		var openedmodal = "";
		function openmodal(id) {
			var modal = document.getElementById(""+id);
			modal.style.display = "block";
			openedmodal = id;
		}
		window.onclick = function(event) {
			var modal = document.getElementById(openedmodal);
			if (event.target == modal) {
				modal.style.display = "none";
				$(".youtube-video"+openedmodal)[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
			}
		}
		function chiudi(id){
			var modal = document.getElementById(""+id);
			var span = document.getElementsByClassName("close")[0];
			modal.style.display = "none";
			$(".youtube-video"+id)[0].contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
		}

		var myID = document.getElementById("myID");
		var ScrollFunc = function() {
		  var y = window.scrollY;
		  if (y >= 150) {
		    myID.className = "bottomlogo show";
		  } else {
		    myID.className = "bottomlogo hide";
		  }
		};

		window.addEventListener("scroll", ScrollFunc);

        $(document).ready(function (){
            $("#myID").click(function (){
                $('html, body').animate({
                    scrollTop: $("#nav").offset().top
                }, 1000);
            });
        });

		//darkMode
		let darkMode = localStorage.getItem('darkMode');
		const darkModeToggle = document.querySelector('#svg_circle') 

		function enableDarkMode() {
			document.getElementById("nav").style.setProperty("background", "#1c2125");
			document.body.style.setProperty("background", "#121619");
			document.getElementById("container_wrap").style.setProperty("background-color", "#1c2125");
			document.getElementById("topfooter").style.setProperty("background", "#1c2125");
			document.getElementById("topfooter").style.setProperty("color", "#d1d1d1");
			document.getElementById("downfooter").style.setProperty("background", "linear-gradient(to top, rgba(28, 33, 37, 1) 50%, rgba(18, 22, 25, 1) 100%)");
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
			document.getElementById("container_wrap").style.setProperty("background-color", "#fff");
			document.getElementById("topfooter").style.setProperty("background", "linear-gradient(-90deg, #fff, #eee)");
			document.getElementById("topfooter").style.setProperty("color", "#000");
			document.getElementById("downfooter").style.setProperty("background", "linear-gradient(180deg, rgba(82, 173, 230, 0.5), rgba(82, 173, 230, 1))");
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

		/*function setDarkMode() {
			document.cookie = "darkmode=true; path=/\";";
			darkMode();
		}
		function darkMode() {
			$("body").css("background", "linear-gradient(-90deg, #121619, #121619)");
			document.getElementsByClassName("navbar")[0].style.setProperty("background", "linear-gradient(-90deg, #1c2125, #1c2125)");
			document.getElementById("topfooter").style.setProperty("background", "linear-gradient(-90deg, #1c2125, #1c2125)");
			document.getElementById("container_wrap").style.setProperty("background", "linear-gradient(-90deg, #1c2125, #1c2125)");
			document.getElementById("downfooter").style.setProperty("background", "linear-gradient(-90deg, #121619, #121619)");
			var elements = document.getElementsByClassName("users");
			for(var i = 0; i < elements.length; i++) {
				elements[i].style.setProperty("color", "white");
			}
		}*/
		
		var url = "orderByMedia.php";
		$("#loadbasic").click(function() {
			$("html").html("<img src='http://i.imgur.com/pKopwXp.gif' alt='loading...' />").load(url);
		  });
		<?php
			if(isset($_SESSION["ID"])) {
				echo "		jQuery(document).ready(function() {
							  countDown();
							  $('body')
									  .change(function() {//reset the counter if change any value in 
														  //the page http://api.jquery.com/change/
								resetCounter();
							  })
									  .mousemove(function() {//reset the counter if the mouse is moved inside the body element
															 //http://api.jquery.com/mousemove/
								resetCounter()
							  })
									  .click(function() {//reset the counter if the click inside the body element
														 //http://api.jquery.com/click/
								resetCounter()
							  });
							  $(window).scroll(function() {//reset the counter if make scroll
														  //http://api.jquery.com/scroll/
								resetCounter()
							  });
							});
							var seconds = 300; //set the var seconds to the time you want start to check
							function countDown() {
							  if (seconds <= 0) {//when the time over execute
								window.location = \"processes/logout.php\";
							  }
							  seconds--;//run every second to decrees a second
							  window.setTimeout(\"countDown()\", 1000);

							}
							function resetCounter() {//reset counter
							  seconds = 300;
		}";
			}
	   ?>
	</script>
</html>