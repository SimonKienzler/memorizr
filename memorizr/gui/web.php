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
  </body>
</html>
