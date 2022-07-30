<?php include 'config.php';

	$pdo = new PDO($dsn, $user, $password, $opt);

	$out_str = "";

	if ($_POST['type'] == ''){
		$query = "SELECT DISTINCT(prov)
				  FROM " . '"Proyecto_Arroz"' . "." . '"prov_crg"'  . " ORDER BY prov;";

		$result = $pdo->query($query);
		
		foreach ($result as $row) {
			//echo ($row['prov']);	
			$out_str .= "<option value='{$row['prov']}'>{$row['prov']}</option>";
		}

	}else if($_POST['type'] == "distData"){
		$query = "SELECT DISTINCT(dist)
				  FROM " . '"Proyecto_Arroz"' . "." . '"prov_crg"'  . " WHERE prov = '{$_POST['name']}' ORDER BY dist;";

		$result = $pdo->query($query);
		
		$out_str .= "<option value=''></option>";
		foreach ($result as $row) {
			$out_str .= "<option value='{$row['dist']}'>{$row['dist']}</option>";
		}

	}else if($_POST['type'] == "crgData"){
		$query = "SELECT DISTINCT(crg)
				  FROM " . '"Proyecto_Arroz"' . "." . '"prov_crg"'  . " WHERE dist = '{$_POST['name']}' ORDER BY crg;";

		$result = $pdo->query($query);

		$out_str .= "<option value=''></option>";
		foreach ($result as $row) {
			$out_str .= "<option value='{$row['crg']}'>{$row['crg']}</option>";
		}

	}else if($_POST['type'] == 'variety'){

		$query = "SELECT DISTINCT(variedad)
				  FROM " . '"Proyecto_Arroz"' . "." .'"Productores_Arroz"' . "
				  WHERE variedad is not null;";
		
		$result = $pdo->query($query);

		$out_str .= "<option value=''></option>";
		foreach ($result as $row) {
			$out_str .= "<option value='{$row['variedad']}'>{$row['variedad']}</option>";
		}

	}elseif($_POST['type'] == 'responsible'){
		$query = "SELECT DISTINCT(responsabl)
				  FROM " . '"Proyecto_Arroz"' . "." .'"Productores_Arroz"' . "
				  WHERE responsabl is not null;";

		$result = $pdo->query($query);

		$out_str .= "<option value=''></option>";
		foreach ($result as $row) {
			$out_str .= "<option value='{$row['responsabl']}'>{$row['responsabl']}</option>";
		}

	}elseif($_POST['type'] == 'type'){
		$query = "SELECT DISTINCT(tpo)
				  FROM " . '"Proyecto_Arroz"' . "." .'"Productores_Arroz"' . "
				  WHERE tpo is not null";

		$result = $pdo->query($query);

		$out_str .= "<option value=''></option>";
		foreach ($result as $row) {
			$out_str .= "<option value='{$row['tpo']}'>{$row['tpo']}</option>";
		}

	}

	echo $out_str;
 ?>