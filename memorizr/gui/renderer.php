<?php 

	class Renderer {
	
		public static function error($heading, $logMessage) {
			return "<h2><span class='error'>" . $heading . "</span></h2><p>" . $logMessage . "</p>";
		}
		
		public static function info($heading, $logMessage) {
			return "<h2><span class='info'>" . $heading . "</span></h2><p>" . $logMessage . "</p>";
		}
		
		public static function top() {
			return "<div id='top'><h1>Mem<span class='fa fa-play-circle'></span>rizr</h1></div>";
		}
		
		public static function navigation() {
			$pages = array(
				"index" => array("index","Suche","search"),
				"import" => array("import","Importieren","upload"),
				"playlists" => array("playlists","Playlisten","bars"),
				"memory" => array("memory","Memorize me","star")
			);
			
			$navString ="<ul id='navi'>";
			
			foreach($pages as $page) {
				$navString = $navString . "<li><a href='?page=" . $page[0] . 
										"'><span class=' fa fa-" . $page[2] . 
										"'></span>" . $page[1] . "</a></li>";
			}
			
			return $navString . "</ul>";
		}
		
		public static function player() {
			return "<div id='player'></div>";
		}
	
	}