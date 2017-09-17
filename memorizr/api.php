<?php

	if(isset($_GET['query-string'])) {
		
		require_once(__DIR__  . "./db/mapper.php");
		require_once(__DIR__  . "./gui/renderer.php");
		
		if(!Mapper::createConnection()) {
				die("Database Connection could not be established.");
		}
		
		$results = Mapper::searchForTerm($_GET['query-string']);
		$returnString = "";
		foreach($results as $result) {
			$returnString = $returnString . Renderer::searchResult($result);
		}
		
		echo $returnString;
	}