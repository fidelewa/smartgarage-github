<?php

    $keyword = strval($_POST["makename"]);
	$search_param = "{$keyword}%";
	$conn =new mysqli('localhost', 'root', '' , 'gestiongarage_bdd');

	$sql = $conn->prepare("SELECT * FROM tbl_make where make_name LIKE ?");
	$sql->bind_param("s",$search_param);			
	$sql->execute();
	$result = $sql->get_result();
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
		$countryResult[] = $row["make_name"];
		}
		echo json_encode($countryResult);
	}
	$conn->close();

