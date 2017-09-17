<?php

	require_once("db/mapper.php");
	require_once("obj/song.php");
	require_once("filer/filer.php");
	require_once("gui/renderer.php");
	
	class Memorizr {
		
		function run() {
			if(!Mapper::createConnection()) {
				die("Database Connection could not be established.");
			}
			
			$files = Filer::generateFileList();
			
			foreach($files as $file) {
				echo $file;
				$cleanSong = Filer::createSongFromDirtyFile($file);
				echo Renderer::info("Song indexed",
										"Title: " . $cleanSong->getValueFor("title") . 
										", Artist: " . $cleanSong->getValueFor("artist") . 
										", ID: " . $cleanSong->getValueFor("id"));
				Filer::saveSongToFile($cleanSong,$file);
				//Mapper::saveSong($cleanSong);
			}

			
			
		}
		
	}