<?php 

	class Renderer {
	
		public static function error($heading, $logMessage) {
			return "<p><span class='error'>" . $heading . "</span><br />" . $logMessage . "</p>";
		}
		
		public static function info($heading, $logMessage) {
			return "<p><span class='info'>" . $heading . "</span><br />" . $logMessage . "</p>";
		}
	
	}