 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo "Memorizr | Memory Music Player"; ?></title>
    <link rel="stylesheet" href="./memorizr/gui/main.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  </head>
  <body>
	<?php 
		require("/../app.php");
		require_once("renderer.php");
	
		$memorizr = new Memorizr();
		
		if(isset($_GET['page'])) {
			$page = $_GET['page'];
		} else {
			$page = "index";
		}
		
		echo Renderer::top();	
		echo "<div id='main'>";
		echo Renderer::navigation();
		echo "<div id='memo-output'>";
		$memorizr->run($page);
		echo "</div>";
		echo Renderer::player();
		echo "</div>";
		
		
	?>
		<!-- includes audio.js -->
		<script src="./audiojs/audio.min.js"></script>
		
		<!-- initializes audio.js -->
		<script>
		  audiojs.events.ready(function() {
			var as = audiojs.createAll();
		  });
		</script>	
		
		<!-- realizes on the fly search functionality -->
		<script>
			function showResult(str) {
				if (str.length==0) {
					document.getElementById("results").innerHTML="";
					return;
				}
				
				// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
				
				xmlhttp.onreadystatechange=function() {
					if (this.readyState==4 && this.status==200) {
						document.getElementById("results").innerHTML=this.responseText;
					}
				}
				xmlhttp.open("GET","./memorizr/api.php?query-string="+str,true);
				xmlhttp.send();
			}
		</script>
		
		<!-- sets song id for song to be played -->
		<script>
			function playSong(id) {
				document.getElementById("player-audio").setAttribute("src","songs/" + id + ".mp3");
			}
		</script>
  </body>
</html>
