<?php include 'config.php';


	$pdo = new PDO($dsn, $user, $password, $opt);

	$query = "SELECT * FROM(
				SELECT sum(area_sem) as sem, sum(area_cos) as cos, COUNT(variedad) as var, prov 
				FROM " . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"' . "GROUP BY prov
				) as t WHERE t.sem is not null and t.cos is not null and t.var is not null";
	$result = $pdo->query($query);

	$features = [];
	foreach ($result as $row) {
		array_push($features, $row);
		//echo json_encode($row);
	}

	//echo json_encode($features);
	$out_Data = ['features'=>$features]; 
	echo json_encode($out_Data);
  ?>