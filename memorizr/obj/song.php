<?php

	class Song {
		
		public $id;
		public $title;
		public $artist;
		public $album;
		public $year;
		public $genre;
		public $memory;
		
		public function setValueFor($name, $value) {
			$this->{$name} = $value; 
		}
		
		public function getValueFor($name) {
			return $this->{$name}; 
		}
		
		public function info() {
			$info = array(
				"id" => $this->id,
				"title" => $this->title,
				"artist" => $this->artist,
				"album" => $this->album,
				"year" => $this->year,
				"genre" => id3_get_genre_name($this->genre),
				"memory" => $this->memory
			);
			
			return $info;
		}
	}