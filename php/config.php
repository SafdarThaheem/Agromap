<?php 
	
	$host = '63.250.41.89';
	$port = '5432';
	$dbname = 'Agrosilos';
	$user = 'agromap';
	$password = 'agro_Select_PW';
	//$password = 'uUP38oWm1g3bM';
	
	$dsn = "pgsql:host=$host;dbname=$dbname;port=$port";

	$opt = [
		PDO::ATTR_ERRMODE 				=>PDO::ERRMODE_SILENT,
		PDO::ATTR_DEFAULT_FETCH_MODE	=>PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES		=>false
	];
	
 ?>