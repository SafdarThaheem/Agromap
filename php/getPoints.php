<?php  include 'config.php';
	
	$pdo = new PDO($dsn, $user, $password, $opt);

	$query = "SELECT ST_AsGeoJSON(t.*)
				FROM (SELECT id, tpo, empresa, productor, area_cos, area_sem, fe_siem, fe_cos, fe_ac, responsabl, variedad, geom FROM" . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"'.")
		 			AS t;";

	$result = $pdo->query($query);


	$features = [];
	foreach ($result as $row) {
		array_push($features, json_decode($row['st_asgeojson']));
		
	}

	$featureCollection = ['type'=>'FeatureCollection', 'features'=>$features]; 
	echo json_encode($featureCollection);

?>