<?php  include 'config.php';
	
	$pdo = new PDO($dsn, $user, $password, $opt);

	$query = "SELECT ST_AsGeoJSON(t.*)
			  FROM " . '"Proyecto_Arroz"' . "." . '"Poligonos_Fincas"'  . " AS t;";

	$result = $pdo->query($query);


	$features = [];
	foreach ($result as $row) {
		array_push($features, json_decode($row['st_asgeojson']));
		
	}

	$featureCollection = ['type'=>'FeatureCollection', 'features'=>$features]; 
	echo json_encode($featureCollection);

?>