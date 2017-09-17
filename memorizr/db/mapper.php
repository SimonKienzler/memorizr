<?php 

	require("/../gui/renderer.php");

	class Mapper {
		
		public static $connection = null;
		
		public static function createConnection() {
			require("/../config.php");
			try {
				$con = new PDO("mysql:host=" . $DB_SERVER . ";dbname=" . $DB_SCHEMA, $DB_USER, $DB_PASS);
				// set the PDO error mode to exception
				$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$connection = $con;
				return true;
			}
			catch(PDOException $e) {
				echo "Connection failed: " . $e->getMessage();
				return false;
			}
		}
		
		public static function getConnection() {
			if(self::$connection == null) {
				if(!DB::createConnection()) {
					die(Renderer::error("Error while creating database connection","No detailed log available."));
				}
			}
			
			return self::$connection;
		}
		
		public static function saveSong($song) {
			$stmt = self::$connection->prepare("INSERT INTO song (id,  title,  artist,  album,  year,  genre,  memory)"
												. "VALUES (UNHEX(:id), :title, :artist, :album, :year, :genre, :memory);"); 
												
			$stmt->bindParam(":id", $song->getValueFor("id"));
			$stmt->bindParam(":title", $song->getValueFor("title"));
			$stmt->bindParam(":artist", $song->getValueFor("artist"));
			$stmt->bindParam(":album", $song->getValueFor("album"));
			$stmt->bindParam(":year", $song->getValueFor("year"));
			$stmt->bindParam(":genre", $song->getValueFor("genre"));
			$stmt->bindParam(":memory", $song->getValueFor("memory"));
			
			try {
				$stmt->execute();
			} catch(PDOException $e) {
				die(Renderer::error("Saving to Database failed",$e->getMessage()));
			}
			
		}
		
		public static function songIdExists($songId) {
			$stmt = self::$connection->prepare("SELECT id FROM song WHERE id = UNHEX(:id);");
			$stmt->bindParam(":id",$songId);
			$stmt->execute();
			return $stmt->fetch();
		}
		
		public static function searchForTerm($term) {
			/*$parts = explode(" ", $term);
			$searchString = "jr5$_grl";
			foreach($parts as $part) {
				searchString = searchString . " OR %" . $part . "%";
			}*/
			
			require_once(__DIR__ . "./../obj/song.php");
			$stmt = self::$connection->prepare("SELECT HEX(id) as id, title, artist, album, year, genre, memory " .
												"FROM song WHERE title LIKE :term1 " . 
												"OR artist like :term2 " .
												"OR album like :term3;");
			$searchString = "%" . $term . "%";
			$stmt->bindParam(":term1",$searchString);
			$stmt->bindParam(":term2",$searchString);
			$stmt->bindParam(":term3",$searchString);
			$stmt->execute();
			$results = array();
			$i = 0;
			while($row = $stmt->fetch()) {
				$results[$i] = new Song();
				$results[$i]->setValueFor("id",$row['id']); 
				$results[$i]->setValueFor("title",$row['title']); 
				$results[$i]->setValueFor("artist",$row['artist']); 
				$results[$i]->setValueFor("album",$row['album']); 
				$results[$i]->setValueFor("year",$row['year']); 
				$results[$i]->setValueFor("genre",$row['genre']); 
				$results[$i++]->setValueFor("memory",$row['memory']);
			}
			
			return $results;
		}
	
	}