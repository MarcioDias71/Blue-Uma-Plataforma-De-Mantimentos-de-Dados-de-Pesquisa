<?php
	// connectar ao banco de dados
	try {
		
		$db = new PDO("mysql:dbname=Blue;host=localhost","root", "");

	}catch(PDOException $e){
		echo "Erro com banco de dados ". $e->getMessage();
	}catch(Exception $e){
		echo "Erro genérico ". $e->getMessage();
	}
	
?>