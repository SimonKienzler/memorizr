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
	
	}