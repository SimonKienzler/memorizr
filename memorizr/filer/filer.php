<?php

	class Filer {
		
		public static function createSongFromDirtyFile($filepath) {
			require(__DIR__ . "./../config.php");
			require_once("/../getid3/getid3.php");

			$getID3 = new getID3;

			$info = $getID3->analyze(__DIR__ . "./../../" . $DIRTY_FILE_PATH . "/" . $filepath);
			
			$song = new Song();
			
			$song->setValueFor("id",Filer::createSHA1FromDirtyFile($filepath));
			$song->setValueFor("title",Filer::tagIfIsSet($info,"title"));
			$song->setValueFor("artist",Filer::tagIfIsSet($info,"artist"));
			$song->setValueFor("album",Filer::tagIfIsSet($info,"album"));
			$song->setValueFor("year",Filer::tagIfIsSet($info,"year"));
			$song->setValueFor("genre",Filer::tagIfIsSet($info,"genre"));
			$song->setValueFor("memory",null);
			
			return $song;
		}
		
		public static function createSHA1FromDirtyFile($filepath) {
			require(__DIR__ . "./../config.php");
			return sha1_file(__DIR__ . "./../../". $DIRTY_FILE_PATH . "/". $filepath,false);
		}
		
		public static function tagIfIsSet($infoArray,$tag) {
			if(isset($infoArray["tags"]["id3v2"][$tag][0])) {
				return $infoArray["tags"]["id3v2"][$tag][0];
			} else {
				return null;
			}
		}
		
		public static function saveSongToFile($song,$dirtySongFilepath) {
			require(__DIR__ . "./../config.php");
			$id = $song->getValueFor("id");
			copy(__DIR__ . "./../../" . $DIRTY_FILE_PATH . "/" . $dirtySongFilepath,
				 __DIR__ . "./../../" . $SONG_FILE_PATH . "/" . $id . ".mp3");
		}
		
		public static function generateDirtyFileList() {
			require(__DIR__ . "./../config.php");
			// excluding '.' and '..' from the returned array 
			$fileList= array_filter(scandir(__DIR__ . "./../../" . $DIRTY_FILE_PATH), function($item) {
				return $item[0] !== '.';
			});
			return $fileList;
		}
		
	}