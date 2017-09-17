<?php

	require_once("db/mapper.php");
	require_once("obj/song.php");
	require_once("filer/filer.php");
	require_once("gui/renderer.php");
	
	class Memorizr {
		
		public function run($page) {
			if(!Mapper::createConnection()) {
				die("Database Connection could not be established.");
			}
			
			if($page == "index") {
				$this->index();
			} else if($page == "import") {
				$this->import();
			} else {
				die(Renderer::error("Fatal: Page could not be found","The URL you tried to reach is not a known URL for this application."));
			}			
			
		}
		
		public function index() {
			echo Renderer::info("Under construction","The index page of this app has not yet been created.");
		}
		
		public function import() {
			$files = Filer::generateDirtyFileList();
			
			foreach($files as $file) {
				$cleanSong = Filer::createSongFromDirtyFile($file);
				if(!Mapper::songIdExists($cleanSong->getValueFor("id"))) {
					echo Renderer::info("Song indexed",
										"Title: " . $cleanSong->getValueFor("title") . 
										", Artist: " . $cleanSong->getValueFor("artist") . 
										", ID: " . $cleanSong->getValueFor("id"));
					Filer::saveSongToFile($cleanSong,$file);
					Mapper::saveSong($cleanSong);
				} else {
					echo Renderer::info("Song already exists",
										"The song <strong>" . $cleanSong->getValueFor("title") .
										"</strong> by <strong>" . $cleanSong->getValueFor("artist") .
										"</strong> already exists in the Memorizr Database and will be skipped.");
				}	
			}
		}
	}