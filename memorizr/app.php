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
			echo Renderer::pageHeader("Stöbere durch Deine Musik");
			echo Renderer::searchForm("post","?page=index");
			echo "<div id='results'></div>";
		}
		
		public function import() {
			$files = Filer::generateDirtyFileList();
			
			$numOfFiles = count($files);
			
			if(!isset($_GET['import'])) {
				echo Renderer::info("We found " . $numOfFiles . " Songs to import.","Here's a list of them for you to review." .
									" You can start the import by clicking the button on the bottom of this page.");
				$i = 1;
				foreach($files as $file) {
					echo "<p><strong>" . $i++ . ")</strong> " . $file . "</p>";					
				}
				echo Renderer::info("", "<a href='./?page=import&import=true'>Start import now</a>");
				return;
			}
			
			$i = 1;
			
			foreach($files as $file) {
				$cleanSong = Filer::createSongFromDirtyFile($file);
				if(!Mapper::songIdExists($cleanSong->getValueFor("id"))) {
					Filer::saveSongToFile($cleanSong,$file);
					Mapper::saveSong($cleanSong);
					echo Renderer::info("(" . $i++ . "/" . $numOfFiles . ") Song indexed",
										"Title: " . $cleanSong->getValueFor("title") . 
										", Artist: " . $cleanSong->getValueFor("artist"));
				} else {
					echo Renderer::info("(" . $i++ . "/" . $numOfFiles . ") Song already exists",
										"The song <strong>" . $cleanSong->getValueFor("title") .
										"</strong> by <strong>" . $cleanSong->getValueFor("artist") .
										"</strong> already exists in the Memorizr Database and will be skipped.");
				}	
			}
		}
	}