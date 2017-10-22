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
			return "<div id='player'><audio src='songs/02a13a6b3d317dae5a7cb2b514e0ee066bac77db.mp3' preload='auto' id='player-audio'/></div>";
		}
		
		public static function pageHeader($pageHeader) {
			return "<h2>" . $pageHeader . "</h2>";
		}
		
		public static function searchForm($method,$action) {
			return "<div class='form'><form method='" . $method . "' action='" . $action . "'>" .
					"<input type='text' class='search' placeholder='Suche nach...' onkeyup='showResult(this.value)' />" .
					"</form></div>";
		}
		
		public static function searchResult($song) {
			require_once(__DIR__ . "./../obj/song.php");
			return "<div class='search-result'>" . 
						"<div class='song-info'>" .
							"<h3>" . $song->getValueFor("title") . "</h3>" .
							"<p>" .
								"<span class='artist'><span class='fa fa-user'></span> " . $song->getValueFor("artist") . "</span> " .
								"<span class='album'><span class='fa fa-music'></span> " . $song->getValueFor("album") . 
								", " . $song->getValueFor("year") . "</span> " .
								"<span class='genre'><span class='fa fa-tag'></span> " . id3_get_genre_name($song->getValueFor("genre")) . "</span>" .
							"</p>" .
						"</div>" .
						"<button onclick='playSong(\"" . $song->getValueFor("id") . "\")'><span class='fa fa-play-circle'></span></button>" .
					"</div>";
		}
	
	}