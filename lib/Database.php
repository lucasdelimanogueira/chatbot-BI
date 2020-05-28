<?php

class Database{

	private $host = "localhost";
	private $user = "root";
	private $pass = "";
	private $database = "bibot";

	//conecta ao banco de dados
	public function connect(){
		$connection = new mysqli($this->host, $this->user, $this->pass, $this->database);

		$connection->query("SET NAMES 'utf8'");
		$connection->query("SET character_set_connection = utf8");
		$connection->query("SET character_set_client = utf8");
		$connection->query("SET character_set_results = utf8");	
		
		return $connection;		
	}

	public function query($sql){
		return $this->connect()->query($sql);
	}
}
?>