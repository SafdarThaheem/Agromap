<?php  include 'config.php';

	$pdo = new PDO($dsn, $user, $password, $opt);

	$query = "SELECT ST_AsGeoJSON(t.*)
				FROM (SELECT id, tpo, prov, dis, crg, empresa, productor, area_cos, area_sem, fe_siem, fe_cos, fe_ac, responsabl, variedad, geom FROM " . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"';
	$end_query = ") AS t;";

	$add_query = " WHERE ";

	if ($_POST['Provincia'] != '--Provincia--'){
		$provincia = $_POST['Provincia'];
		$add_query .= "prov = '{$provincia}' AND ";
		
		if (($_POST['District']) != ''){
			$district = $_POST['District'];
			$add_query .= ("dis = '{$district}' AND ");
		}

		if ($_POST['Correg'] != ''){
			$correg = $_POST['Correg'];
			$add_query .= ("crg = '{$correg}' AND ");
		}

	}
	// Check the planting date, harvesting date and update date
	if ($_POST['Plant_date_from'] != ''){
		$p_date_from = $_POST['Plant_date_from'];
		$p_date_from = date("Y-m-d", strtotime($p_date_from));
		$add_query .= "fe_siem >= '{$p_date_from}' AND ";
	}

	if ($_POST['Plant_date_to'] != ''){
		$p_date_to = $_POST['Plant_date_to'];
		$p_date_to = date("Y-m-d", strtotime($p_date_to));
		$add_query .= "fe_siem <= '{$p_date_to}' AND ";
	}

	if ($_POST['Harvest_date_from'] != ''){
		$h_date_from = $_POST['Harvest_date_from'];
		$h_date_from = date("Y-m-d", strtotime($h_date_from));
		$add_query .= "fe_cos >= '{$h_date_from}' AND ";
	}

	if ($_POST['Harvest_date_to'] != ''){
		$h_date_to = $_POST['Harvest_date_to'];
		$h_date_to = date("Y-m-d", strtotime($h_date_to));
		$add_query .= "fe_cos <= '{$h_date_to}' AND ";
	}

	if ($_POST['Update_date_from'] != ''){
		$u_date_from = $_POST['Update_date_from'];
		$u_date_from = date("Y-m-d", strtotime($u_date_from));
		$add_query .= "fe_ac >= '{$u_date_from}' AND ";
	}

	if ($_POST['Update_date_to'] != ''){
		$u_date_to = $_POST['Update_date_to'];
		$u_date_to = date("Y-m-d", strtotime($u_date_to));
		$add_query .= "fe_ac <= '{$u_date_to}' AND ";
	}

	// Checking the area
	if ($_POST['Plant_area_from'] != ''){
		$p_area_from = $_POST['Plant_area_from'];
		$add_query .= "area_sem >= '{$p_area_from}' AND ";	
	}

	if ($_POST['Plant_area_to'] != ''){
		$p_area_to = $_POST['Plant_area_to'];
		$add_query .= "area_sem <= '{$p_area_to}' AND ";	
	}

	if ($_POST['Harvest_area_from'] != ''){
		$h_area_from = $_POST['Harvest_area_from'];
		$add_query .= "area_cos >= '{$h_area_from}' AND ";	
	}

	if ($_POST['Harvest_area_to'] != ''){
		$h_area_to = $_POST['Harvest_area_to'];
		$add_query .= "area_cos <= '{$h_area_to}' AND ";	
	}

	if ($_POST['Variedad'] != ''){
		$variedad = $_POST['Variedad'];
		$add_query .= "variedad = '{$variedad}' AND ";
	}

	if ($_POST['Responsabl'] != ''){
		$responsabl = $_POST['Responsabl'];
		$add_query .= "responsabl = '{$responsabl}' AND ";
	}
	
	if ($_POST['Tipo'] != ''){
		$type = $_POST['Tipo'];
		$add_query .= "tpo = '{$type}' AND ";
	}


	if ($add_query != ' WHERE '){
		$display_table = 'True';
	}
	else{
		$display_table = 'False';
	}


	if (substr($add_query, -4) == 'AND '){
		$add_query = substr($add_query, 0, -4);

	}else if(substr($add_query, -6) == 'WHERE '){
		$add_query = substr($add_query, 0, -6);
	}


	$final_query = $query . $add_query . $end_query;

	$result = $pdo->query($final_query);


	$features = [];
	foreach ($result as $row) {
		array_push($features, json_decode($row['st_asgeojson']));
		
	}

	$featureCollection = ['type'=>'FeatureCollection', 'features'=>$features];
	$output_Data = ['displayTable'=>$display_table, 'featureCollection'=>$featureCollection]; 
	echo json_encode($output_Data);
?>