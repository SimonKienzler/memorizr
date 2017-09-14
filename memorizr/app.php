<?php

	require("db/mapper.php");
	require("obj/song.php");
	require("filer/filer.php");
	
	class Memorizr {
		
		function run() {
			if(!Mapper::createConnection()) {
				die("Database Connection could not be established.");
			}

			$test = Filer::createSongFromDirtyFile("‪../../dirty/tmp2.mp3");
			
			Mapper::saveSong($test);
			
		}
		
	}