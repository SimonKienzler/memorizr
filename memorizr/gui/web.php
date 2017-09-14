 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo "Memorizr | Memory Music Player"; ?></title>
  <link rel="stylesheet" href="./memorizr/gui/main.css" type="text/css">
  </head>
  <body>
	<?php 
		require("/../app.php");
	
		$memorizr = new Memorizr();
		
		$memorizr::run();
	?>
  </body>
</html>
