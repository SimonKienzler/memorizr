<?php 

	class Renderer {
	
		public static function error($heading, $logMessage) {
			return "<p><span class='error'>" . $heading . "</span></p><p>" . $logMessage . "</p>";
		}
	
	}