<?php include 'config.php';

	$pdo = new PDO($dsn, $user, $password, $opt);

	if($_POST['Provincia'] != '--Provincia--'){
		$query2 = "SELECT * FROM(
					SELECT variedad as var, COUNT(variedad) as count_var, prov
					FROM  " . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"'; 
					
		$end_query2 = "GROUP BY var, prov
							) as t WHERE count_var is not null";

		$query = "SELECT * FROM(
					SELECT sum(area_sem) as sem, sum(area_cos) as cos, COUNT(variedad) as var, prov 
					FROM " . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"' ;
		$add_query = " WHERE ";
	 	$end_query = " GROUP BY prov
					) as t WHERE t.sem is not null and t.cos is not null and t.var is not null";


		if ($_POST['Provincia'] != '--Provincia--'){
			$provincia = $_POST['Provincia'];
			$add_query = " WHERE prov = '{$provincia}' AND ";

		}

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
		
		if (substr($add_query, -4) == 'AND '){
			$add_query = substr($add_query, 0, -4);

		}else if(substr($add_query, -6) == 'WHERE '){
			$add_query = substr($add_query, 0, -6);
		}


		$final_query = $query . $add_query . $end_query;
		$final_query2 = $query2 . $add_query . $end_query2;


		$result = $pdo->query($final_query);
		$result2 = $pdo->query($final_query2);

		$features = [];
		foreach ($result as $row) {
			array_push($features, $row);
			//echo json_encode($row);
		}

		$features2 = [];
		foreach ($result2 as $row2) {
			array_push($features2, $row2);
		}

		//echo json_encode($features);
		$out_Data = ['features'=>$features, 'features2'=>$features2, 'type'=>'pNotNull'];

	}else if($_POST['Provincia'] == '--Provincia--'){
		

		$query = "SELECT * FROM(
					SELECT sum(area_sem) as sem, sum(area_cos) as cos, COUNT(variedad) as var, prov 
					FROM " . '"Proyecto_Arroz"' . "." . '"Productores_Arroz"' ;
		$add_query = " WHERE ";
	 	$end_query = " GROUP BY prov
					) as t WHERE t.sem is not null and t.cos is not null and t.var is not null";


		if ($_POST['Provincia'] != '--Provincia--'){
			$add_query = " WHERE prov = '{$_POST['Provincia']}'";

		}

		if ($_POST['Plant_area_from'] != ''){
			$add_query .= "area_sem >= '{$_POST['Plant_area_from']}' AND ";
		}

		if ($_POST['Plant_area_to'] != ''){
			$add_query .= "area_sem <= '{$_POST['Plant_area_to']}' AND ";
		}

		if ($_POST['Harvest_area_from'] != ''){
			$add_query .= "area_cos >= '{$_POST['Harvest_area_from']}' AND ";
		}

		if ($_POST['Harvest_area_to'] != ''){
			$add_query .= "area_cos <= '{$_POST['Harvest_area_to']}' AND ";
		}

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

		if ($_POST['Variedad'] != ''){
			$add_query .= "variedad = '{$_POST['Variedad']}' AND ";
		}

		if ($_POST['Responsabl'] != ''){
			$add_query .= "responsabl = '{$_POST['Responsabl']}' AND ";
		}

		if ($_POST['Tipo'] != ''){
			$type = $_POST['Tipo'];
			$add_query .= "tpo = '{$type}' AND ";
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
			array_push($features, $row);
		}

		$out_Data = ['features'=>$features, 'features2'=>'none', 'type'=>'pIsNull'];
	}

	 
	echo json_encode($out_Data);
  ?>