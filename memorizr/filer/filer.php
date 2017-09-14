<?php

	class Filer {
		
		public static function createSongFromDirtyFile($filepath) {
			
			require_once("/../getid3/getid3.php");

			$getID3 = new getID3;

			$info = $getID3->analyze($filepath);
			
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
			return sha1_file($filepath,false);
		}
		
		public static function tagIfIsSet($infoArray,$tag) {
			if(isset($infoArray["tags"]["id3v2"][$tag][0])) {
				return $infoArray["tags"]["id3v2"][$tag][0];
			} else {
				return null;
			}
		}
		
	}