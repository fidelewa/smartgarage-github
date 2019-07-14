<?php
//include_once('../config.php');v
class wms_core
{
	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListTen($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, rvr.car_id, attribution_mecanicien, sign_cli_depot, sign_recep_depot, sign_cli_sortie, sign_recep_sortie,
		add_car_id, diag.id as vehi_diag_id, status_attribution_vehicule, usr.usr_name as recep_name, status_diagnostic_vehicule, mech.usr_name as mech_name
			from tbl_recep_vehi_repar rvr
			left join tbl_add_user usr on (rvr.attrib_recep = usr.usr_id) 
			left join tbl_add_mech mech on (rvr.attribution_mecanicien = mech.usr_id) 
			JOIN tbl_add_customer cus on rvr.customer_name = cus.customer_id
			left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
			WHERE status_attribution_vehicule = 1 OR status_diagnostic_vehicule = 1
			LIMIT 10;
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, rvr.car_id, attribution_mecanicien, sign_cli_depot, sign_recep_depot, sign_cli_sortie, sign_recep_sortie,
		add_car_id, diag.id as vehi_diag_id, status_attribution_vehicule, usr.usr_name as recep_name, status_diagnostic_vehicule, mech.usr_name as mech_name
			from tbl_recep_vehi_repar rvr
			left join tbl_add_user usr on (rvr.attrib_recep = usr.usr_id) 
			left join tbl_add_mech mech on (rvr.attribution_mecanicien = mech.usr_id) 
			JOIN tbl_add_customer cus on rvr.customer_name = cus.customer_id
			left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function saveUpdateUserInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['user_id'] == '0') {

				$query = "INSERT INTO tbl_add_user(usr_name, usr_email, usr_password, usr_type, usr_image) 
				values('$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$data[user_type]', '$image_url')";
				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_user` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
				`usr_image`='" . $image_url . "'
				 WHERE usr_id='" . $data['usr_id'] . "'";
				$result = mysql_query($query, $con);

				if ($data['user_type'] == "mecanicien" || $data['user_type'] == "electricien") {

					$query = "UPDATE `tbl_add_mech` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
				`usr_image`='" . $image_url . "'
				 WHERE usr_id='" . $data['usr_id'] . "'";
					$result = mysql_query($query, $con);
				}

				if ($data['user_type'] == "administrateur") {
					$query = "UPDATE `tbl_add_mech` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "',`usr_image`='" . $image_url . "'
				 WHERE user_id ='" . $data['usr_id'] . "'";
					$result = mysql_query($query, $con);
				}
			}

			if (!$result) {
				var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function createMechUser($con, $data, $image_url)
	{

		if (!empty($data)) {

			if ($data['usr_id'] == '0') {

				$queryInsertUser = "INSERT INTO tbl_add_user(usr_name, usr_email, usr_password, usr_type, usr_image) 
				values('$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$data[user_type]', '$image_url')";

				// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
				$resultInsertUser = mysql_query($queryInsertUser, $con);

				if (!$resultInsertUser) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $queryInsertUser;
					die($message);
				}

				// On récupère l'identifiant de la dernière pièce ajoutée
				$user_id = mysql_insert_id();

				$query = "INSERT INTO `tbl_add_mech`(usr_id, usr_name, usr_email, usr_password, usr_type, usr_image) 
				VALUES ('$user_id','$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$data[user_type]','$image_url')";

				$result = mysql_query($query, $con);

				if (!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			} else {
				// die('je suis dans mech');

				$query = "UPDATE `tbl_add_mech` 
			SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
			`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
			`usr_image`='" . $image_url . "'
			 WHERE usr_id='" . $data['usr_id'] . "'";

				mysql_query($query, $con);

				$query_2 = "UPDATE `tbl_add_user` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
				`usr_image`='" . $image_url . "'
				 WHERE usr_id='" . $data['usr_id'] . "'";

				mysql_query($query_2, $con);
			}
		}
	}

	/*
	* @Mettre à jour le profil de l'utilisateur
	*/
	public function createAdminUser($con, $data, $image_url)
	{

		if (!empty($data)) {

			if ($data['usr_id'] == '0') {

				$query = "INSERT INTO `tbl_admin` (`name`, email, `password`, `image`) 
				VALUES ('$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$image_url')";

				$result = mysql_query($query, $con);

				if (!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}

				// On récupère l'identifiant de la dernière pièce ajoutée
				$user_id = mysql_insert_id();

				$queryInsertUser = "INSERT INTO tbl_add_user(usr_id, usr_name, usr_email, usr_password, usr_type, usr_image) 
				values($user_id, '$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$data[user_type]', '$image_url')";

				// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
				$resultInsertUser = mysql_query($queryInsertUser, $con);

				if (!$resultInsertUser) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $queryInsertUser;
					die($message);
				}
			} else {

				$query = "UPDATE `tbl_admin` 
				SET `name`='" . $data['txtUserName'] . "',`email`='" . $data['txtUserEmail'] . "',
				`password`='" . $data['txtUserPassword'] . "',
				`image`='" . $image_url . "'
			 	WHERE user_id='" . $data['usr_id'] . "'";

				mysql_query($query, $con);

				$query_2 = "UPDATE `tbl_add_user` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
				`usr_image`='" . $image_url . "'
				 WHERE usr_id='" . $data['usr_id'] . "'";

				mysql_query($query_2, $con);

			}
		}
	}

	public function getPhotoCarPieceChangeByCar($con, $car_id)
	{

		$query = "SELECT * 
		FROM tbl_add_car cr 
		JOIN tbl_model mo ON cr.car_model = mo.model_id
		LEFT JOIN tbl_photo_car_piece_change pcpc ON pcpc.car_id = cr.car_id
		WHERE cr.car_id = '" . (int) $car_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	/*
	* @login process
	*/
	public function login_operation($con, $data)
	{

		$obj_login = array();
		if ($data['ddlLoginType'] == 'admin') {

			$sql = mysql_query("SELECT * FROM tbl_admin WHERE email = '" . $this->make_safe($data['username']) . "' and password = '" . $this->make_safe($data['password']) . "'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['user_id'],
					'name'			=> $row['name'],
					'email'			=> $row['email'],
					'password'		=> $row['password'],
					'image'			=> $row['image']
				);
			}
		} else if ($data['ddlLoginType'] == 'customer') {

			$sql = mysql_query("SELECT * FROM tbl_add_customer WHERE c_email = '" . $this->make_safe($data['username']) . "' and c_password = '" . $this->make_safe($data['password']) . "'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['customer_id'],
					'name'			=> $row['c_name'],
					'email'			=> $row['c_email'],
					'password'		=> $row['c_password'],
					'image'			=> $row['image']
				);
			}
		} else if ($data['ddlLoginType'] == 'mechanics') {

			$sql = mysql_query("SELECT * FROM tbl_add_user WHERE usr_email = '" . $this->make_safe($data['username']) . "' and usr_password = '" . $this->make_safe($data['password']) . "' and usr_type IN ('mecanicien','electricien')", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['usr_id'],
					'name'			=> $row['usr_name'],
					'email'			=> $row['usr_email'],
					'password'		=> $row['usr_password'],
					'image'			=> $row['usr_image']
				);
			}
		} else if ($data['ddlLoginType'] == 'reception') {

			$sql = mysql_query("SELECT * FROM tbl_add_user WHERE usr_email = '" . $this->make_safe($data['username']) . "' and usr_password = '" . $this->make_safe($data['password']) . "' and usr_type = 'receptionniste'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['usr_id'],
					'name'			=> $row['usr_name'],
					'email'			=> $row['usr_email'],
					'password'		=> $row['usr_password'],
					'image'			=> $row['usr_image']
				);
			}
		} else if ($data['ddlLoginType'] == 'comptable') {

			$sql = mysql_query("SELECT * FROM tbl_add_user WHERE usr_email = '" . $this->make_safe($data['username']) . "' and usr_password = '" . $this->make_safe($data['password']) . "' and usr_type = 'comptable'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['usr_id'],
					'name'			=> $row['usr_name'],
					'email'			=> $row['usr_email'],
					'password'		=> $row['usr_password'],
					'image'			=> $row['usr_image']
				);
			}
		} else if ($data['ddlLoginType'] == 'service client') {

			$sql = mysql_query("SELECT * FROM tbl_add_user WHERE usr_email = '" . $this->make_safe($data['username']) . "' and usr_password = '" . $this->make_safe($data['password']) . "' and usr_type = 'service client'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['usr_id'],
					'name'			=> $row['usr_name'],
					'email'			=> $row['usr_email'],
					'password'		=> $row['usr_password'],
					'image'			=> $row['usr_image']
				);
			}
		}
		return $obj_login;
	}



	public function getPhotoCarApWorkByCar($con, $car_id)
	{

		$query = "SELECT * 
		FROM tbl_add_car cr 
		JOIN tbl_model mo ON cr.car_model = mo.model_id
		LEFT JOIN tbl_photo_car_apres_work pcapw ON pcapw.car_id = cr.car_id
		WHERE cr.car_id = '" . (int) $car_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getPhotoCarAvWorkByCar($con, $car_id)
	{

		$query = "SELECT * 
		FROM tbl_add_car cr 
		JOIN tbl_model mo ON cr.car_model = mo.model_id
		LEFT JOIN tbl_photo_car_avant_work pcaw ON pcaw.car_id = cr.car_id
		WHERE cr.car_id = '" . (int) $car_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getWorktoolDataByEmploId($con, $per_id)
	{
		$data = array();

		$query = "SELECT wt.*, per_name
		FROM tbl_add_worktool wt
		JOIN tbl_add_personnel per ON per.per_id = wt.per_id
		WHERE per.per_id = '" . $per_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function saveUpdateWorkToolInformation($con, $data)
	{
		if (!empty($data)) {

			// Instanciation de la date de l'avance à partir de la date du jour
			$dateEnregistrement = new \Datetime("now");

			// Récupération de la date de l'avance en chaine de caractères 
			$dateEnregistremenStr = $dateEnregistrement->format('Y-m-d');

			if ($data['worktool_id'] == '0') {

				$query = "INSERT INTO tbl_add_worktool(numero_tool, libelle_tool, date_enregistrement, type_tool, per_id)

				values('$data[numTool]','$data[libTool]','$dateEnregistremenStr','$data[typeTool]','$data[personnel_id]')";

				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_worktool` 
				SET `numero_tool`='" . $data['numTool'] . "',
				`libelle_tool`='" . $data['libTool'] . "',
				`type_tool`='" . $data['typeTool'] . "',
				WHERE per_id='" . $data['personnel_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function saveSalnetPerso($con, $montant_salnet, $per_id, $per_telephone)
	{

		// Instanciation de la date du salaire net à partir de la date du jour
		$dateSalnet = new \Datetime("now");

		// Récupération du numéro du mois de la date de définition du salaire net
		$numeroMoisDateSalnet = $dateSalnet->format('n');

		// Récupération de la date du salaire net en chaines de caractères 
		$dateSalnetStr = $dateSalnet->format('Y-m-d');

		// Recherche pour vérifier si le numéro de téléphone de l'employé courant existe déja dans la table
		$queryGetSalnetInfoByPer = "SELECT * FROM tbl_salnet_personnel
		WHERE emplo_tel='" . $per_telephone . "'";

		$resultGetSalnetInfoByPer = mysql_query($queryGetSalnetInfoByPer, $con);

		if (!$resultGetSalnetInfoByPer) {

			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetSalnetInfoByPer;
			die($message);
		}

		$rowSalnetInfoByPer = mysql_fetch_assoc($resultGetSalnetInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowSalnetInfoByPer) || $rowSalnetInfoByPer == false) {

			$query = "INSERT INTO tbl_salnet_personnel(salnet_montant, salnet_date, mois_date_salnet, per_id, emplo_tel)
		values('$montant_salnet','$dateSalnetStr','$numeroMoisDateSalnet','$per_id','$per_telephone')";
			$result = mysql_query($query, $con);
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_salnet_personnel
				SET `salnet_montant`='" . $montant_salnet . "',
				`salnet_date`='" . $dateSalnetStr . "',
				`mois_date_salnet`='" . $numeroMoisDateSalnet . "'
				WHERE emplo_tel='" . $per_telephone . "'";
			$result = mysql_query($query, $con);
		}

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function saveAvancePerso($con, $montant_avance, $per_id, $per_telephone)
	{

		// Instanciation de la date de l'avance à partir de la date du jour
		$dateAvance = new \Datetime("now");

		// Récupération du numéro du mois de la date de l'avance
		$numeroMoisDateAvance = $dateAvance->format('n');

		// Récupération de la date de l'avance en chaine de caractères 
		$dateAvanceStr = $dateAvance->format('Y-m-d');

		// Recherche pour vérifier si le numéro de téléphone de l'employé courant existe déja dans la table
		$queryGetAvanceInfoByPer = "SELECT * FROM tbl_avance_personnel
		WHERE emplo_tel='" . $per_telephone . "'";

		$resultGetAvanceInfoByPer = mysql_query($queryGetAvanceInfoByPer, $con);

		if (!$resultGetAvanceInfoByPer) {

			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetAvanceInfoByPer;
			die($message);
		}

		$rowAvanceInfoByPer = mysql_fetch_assoc($resultGetAvanceInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowAvanceInfoByPer) || $rowAvanceInfoByPer == false) {

			$query = "INSERT INTO tbl_avance_personnel(montant_avance, date_avance, mois_date_avance, per_id, emplo_tel)
		values('$montant_avance','$dateAvanceStr','$numeroMoisDateAvance','$per_id','$per_telephone')";

			$result = mysql_query($query, $con);
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_avance_personnel
				SET `montant_avance`='" . $montant_avance . "',
				`date_avance`='" . $dateAvanceStr . "',
				`mois_date_avance`='" . $numeroMoisDateAvance . "'
				WHERE emplo_tel='" . $per_telephone . "'";
			$result = mysql_query($query, $con);
		}

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function savePrimePerso($con, $montant_prime, $per_id, $per_telephone)
	{

		// Instanciation de la date de la prime à partir de la date du jour
		$datePrime = new \Datetime("now");

		// Récupération du numéro du mois de la date de la prime
		$numeroMoisDatePrime = $datePrime->format('n');

		// Récupération de la date de la prime en chaine de caractères 
		$datePrimeStr = $datePrime->format('Y-m-d');

		// Recherche pour vérifier si le numéro de téléphone de l'employé courant existe déja dans la table
		$queryGetPrimeInfoByPer = "SELECT * FROM tbl_prime_personnel
		WHERE emplo_tel='" . $per_telephone . "'";

		$resultGetPrimeInfoByPer = mysql_query($queryGetPrimeInfoByPer, $con);

		if (!$resultGetPrimeInfoByPer) {

			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetPrimeInfoByPer;
			die($message);
		}

		$rowPrimeInfoByPer = mysql_fetch_assoc($resultGetPrimeInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowPrimeInfoByPer) || $rowPrimeInfoByPer == false) {

			$query = "INSERT INTO tbl_prime_personnel(montant_prime, date_prime, mois_date_prime, per_id, emplo_tel)
		values('$montant_prime','$datePrimeStr','$numeroMoisDatePrime','$per_id','$per_telephone')";

			$result = mysql_query($query, $con);
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_prime_personnel
				SET `montant_prime`='" . $montant_prime . "',
				`date_prime`='" . $datePrimeStr . "',
				`mois_date_prime`='" . $numeroMoisDatePrime . "'
				WHERE emplo_tel='" . $per_telephone . "'";
			$result = mysql_query($query, $con);
		}

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function updateAbsenceEmplo($con, $data)
	{
		// Instanciation de la date du jour
		$dateJour = new \Datetime("now");

		// Récupération du numéro du mois de la date du jour
		$numeroMoisDateJour = $dateJour->format('n');

		// Recherche pour vérifier si le numéro de téléphone de l'employé courant existe déja dans la table
		$queryGetSalInfoByPer = "SELECT * FROM tbl_emplo_conge_abs 
		WHERE emplo_tel='" . $data['per_tel'] . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultSalInfoByPer = mysql_query($queryGetSalInfoByPer, $con);

		if (!$resultSalInfoByPer) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetSalInfoByPer;
			die($message);
		}

		$rowSalInfoByPer = mysql_fetch_assoc($resultSalInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowSalInfoByPer) || $rowSalInfoByPer == false) {

			$query = "INSERT INTO tbl_emplo_conge_abs (nb_jour_conge_paye, nb_jour_abs_justifie, mois_jour_conge_paye, 
			mois_jour_abs_justifie, per_id, emplo_tel) 
			VALUES (null, '$data[nb_jour_abs_employ]', null,'$numeroMoisDateJour', '$data[per_id]','$data[per_tel]')";
			$result = mysql_query($query, $con);
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_emplo_conge_abs
				SET `nb_jour_abs_justifie`='" . $data['nb_jour_abs_employ'] . "',
				`mois_jour_abs_justifie`='" . $numeroMoisDateJour . "'
				WHERE emplo_tel='" . $data['per_tel'] . "'";
			$result = mysql_query($query, $con);
		}

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function updateCongePayeEmplo($con, $data)
	{
		// Instanciation de la date du jour
		$dateJour = new \Datetime("now");

		// Récupération du numéro du mois de la date du jour
		$numeroMoisDateJour = $dateJour->format('n');

		// Recherche dans la table 
		$queryGetSalInfoByPer = "SELECT * FROM tbl_emplo_conge_abs 
		WHERE emplo_tel='" . $data['per_tel'] . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultSalInfoByPer = mysql_query($queryGetSalInfoByPer, $con);

		if (!$resultSalInfoByPer) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetSalInfoByPer;
			die($message);
		}

		$rowSalInfoByPer = mysql_fetch_assoc($resultSalInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowSalInfoByPer) || $rowSalInfoByPer == false) {

			$query = "INSERT INTO tbl_emplo_conge_abs (nb_jour_conge_paye, nb_jour_abs_justifie, mois_jour_conge_paye, 
			mois_jour_abs_justifie, per_id, emplo_tel)
			VALUES ('$data[nb_jour_conge_paye]', null, '$numeroMoisDateJour', null, '$data[per_id]','$data[per_tel]')";
			$result = mysql_query($query, $con);
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_emplo_conge_abs
				SET `nb_jour_conge_paye`='" . $data['nb_jour_conge_paye'] . "',
				`mois_jour_conge_paye`='" . $numeroMoisDateJour . "'
				WHERE emplo_tel='" . $data['per_tel'] . "'";
			$result = mysql_query($query, $con);
		}

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function deleteBcmde($con, $bcmdid)
	{
		mysql_query("DELETE FROM `tbl_add_boncmde` WHERE boncmde_id = " . (int) $bcmdid, $con);
	}

	/*
	* @get supplier info by id
	*/
	public function getInfoComptaByRef($con, $ref)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_ges_four_compta
		WHERE tbl_ges_four_compta_ref = '" . $ref . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// $row = mysql_fetch_assoc($result);
		// return $row;

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		var_dump($data);

		return $data;
	}

	public function getBonCmdeById($con, $bcmdeId)
	{
		$query = "SELECT bcmd.*, s_name
			FROM tbl_add_boncmde bcmd 
			JOIN tbl_add_supplier su ON su.supplier_id=bcmd.supplier_id
			WHERE boncmde_id ='" . (int) $bcmdeId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getAllBonCmde($con)
	{
		$data = array();

		$query = "SELECT *
			FROM tbl_add_boncmde";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllBonCmdeDataByCarId($con, $car_id)
	{
		$data = array();

		$query = "SELECT bcmd.*, s_name, car_name, model_name, VIN  
		FROM tbl_add_boncmde bcmd 
		JOIN tbl_add_supplier su ON su.supplier_id=bcmd.supplier_id
		JOIN tbl_add_car cr ON cr.car_id = bcmd.car_id 
		JOIN tbl_model mo on mo.model_id = cr.car_model
		WHERE bcmd.car_id = '" . $car_id . "'
		ORDER BY boncmde_date_creation DESC";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function saveUpdateBonCmdeInfo($con, $data, $boncmde_data)
	{
		if (!empty($data)) {

			$bcmde_date = $this->datepickerDateToMySqlDate($data['date_bcmd']);
			$bcmde_date_livraison = $this->datepickerDateToMySqlDate($data['date_livraison_bcmd']);

			if ($data['boncmde_id'] == 0) {

				$query = "INSERT INTO tbl_add_boncmde(boncmde_num, supplier_id, boncmde_date_creation, car_id, boncmde_data, boncmde_date_livraison)

				values('$data[num_bcmd]','$data[four]','$bcmde_date','$data[car_id]','$boncmde_data','$bcmde_date_livraison')";
				$result = mysql_query($query, $con);
			} else {
				$query = "UPDATE `tbl_add_boncmde` 
				SET `boncmde_num`='" . $data['num_bcmd'] . "',`supplier_id`='" . $data['four'] . "',
				`boncmde_date_creation`='" . $bcmde_date . "',`boncmde_date_livraison`='" . $bcmde_date_livraison . "',
				`boncmde_data`='" . $boncmde_data . "'
				WHERE boncmde_id='" . (int) $data['boncmde_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function getAllPersoSalaire($con, $numeroMoisDateJour)
	{
		$data = array();

		$query = "SELECT 
		per_name,
		salaire_base,
		nb_heure_sup_periode,
		nb_jour_conge_paye,
		nb_jour_abs_justifie,
		per_telephone,
		montant_avance_periode, 
		SUM(montant_prime) AS montant_prime_periode,
		perso_id,
		salnet_montant
	FROM
		(SELECT 
		per.per_id as perso_id,
				per_name,
				per_sal AS salaire_base,
				SUM(nb_heure_sup) AS nb_heure_sup_periode,
				SUM(montant_avance) AS montant_avance_periode,
				eca.nb_jour_conge_paye,
				eca.nb_jour_abs_justifie,
				per_telephone,
				salnet_montant
		FROM
			tbl_add_pointage po
		LEFT JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel
		LEFT JOIN tbl_emplo_conge_abs eca ON eca.emplo_tel = per.per_telephone
		LEFT JOIN tbl_avance_personnel ap ON ap.emplo_tel = per.per_telephone
		LEFT JOIN tbl_salnet_personnel sp ON sp.emplo_tel = per.per_telephone
		WHERE mois_date_arrivee = '" . $numeroMoisDateJour . "'
		GROUP BY per.per_telephone
		) AS pointage_personnel
		   LEFT JOIN
		tbl_prime_personnel pp ON pp.emplo_tel = pointage_personnel.per_telephone
	GROUP BY pointage_personnel.per_telephone";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarListAtGarage($con)
	{
		$data = array();
		$result = mysql_query("SELECT ac.car_id, car_name, chasis_no, stat_empla_vehi, date_emplacement, VIN, m.*, mo.*, ac.repair_car_id, ac.year,
		ac.add_date_visitetech, ac.add_date_assurance, ac.add_date_assurance_fin
		FROM tbl_add_car ac 
		inner join tbl_histo_emplacement_vehicule hev on hev.car_id = ac.car_id 
		inner join tbl_recep_vehi_repar rvr on rvr.add_car_id = ac.car_id 
		inner join tbl_add_customer c on c.customer_id = ac.customer_id 
		inner join tbl_make m on m.make_id = ac.car_make 
		inner join tbl_model mo on mo.model_id = ac.car_model 
		group by ac.car_id, car_name, chasis_no, stat_empla_vehi, date_emplacement
        having rvr.stat_empla_vehi = 'au garage'
		order by ac.car_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarList($con)
	{
		$data = array();

		$query = "SELECT ac.added_date, repair_car_id, VIN, note, car_id, chasis_no, car_name, ac.image as car_image,c.c_name,c.image as customer_image,c.c_email,c.c_mobile,m.make_name,mo.model_name,ac.repair_car_id, ac.year
		,add_date_visitetech, add_date_assurance, add_date_assurance_fin, princ_tel, m.*, mo.*, VIN, c_name
		FROM tbl_add_car ac 
		inner join tbl_add_customer c on c.customer_id = ac.customer_id 
		inner join tbl_make m on m.make_id = ac.car_make 
		inner join tbl_model mo on mo.model_id = ac.car_model 
		order by ac.car_id DESC";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get supplier info by id
	*/
	public function getInfoAttriMechBydate($con, $mecanicien_id, $car_id, $date_attr)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_histo_attribution
		WHERE meca_elec_id = '" . (int) $mecanicien_id . "' AND car_id = '" . (int) $car_id . "' AND date_attr = '" . $date_attr . "'
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}


	// 	public function getAllPersoSalaire($con, $numeroMoisDateJour)
	// 	{
	// 		$data = array();

	// 		$query = "SELECT 
	//     pp.per_id,
	//     per_name,
	//     salaire_base,
	//     nb_heure_sup_periode,
	//     nb_jour_conge_paye,
	//     SUM(montant_avance) AS montant_avance_periode,
	//     nb_jour_abs_justifie,
	// 	per_telephone
	// FROM
	//     (SELECT 
	//         per.per_id,
	//             per_name,
	//             per_sal AS salaire_base,
	//             SUM(nb_heure_sup) AS nb_heure_sup_periode,
	//             eca.nb_jour_conge_paye,
	//             eca.nb_jour_abs_justifie,
	// 			per_telephone
	//     FROM
	//         tbl_add_pointage po
	//     LEFT JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel
	//     LEFT JOIN tbl_emplo_conge_abs eca ON eca.emplo_tel = per.per_telephone
	//     GROUP BY per.per_id, mois_date_arrivee, mois_date_depart
	// 	HAVING mois_date_arrivee = '" . $numeroMoisDateJour . "' OR
	// 		mois_date_depart = '" . $numeroMoisDateJour . "'
	// 	) AS pointage_personnel
	//        LEFT JOIN
	//     tbl_avance_personnel pp ON pp.per_id = pointage_personnel.per_id
	// 	WHERE mois_date_avance = '" . $numeroMoisDateJour . "'
	// GROUP BY pp.per_id";

	// 		$result = mysql_query($query, $con);

	// 		if (!$result) {
	// 			// var_dump($data);
	// 			$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 			$message .= 'Whole query: ' . $query;
	// 			die($message);
	// 		}

	// 		while ($row = mysql_fetch_assoc($result)) {
	// 			$data[] = $row;
	// 		}
	// 		return $data;
	// 	}

	/*
	* @save/update buy parts list information
	*/
	public function saveUpdateBuyPiecesInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			// $piece_id = $data['piece_id']; 
			// if (!empty($data['ddl_e_parts']) && (int)$data['ddl_e_parts'] > 0) {
			// 	//buy exisiting
			// 	//insert into putchase invoice table
			// 	$parts_id = $data['ddl_e_parts'];
			// 	mysql_query("INSERT INTO tbl_parts_stock(invoice_id,parts_id,parts_name,supplier_id,manufacturer_id,parts_condition,parts_buy_price,parts_quantity,parts_sku,parts_warranty,total_amount,given_amount,pending_amount,parts_image,parts_added_date) values('$data[invoice_id]','$parts_id','$data[parts_names]','$data[ddl_supplier]','$data[ddl_load_manufracturer]','$data[txtCondition]','$data[buy_prie]','$data[parts_quantity]','$data[parts_sku]','$data[parts_warranty]','$data[total_amount]','$data[given_amount]','$data[pending_amount]','$image_url','" . $this->datepickerDateToMySqlDate($data['parts_add_date']) . "')", $con);
			// 	$stock_table = $this->getPartsStockStatusFromStockTable($con, $parts_id);
			// 	if (!empty($stock_table)) {
			// 		$qty = (int)$stock_table['quantity'] + (int)$data['parts_quantity'];
			// 		mysql_query("UPDATE `tbl_parts_stock_manage` SET `parts_name` = '" . $data['parts_names'] . "', `parts_image`='" . $image_url . "', `part_no`='" . $data['parts_sku'] . "',`price`='" . $data['parts_sell_price'] . "', `condition`='" . $data['txtCondition'] . "', `parts_warranty`='" . $data['parts_warranty'] . "', `supplier_id`='" . $data['ddl_supplier'] . "', `manufacturer_id`='" . $data['ddl_load_manufracturer'] . "',`quantity`='" . (int)$qty . "' WHERE parts_id = '" . (int)$parts_id . "'", $con);
			// 	}
			// } else {
			$piece_id = $data['piece_id']; // On récupère l'id de la pièce

			if ($piece_id == '0') {

				// var_dump($data);
				// die();

				// Si la pièce n'existe pas en BDD, on l'enregistre
				$query = "INSERT INTO tbl_add_piece(code_piece, code_barre_piece, lib_piece, type_piece, 
				famille_piece, piece_sous_famille, dernier_prix_achat, montant_frais, prix_revient, coefficient, prix_base_ht,
				prix_base_ttc, image_url, four_id)

				values('$data[code_piece]','$data[code_barre_piece]','$data[lib_piece]','$data[type_piece]',
				'$data[famille_piece]','$data[piece_sous_famille]',
				'$data[last_pa]','$data[mont_frais]','$data[prix_revient]','$data[coeff]','$data[prix_base_ht]','$data[prix_base_ttc]',
				'$image_url', '$data[four]'
				)";

				$result = mysql_query($query, $con);

				if (!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}

				// On récupère l'identifiant de la dernière pièce ajoutée
				$piece_id = mysql_insert_id();

				//insert into putchase invoice table
				// mysql_query("INSERT INTO tbl_parts_stock(invoice_id,parts_id,parts_name,supplier_id,manufacturer_id,parts_condition,parts_buy_price,parts_quantity,parts_sku,parts_warranty,total_amount,given_amount,pending_amount,parts_image,parts_added_date) values('$data[invoice_id]','$parts_id','$data[parts_names]','$data[ddl_supplier]','$data[ddl_load_manufracturer]','$data[txtCondition]','$data[buy_prie]','$data[parts_quantity]','$data[parts_sku]','$data[parts_warranty]','$data[total_amount]','$data[given_amount]','$data[pending_amount]','$image_url','" . $this->datepickerDateToMySqlDate($data['parts_add_date']) . "')", $con);

				// On enregistre cette pièce dans le stock des pièces
				// Lorsqu'on enregistre une nouvelle pièce en stock, son stock de départ est null
				$queryInsertPieceStock = "INSERT INTO tbl_piece_stock(piece_stock_id, code_piece, lib_piece, type_piece, 
				famille_piece, piece_stock_sous_famille,
				prix_base_ttc, stock_piece, image_url)
                values('$piece_id','$data[code_piece]','$data[lib_piece]','$data[type_piece]','$data[famille_piece]',
				'$data[piece_sous_famille]',
				'$data[prix_base_ttc]',0,
				'$image_url'
				)";

				// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
				$resultInsertPieceStock = mysql_query($queryInsertPieceStock, $con);

				if (!$resultInsertPieceStock) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $queryInsertPieceStock;
					die($message);
				}
			} else {

				// var_dump($data);
				// die();

				$query = "UPDATE `tbl_add_piece` 
				SET `code_piece`='" . $data['code_piece'] . "',`code_barre_piece`='" . $data['code_barre_piece'] . "',
				`lib_piece`='" . $data['lib_piece'] . "', `type_piece`='" . $data['type_piece'] . "',
				`famille_piece`='" . $data['famille_piece'] . "',
				`dernier_prix_achat`='" . $data['last_pa'] . "',`montant_frais`='" . $data['mont_frais'] . "',
				`prix_revient`='" . $data['prix_revient'] . "',`coefficient`='" . $data['coeff'] . "',
				`prix_base_ht`='" . $data['prix_base_ht'] . "',`prix_base_ttc`='" . $data['prix_base_ttc'] . "',
				`image_url`='" . $image_url . "'
				WHERE add_piece_id='" . (int) $data['piece_id'] . "'";

				$result = mysql_query($query, $con);

				if (!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			}
		}
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarDiagnosticList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT diag.id as vehi_diag_id, repair_car_id, VIN, c_name, add_date_assurance, add_date_visitetech, 
		diag.car_id
			FROM tbl_repaircar_diagnostic diag
			JOIN tbl_add_car cr on cr.car_id = diag.car_id
			JOIN tbl_add_customer cus on cus.customer_id = cr.customer_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarDiagnosticList_2($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT tbl_repaircar_diagnostic.id as vehi_diag_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			tbl_repaircar_diagnostic.car_id
			from tbl_recep_vehi_repar
			inner join tbl_add_customer on tbl_recep_vehi_repar.customer_name = tbl_add_customer.customer_id
			inner join tbl_repaircar_diagnostic on tbl_repaircar_diagnostic.car_id = tbl_recep_vehi_repar.add_car_id
			-- inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			-- inner join tbl_add_boncmde bcmd on bcmd.devis_id = dev.devis_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByMecanicien_2($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, usr_type, 
		rvr.car_id, rvr.add_car_id, diag.id as vehi_diag_id
		FROM tbl_recep_vehi_repar rvr
		JOIN tbl_histo_attribution att ON att.car_id = rvr.add_car_id
		JOIN tbl_add_user us on att.mechanics_id = us.usr_id
		JOIN tbl_add_customer cus on rvr.customer_name = cus.customer_id 
		-- ici le diagnostic est lié à le reception à travers l'identifiant du véhicule
		-- et non par l'identifiant de la réception du véhicule
		left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
		WHERE us.usr_id = '" . (int) $mecanicien_id . "' LIMIT 10 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByMecanicien($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, usr_type, 
		rvr.car_id, rvr.add_car_id, diag.id as vehi_diag_id
		FROM tbl_recep_vehi_repar rvr
		inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id 
		join tbl_add_user us on us.usr_id = rvr.attribution_mecanicien
		-- left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
		left JOIN tbl_repaircar_diagnostic diag on diag.recep_car_id = rvr.car_id
		WHERE us.usr_id = '" . (int) $mecanicien_id . "' LIMIT 10 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get Liste de toutes le pièces jointes appartenant à un client
	*/
	public function getAllPjByCarRecep($con, $car_recep_id)
	{

		$query = "SELECT * 
		FROM tbl_recep_vehi_repar rvr
		JOIN tbl_add_car cr ON cr.car_id = rvr.add_car_id
		JOIN tbl_model mo ON cr.car_model = mo.model_id
		WHERE rvr.car_id = '" . (int) $car_recep_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	/*
	* @get Liste de toutes le pièces jointes appartenant à un client
	*/
	public function getAllPjByCar($con, $car_id)
	{

		$query = "SELECT * 
		FROM tbl_add_car cr
		JOIN tbl_model mo ON cr.car_model = mo.model_id
		WHERE car_id = '" . (int) $car_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	/*
	* @get Liste de toutes le pièces jointes appartenant à un client
	*/
	public function getAllPjByCustomer($con, $customer_id)
	{

		$query = "SELECT * 
		FROM tbl_add_customer c
		WHERE c.customer_id = '" . (int) $customer_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getAllRepairCarDevisFactureList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, facture_id, VIN, c_name, date_facture, cr.add_date_assurance, cr.add_date_visitetech, 
		rd.car_id
		FROM tbl_add_car cr
		JOIN tbl_repaircar_diagnostic rd on rd.car_id = cr.car_id	
		JOIN tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
		JOIN tbl_add_facture fac on fac.devis_id = dev.devis_id
		JOIN tbl_add_customer cus on cus.customer_id = cr.customer_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarDiagnosticDevisList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT rd.id as vehi_diag_id, devis_id, VIN, c_name, date_devis, cr.add_date_assurance, cr.add_date_visitetech, 
		rd.car_id
		FROM tbl_add_car cr
		JOIN tbl_repaircar_diagnostic rd on rd.car_id = cr.car_id	
		JOIN tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
		JOIN tbl_add_customer cus on cus.customer_id = cr.customer_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getCarListExpAssurVistech($con)
	{
		$data = array();

		$query = "SELECT ac.added_date, VIN, note, car_id, chasis_no, car_name, ac.image as car_image,c.c_name,c.image as customer_image,c.c_email,c.c_mobile,m.make_name,mo.model_name,ac.repair_car_id, ac.year
		,add_date_visitetech, add_date_assurance, add_date_assurance_fin, princ_tel, m.*, mo.*, VIN, c_name
		FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id 
		inner join tbl_make m on m.make_id = ac.car_make 
		inner join tbl_model mo on mo.model_id = ac.car_model 
		WHERE statut_assurance IS NULL OR statut_assurance != 'valide'
		OR statut_vistech IS NULL OR statut_vistech != 'valide'
		order by ac.car_id DESC";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function updateStatutExpVistechByCarId($con, $car_id, $statut_vistech)
	{
		$query = "UPDATE tbl_add_car
				SET `statut_vistech`='" . $statut_vistech . "'
				WHERE car_id='" . (int) $car_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function getStatutExpVistechByCarId($con, $car_id)
	{
		$query = "SELECT statut_vistech
		FROM tbl_add_car
		WHERE car_id = '" . (int) $car_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	public function updateStatutExpAssuranceByCarId($con, $car_id, $statut_assurance)
	{
		$query = "UPDATE tbl_add_car
				SET `statut_assurance`='" . $statut_assurance . "'
				WHERE car_id='" . (int) $car_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function getStatutExpAssuranceByCarId($con, $car_id)
	{
		$query = "SELECT statut_assurance
		FROM tbl_add_car
		WHERE car_id = '" . (int) $car_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByRecepId($con, $recepId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, rvr.car_id, sign_cli_depot, sign_recep_depot, sign_cli_sortie, sign_recep_sortie,
		add_car_id, diag.id as vehi_diag_id
			from tbl_recep_vehi_repar rvr
			-- left join tbl_add_mechanics me on (rvr.attribution_mecanicien = me.mechanics_id) 
			left join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
			join tbl_add_user usr on usr.usr_id = rvr.attrib_recep
			where attrib_recep ='" . (int) $recepId . "'
			ORDER BY rvr.car_id DESC 
			LIMIT 10 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllPersoSalaire_4($con, $numeroMoisDateJour)
	{
		$data = array();

		$query = "SELECT 
    pp.per_id,
    per_name,
    salaire_base,
    nb_heure_sup_periode,
    nb_jour_conge_paye,
    SUM(montant_avance) AS montant_avance_periode,
    nb_jour_abs_justifie,
	per_telephone
FROM
    (SELECT 
        per.per_id,
            per_name,
            per_sal AS salaire_base,
            SUM(nb_heure_sup) AS nb_heure_sup_periode,
            eca.nb_jour_conge_paye,
            eca.nb_jour_abs_justifie,
			per_telephone
    FROM
        tbl_add_pointage po
    LEFT JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel
    LEFT JOIN tbl_emplo_conge_abs eca ON eca.emplo_tel = per.per_telephone
    WHERE (mois_date_arrivee = '" . $numeroMoisDateJour . "' OR
		mois_date_depart = '" . $numeroMoisDateJour . "') OR eca.mois = '" . $numeroMoisDateJour . "'
    GROUP BY per.per_id) AS pointage_personnel
       LEFT JOIN
    tbl_avance_personnel pp ON pp.per_id = pointage_personnel.per_id
GROUP BY pp.per_id";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllPersoSalaire_3($con, $numeroMoisDateJour)
	{
		$data = array();

		$query = "SELECT per.per_id, per_name, per_sal as salaire_base,
		sum(nb_heure_sup) as nb_heure_sup_periode, eca.nb_jour_conge_paye, eca.nb_jour_abs_justifie,
		sum(montant_avance) as montant_avance_periode, sum(montant_prime) as montant_prime_periode
		FROM tbl_add_pointage po
		JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel 
		LEFT JOIN tbl_avance_personnel ap ON ap.per_id = per.per_id
        LEFT JOIN tbl_prime_personnel pp ON pp.per_id = per.per_id
		JOIN tbl_emplo_conge_abs eca ON eca.per_id = per.per_id
        WHERE mois_date_arrivee = '" . $numeroMoisDateJour . "' OR
		mois_date_depart = '" . $numeroMoisDateJour . "' AND eca.mois = '" . $numeroMoisDateJour . "'
        GROUP BY per_name, per.per_id;
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getFactureSimuFromDevisSimu($con, $devisId)
	{

		$query = "SELECT *
			FROM tbl_add_devis_simulation devsim
			JOIN tbl_add_facture_simulation facsim on facsim.devis_simulation_id = devsim.devis_id
			WHERE devsim.devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	/*
	* @get supplier info by id
	*/
	public function getInfoComptaBySupplierId($con, $supplier_id)
	{
		$data = array();

		$query = "SELECT gfc.*, s_name
		FROM tbl_ges_four_compta gfc
		JOIN tbl_add_supplier su ON su.supplier_id = gfc.supplier_id
		WHERE gfc.supplier_id = '" . (int) $supplier_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		return $data;
	}

	public function getSupplierInfoBySupplierIdAndBcmd($con, $supplier_id)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_add_supplier su
		JOIN tbl_add_boncmde bcde ON su.supplier_id = bcde.supplier_id
		WHERE su.supplier_id = '" . (int) $supplier_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		return $data;
	}

	public function getAllPersoPointage($con, $numeroMoisDateJour)
	{
		$data = array();

		$query = "SELECT po.*, per.per_name 
		FROM tbl_add_pointage po
		JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel
		WHERE mois_date_arrivee = '" . $numeroMoisDateJour . "' OR
		mois_date_arrivee = '" . $numeroMoisDateJour . "'
		ORDER BY date_arrivee DESC
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllSalaireDataByPerId($con, $per_id)
	{
		// Recherche dans la table 
		$queryGetSalInfoByPer = "SELECT * FROM tbl_salaire_personnel_list WHERE per_id='" . $per_id . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultSalInfoByPer = mysql_query($queryGetSalInfoByPer, $con);

		if (!$resultSalInfoByPer) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetSalInfoByPer;
			die($message);
		}

		$rowSalInfoByPer = mysql_fetch_assoc($resultSalInfoByPer);

		return $rowSalInfoByPer;
	}

	public function getAllPersoSalaire_2($con, $dateDebutPeriode, $dateFinPeriode)
	{
		$data = array();

		// Selection
		$query = "SELECT per.per_id, date_arrivee, per_name, per_sal as salaire_base, sum(montant_avance) as montant_avance_periode, 
		sum(montant_prime) as montant_prime_periode, sum(nb_heure_sup) as nb_heure_sup_periode,
		MONTH($dateDebutPeriode) as mois_remuneration, sum(absence), sum(conge_payer)
		FROM tbl_add_pointage po
		JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel 
		LEFT JOIN tbl_avance_personnel ap ON ap.per_id = per.per_id
        LEFT JOIN tbl_prime_personnel pp ON pp.per_id = per.per_id
		LEFT JOIN tbl_salaire_personnel_list spl ON spl.per_id = per.per_id
        WHERE date_arrivee BETWEEN '" . $dateDebutPeriode . "' AND '" . $dateFinPeriode . "' OR 
		date_depart BETWEEN '" . $dateDebutPeriode . "' AND '" . $dateFinPeriode . "'
        GROUP BY per_name, per.per_id;
		";

		// Exécution
		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Pour chaque enregistrement du jeu de résultat, on vérifie s'il y a une correspondance dans la table
		// tbl_salaire_personnel_list
		while ($row = mysql_fetch_assoc($result)) {

			$per_id = $row['per_id'];

			$rltSalaireDataByPerId = $this->getAllSalaireDataByPerId($con, $per_id);

			// S'il n'y a aucune correspondance, on fait une insertion dans la table
			// tbl_salaire_personnel_list
			if (empty($rltSalaireDataByPerId)) {

				// INSERTION - SELECTION
				$query = " INSERT INTO tbl_salaire_personnel_list (nom_prenom, salaire_brute, absence, hr_sup, prime, avance, conge_payer, salaire_net_a_payer, mois, per_id)
				SELECT per_name, per_sal as salaire_base, null, sum(nb_heure_sup) as nb_heure_sup_periode, sum(montant_prime) as montant_prime_periode,
				sum(montant_avance) as montant_avance_periode, null, null, MONTHNAME($dateDebutPeriode) as mois_remuneration, 
				per.per_id
				FROM tbl_add_pointage po
				JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel 
				LEFT JOIN tbl_avance_personnel ap ON ap.per_id = per.per_id
        		LEFT JOIN tbl_prime_personnel pp ON pp.per_id = per.per_id
				LEFT JOIN tbl_salaire_personnel_list spl ON spl.per_id = per.per_id
       			WHERE date_arrivee BETWEEN '" . $dateDebutPeriode . "' AND '" . $dateFinPeriode . "' OR 
				date_depart BETWEEN '" . $dateDebutPeriode . "' AND '" . $dateFinPeriode . "'
        		GROUP BY per_name, per.per_id;
				";

				// Exécution
				$result = mysql_query($query, $con);

				if (!$result) {
					// var_dump($data);
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			}
		}
		return $data;
	}



	public function updateAbsenceEmplo_2($con, $data)
	{
		// Recherche dans la table 
		$queryGetSalInfoByPer = "SELECT * FROM tbl_salaire_personnel_list WHERE per_id='" . $data['per_id'] . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultSalInfoByPer = mysql_query($queryGetSalInfoByPer, $con);

		if (!$resultSalInfoByPer) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryGetSalInfoByPer;
			die($message);
		}

		$rowSalInfoByPer = mysql_fetch_assoc($resultSalInfoByPer);

		// Si aucun enregistrement ne correspond à la recherche, on fait une insertion
		if (empty($rowSalInfoByPer)) {

			$query = " INSERT INTO tbl_salaire_personnel_list (nom_prenom, salaire_brute, absence, hr_sup, prime, conge_payer, salaire_net_a_payer, mois)
			SELECT per_name, per_sal as salaire_base, null, sum(nb_heure_sup) as nb_heure_sup_periode
			sum(montant_avance) as montant_avance_periode, 
			sum(montant_prime) as montant_prime_periode, , sum(conge_payer),
			MONTHNAME(CURDATE()), per.per_id
			FROM tbl_add_pointage po
			JOIN tbl_add_personnel per ON per.per_telephone = po.num_tel 
			LEFT JOIN tbl_avance_personnel ap ON ap.per_id = per.per_id
        	LEFT JOIN tbl_prime_personnel pp ON pp.per_id = per.per_id
			LEFT JOIN tbl_salaire_personnel_list spl ON spl.per_id = per.per_id
        	GROUP BY per_name, per.per_id;
			";

			// Exécution de la requête
			$result = mysql_query($query, $con);

			// Vérification du résultat de la requête et affichage d'un message en cas d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		} else { // Sinon on fait une mise à jour

			$query = "UPDATE tbl_salaire_personnel_list
				SET `absence`='" . $data['nb_jour_abs_employ'] . "'
				WHERE per_id='" . $data['per_id'] . "'";
			$result = mysql_query($query, $con);

			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function getAllPieceInfo($con)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_add_piece
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		return $data;
	}

	public function getAllAvancePrimeListByEmploye($con, $per_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT per_name FROM tbl_add_personnel per
		LEFT JOIN tbl_avance_personnel ap ON ap.per_id = per.per_id
        LEFT JOIN tbl_prime_personnel pp ON pp.per_id = per.per_id 
		WHERE per.per_id = '" . (int) $per_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getHistoPrimeListByPerId($con, $per_id)
	{

		// On initialise un array vide
		$data = array();

		$query = "SELECT * FROM tbl_prime_personnel WHERE per_id='" . $per_id . "' ORDER BY date_prime";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getHistoAvanceListByPerId($con, $per_id)
	{

		// On initialise un array vide
		$data = array();

		$query = "SELECT * FROM tbl_avance_personnel WHERE per_id='" . $per_id . "' ORDER BY date_avance";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getPieceCurrentStockByPieceId($con, $piece_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_piece_stock where piece_stock_id = '" . (int) $piece_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get Stock de pièces information by parts id
	*/
	public function getPieceStockInfoByPieceId($con, $piece_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_piece p where p.add_piece_id = '" . (int) $piece_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	public function updatePieceStock($con, $data, $currentQty)
	{
		if (!empty($data)) {

			// On récupère l'id de la pièce
			$piece_id = $data['piece_id'];

			// if ((int)$piece_id > 0) {

			// On récupère la quantité actuelle du stock de l'article
			$old_qty = $currentQty;

			// On récupère la nouvelle quantité de l'article
			$new_qty = $data['stock_article'];
			$stock_table = $this->getPieceStockStatusFromStockTable($con, $piece_id);

			// var_dump($old_qty);
			// var_dump($new_qty);
			// var_dump($stock_table);
			// die();

			if (!empty($stock_table)) {

				// On récupère la quantité actuelle du stock de l'article
				$current_qty = (int) $stock_table['stock_piece'];

				// On fait la différence entre la quantité actuelle du stock de l'article en BDD avec celle
				// de l'ancienne quantité pour l'annuler
				$current_qty = (int) $current_qty - (int) $old_qty;

				// On ajoute la nouvelle quantité saisie à partir du formulaire
				$current_qty = (int) $current_qty + (int) $new_qty;

				// On met à jour la quantié de l'article dans la table du stock des articles (pièces)
				//$this->saveUpdatePartsVirtualStockTable($con, $parts_id, $current_qty, 'u');
				$query = "UPDATE `tbl_piece_stock`
						SET `stock_piece`='" . (int) $current_qty . "' WHERE piece_stock_id = '" . (int) $piece_id . "'";

				// On exécute la requête
				$result = mysql_query($query, $con);

				if (!$result) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' . $query;
					die($message);
				}
			}
			// }
		}
	}

	public function updateQtyPieceStock($con, $data)
	{
		$result_parts = mysql_query("SELECT * FROM tbl_piece_stock where piece_stock_id=" . (int) $data['piece_rechange_id'], $con);
		if ($row_parts = mysql_fetch_array($result_parts)) {
			// Quantité de la pièce de rechange en stock
			$qty = $row_parts['stock_piece'];
			if ((int) $qty > 0) {
				// On fait la différence entre la quantité des pièces de rechange facturées avec celles en stock
				$qty = (int) $qty - (int) $data['qte_piece_rechange_facture'];
				mysql_query("UPDATE tbl_piece_stock SET stock_piece=" . (int) $qty . " WHERE piece_stock_id=" . (int) $data['piece_rechange_id'], $con);
			}
		}
	}

	public function getRecepVehiSignatureByRecepId($con, $recep_vehi_id)
	{
		$data = array();

		$query = "SELECT sign_cli_depot, sign_recep_depot, sign_cli_sortie, sign_recep_sortie
		FROM tbl_recep_vehi_repar
		WHERE car_id = '" . $recep_vehi_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getHistoEmplaListByCarId($con, $car_id)
	{
		$data = array();
		$result = mysql_query("SELECT id, emplacement_vehi, date_emplacement
		FROM tbl_histo_emplacement_vehicule 
		WHERE car_id = '" . (int) $car_id . "'
		ORDER BY id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getHistoDevisListByCarId($con, $car_id)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_histo_devis_vehicule
		WHERE car_id = '" . $car_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getComparPrixPieceRechangeMinByDiagId($con, $diagId)
	{
		$data = array();
		if (!empty($diagId)) {

			$query = "SELECT designation_piece_rechange, marque_piece_rechange, qte_piece_rechange, 
			MIN(prix_piece_rechange) AS prix_piece_rechange_min, s_name, repaircar_diagnostic_id, su.supplier_id
			FROM tbl_compar_prix_piece_rechange cppr
			JOIN tbl_add_supplier su ON su.supplier_id = cppr.supplier_id 
			-- JOIN tbl_repaircar_diagnostic rd ON rd.id = cppr.repaircar_dignostic_id
			-- JOIN tbl_add_car cr ON cr.car_id = rd.car_id
			GROUP BY designation_piece_rechange, qte_piece_rechange, repaircar_diagnostic_id
			HAVING repaircar_diagnostic_id = " . $diagId;

			$result = mysql_query($query, $con);

			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}

			// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
			// On la stocke dans un array associatif de données
			while ($row = mysql_fetch_assoc($result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	public function getNbHeureWorkByMois($con, $num_tel, $dateDebutMois, $dateFinMois)
	{

		// $data = array();
		$query = "SELECT sum(nb_heure_work) as nb_heure_work FROM tbl_add_pointage WHERE num_tel ='" . $num_tel . "'
		AND date_depart BETWEEN '" . $dateDebutMois . "' AND '" . $dateFinMois . "'";

		$result = mysql_query($query, $con);
		// while ($row = mysql_fetch_assoc($result)) {
		// 	$data[] = $row;
		// }

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	public function getAllRepairCarDevisFactureListByClient($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, facture_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis, confirm_facture
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "' LIMIT 10";

		$result = mysql_query($query, $con);

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDevisFactureListByCustId($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis, confirm_facture
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "'";

		$result = mysql_query($query, $con);

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDevisFactureListByCustId_2($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis, confirm_facture
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			left join tbl_add_facture fac on fac.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "'";

		$result = mysql_query($query, $con);

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByMechId($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, usr_type, 
		rvr.car_id, rvr.add_car_id, diag.id as vehi_diag_id
		FROM tbl_recep_vehi_repar rvr
		inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id 
		join tbl_add_user us on us.usr_id = rvr.attribution_mecanicien
		left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
		WHERE us.usr_id = '" . (int) $mecanicien_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car list
	*/
	public function getAllActiveCarList_2($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_buycar WHERE car_status = 0", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}


	public function saveUpdateUserInformation_2($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['usr_id'] == '0') {

				$query = "INSERT INTO tbl_add_user(usr_name, usr_email, usr_password, usr_type, usr_image) 
				values('$data[txtUserName]','$data[txtUserEmail]','$data[txtUserPassword]','$data[user_type]', '$image_url')";
				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_user` 
				SET `usr_name`='" . $data['txtUserName'] . "',`usr_email`='" . $data['txtUserEmail'] . "',
				`usr_password`='" . $data['txtUserPassword'] . "', `usr_type`='" . $data['user_type'] . "',
				`usr_image`='" . $image_url . "'
				 WHERE usr_id='" . $data['usr_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	/*
	* @save/update supplier information
	*/
	public function saveUpdateSupplierInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['supplier_id'] == '0') {

				$query = "INSERT INTO tbl_add_supplier(s_name,s_email,s_address,country_id,state_id,phone_number,fax_number,post_code,website_url,s_password,image) 
				values('$data[txtSName]','$data[txtSEmail]','$data[txtSAddress]',null,null,'$data[txtPhonenumber]',null,null,null,null,'$image_url')";

				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_supplier` 
				SET `s_name`='" . $data['txtSName'] . "',`s_email`='" . $data['txtSEmail'] . "',`s_address`='" . $data['txtSAddress'] . "',
				`phone_number`='" . $data['txtPhonenumber'] . "',`post_code`='" . $data['txtPostcode'] . "',`image`='" . $image_url . "' 
				WHERE supplier_id='" . $data['supplier_id'] . "'";

				$result = mysql_query($query, $con);
			}

			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function getAllMechanicsListByTitle($con)
	{
		$data = array();
		$result = mysql_query('SELECT * FROM tbl_add_user 
		WHERE usr_type IN ("mecanicien","electricien")', $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getStatutEtatVehiSortie($con, $car_recep_id)
	{
		$query = "SELECT status_sortie_vehicule
			from tbl_recep_vehi_repar
			where car_id ='" . (int) $car_recep_id . "' AND status_sortie_vehicule is null
			";

		// Exécution de la requête
		$result = mysql_query($query, $con);

		$row = mysql_fetch_array($result);

		return $row;
	}

	public function getFactureFourForReport($con, $filter)
	{
		$data = array();
		$sql = "SELECT * FROM tbl_ges_four_compta";

		if (!empty($filter['dateDebut']) && !empty($filter['dateFin'])) {
			$sql .= " WHERE ges_four_compta_date BETWEEN '" . $this->datepickerDateToMySqlDate($filter['dateDebut']) . "' AND '" . $this->datepickerDateToMySqlDate($filter['dateFin']) . "'";
		}

		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getRepairCarFacture($con, $facId)
	{
		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, fac.*, princ_tel, add_date_visitetech
			from tbl_add_facture fac
			INNER JOIN tbl_add_devis dev ON fac.devis_id = dev.devis_id
        	INNER JOIN tbl_repaircar_diagnostic rd ON dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_car cr on rd.car_id = cr.car_id
			inner join tbl_make ma on cr.car_make = ma.make_id 
			inner join tbl_model mo on cr.car_model = mo.model_id 
			inner join tbl_add_customer cus on cus.customer_id = cr.customer_id
			WHERE fac.facture_id ='" . (int) $facId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRepairCarSimuFacture($con, $facSimuId)
	{
		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, facsim.*, princ_tel, add_date_visitetech
			from tbl_add_facture_simulation facsim
			INNER JOIN tbl_add_devis_simulation devsim ON facsim.devis_simulation_id = devsim.devis_id
			join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			left join tbl_add_car cr on cr.VIN = adv.imma_vehi_client
            left join tbl_add_customer cus on cus.customer_id = cr.customer_id
			WHERE facsim.facture_id ='" . (int) $facSimuId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getFactureSimuForReport($con, $filter)
	{
		$data = array();
		$sql = "SELECT * FROM tbl_add_facture_simulation facsim
		INNER JOIN tbl_add_devis_simulation devsim ON facsim.devis_simulation_id = devsim.devis_id";

		if (!empty($filter['dateDebut']) && !empty($filter['dateFin'])) {
			$sql .= " WHERE facsim.date_facture BETWEEN '" . $this->datepickerDateToMySqlDate($filter['dateDebut']) . "' AND '" . $this->datepickerDateToMySqlDate($filter['dateFin']) . "'";
		}

		// if (!empty($filter['payment'])) {
		// 	if ($filter['payment'] == 'due') {
		// 		$sql .= " AND payment_due > 0";
		// 	} else {
		// 		$sql .= " AND payment_due = 0.00";
		// 	}
		// }
		//echo $sql;
		//die();
		//

		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getFactureClientForReport($con, $filter)
	{
		$data = array();
		$sql = "SELECT fac.* FROM tbl_add_facture fac 
		INNER JOIN tbl_add_devis dev ON fac.devis_id = dev.devis_id
        INNER JOIN tbl_repaircar_diagnostic rd ON dev.repaircar_diagnostic_id = rd.id
        INNER JOIN tbl_add_car cr ON rd.car_id = cr.car_id
        INNER JOIN tbl_make ma ON cr.car_make = ma.make_id
        INNER JOIN tbl_model mo ON cr.car_model = mo.model_id
        INNER JOIN tbl_add_customer cus ON cus.customer_id = cr.customer_id";

		if (!empty($filter['dateDebut']) && !empty($filter['dateFin'])) {
			$sql .= " WHERE fac.date_facture BETWEEN '" . $this->datepickerDateToMySqlDate($filter['dateDebut']) . "' AND '" . $this->datepickerDateToMySqlDate($filter['dateFin']) . "'";
		}
		// if (!empty($filter['payment'])) {
		// 	if ($filter['payment'] == 'due') {
		// 		$sql .= " AND payment_due > 0";
		// 	} else {
		// 		$sql .= " AND payment_due = 0.00";
		// 	}
		// }
		//echo $sql;
		//die();
		//

		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarList_2($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, rvr.car_id, attribution_mecanicien, sign_cli_depot, sign_recep_depot, sign_cli_sortie, sign_recep_sortie,
		add_car_id, diag.id as vehi_diag_id, status_attribution_vehicule, usr_name, status_diagnostic_vehicule
			from tbl_recep_vehi_repar rvr
			left join tbl_add_user usr on (rvr.attribution_mecanicien = usr.usr_id) 
			JOIN tbl_add_customer cus on rvr.customer_name = cus.customer_id
			left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function saveStockPiece($con, $data, $image_url)
	{
		$queryInsertPieceStock = "INSERT INTO tbl_piece_stock(code_piece, lib_piece, type_piece, famille_piece, prix_base_ttc, stock_piece, image_url)
                values('$data[code_piece]','$data[lib_piece]','$data[type_piece]','$data[famille_piece]','$data[prix_base_ttc]','$data[stock_piece]',
				'$image_url'
				)";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertPieceStock = mysql_query($queryInsertPieceStock, $con);

		if (!$resultInsertPieceStock) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $queryInsertPieceStock;
			die($message);
		}
	}

	public function getAllPieceData_2($con)
	{
		$data = array();

		// $query = "SELECT image_url, code_piece, lib_piece, type_piece, famille_piece, prix_base_ttc , count(*) as stock_piece
		// FROM tbl_add_piece 
		// WHERE famille_piece IN ('huile','electrique','mecanique','accessoire')
		// GROUP BY famille_piece, lib_piece
		// ";

		$query = "SELECT image_url, code_piece, lib_piece, type_piece, famille_piece, prix_base_ttc , count(*) as stock_piece
		FROM tbl_add_piece
		GROUP BY lib_piece
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		// if ($row = mysql_fetch_assoc($result)) {
		// 	$data = $row;
		// }

		return $data;
	}

	public function getAllPieceData($con)
	{
		$data = array();

		// $query = "SELECT image_url, code_piece, lib_piece, type_piece, famille_piece, prix_base_ttc , count(*) as stock_piece
		// FROM tbl_add_piece 
		// WHERE famille_piece IN ('huile','electrique','mecanique','accessoire')
		// GROUP BY famille_piece, lib_piece
		// ";

		$query = "SELECT *
		FROM tbl_piece_stock
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		// if ($row = mysql_fetch_assoc($result)) {
		// 	$data = $row;
		// }

		return $data;
	}

	public function saveUpdatePieceInfo($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['piece_id'] == '0') {

				$query = "INSERT INTO tbl_add_piece(code_piece, code_barre_piece, lib_piece, type_piece, 
				famille_piece, dernier_prix_achat, montant_frais, prix_revient, coefficient, prix_base_ht,
				prix_base_ttc, image_url)

				values('$data[code_piece]','$data[code_barre_piece]','$data[lib_piece]','$data[type_piece]','$data[famille_piece]',
				'$data[last_pa]','$data[mont_frais]','$data[prix_revient]','$data[coeff]','$data[prix_base_ht]','$data[prix_base_ttc]',
				'$image_url'
				)";
				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_piece` 
				SET `code_piece`='" . $data['code_piece'] . "',`code_barre_piece`='" . $data['code_barre_piece'] . "',
				`lib_piece`='" . $data['lib_piece'] . "',`type_piece`='" . $data['type_piece'] . "',
				`famille_piece`='" . $data['famille_piece'] . "',`dernier_prix_achat`='" . $data['last_pa'] . "',
				`montant_frais`='" . $data['mont_frais'] . "',`prix_revient`='" . $data['prix_revient'] . "',
				`coefficient`='" . $data['coeff'] . "',`prix_base_ht`='" . $data['prix_base_ht'] . "',
				`prix_base_ttc`='" . $data['prix_base_ttc'] . "',`image_url`='" . $image_url . "'
				WHERE add_piece_id='" . $data['piece_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function getPieceStockDataByCodePiece($con, $code_piece)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_piece_stock
		WHERE code_piece = '" . $code_piece . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// while ($row = mysql_fetch_assoc($result)) {
		// 	$data[] = $row;
		// }

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}

		return $data;
	}


	/*
	* @get specific parts exist to stock maintain table
	*/
	public function getPiecesStockStatusFromStockTable($con, $parts_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_piece_stock WHERE parts_id=" . (int) $parts_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get supplier info by id
	*/
	public function getSupplierInfoBySupplierId($con, $supplier_id)
	{
		$data = array();

		$query = "SELECT * FROM tbl_add_supplier su
		WHERE su.supplier_id = '" . (int) $supplier_id . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}

		return $data;
	}

	public function getAllPieceStockData($con)
	{
		$data = array();

		$query = "SELECT *
		FROM tbl_piece_stock
		";

		$result = mysql_query($query, $con);

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}

		return $data;
	}

	public function getAllPersoData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_personnel", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarSimuDevisList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT devsim.devis_id, adv.*
			from tbl_add_devis_simulation devsim
			left join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarSimuDevisFactureList($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT facture_id, devsim.devis_id, adv.*
			from tbl_add_devis_simulation devsim
			inner join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			inner join tbl_add_facture_simulation fac on fac.devis_simulation_id = devsim.devis_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function ajaxPieceListByPieceName($con, $post)
	{
		$data = array();
		$result = mysql_query("SELECT * from tbl_piece_stock where lib_piece LIKE '%" . trim($post['filter_name']) . "%'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function updateQtyPartsStock($con, $data)
	{
		$result_parts = mysql_query("SELECT * FROM tbl_parts_stock_manage where parts_id=" . (int) $data['piece_rechange_id'], $con);
		if ($row_parts = mysql_fetch_array($result_parts)) {
			// Quantité de la pièce de rechange en stock
			$qty = $row_parts['quantity'];
			if ((int) $qty > 0) {
				// On fait la différence entre la quantité des pièces de rechange facturées avec celles en stock
				$qty = (int) $qty - (int) $data['qte_piece_rechange_facture'];
				mysql_query("UPDATE tbl_parts_stock_manage SET quantity=" . (int) $qty . " WHERE parts_id=" . (int) $data['piece_rechange_id'], $con);
			}
		}
	}

	public function getRepairCarSimuDevis($con, $devisSimuId)
	{
		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, devsim.*, princ_tel, add_date_visitetech
			from tbl_add_devis_simulation devsim
			join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			left join tbl_add_car cr on cr.VIN = adv.imma_vehi_client
            left join tbl_add_customer cus on cus.customer_id = cr.customer_id
			-- inner join tbl_make ma on cr.car_make = ma.make_id 
			-- inner join tbl_model mo on cr.car_model = mo.model_id 
			WHERE devis_id ='" . (int) $devisSimuId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRepairCarDevisFactureSimuInfo($con, $devisId)
	{

		$query = "SELECT distinct car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, devsim.*, facsim.*, princ_tel, add_date_visitetech, ma.*, mo.*, adv.*

			from tbl_add_devis_simulation devsim
			join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			left join tbl_add_car cr on cr.VIN = adv.imma_vehi_client
            left join tbl_add_customer cus on cus.customer_id = cr.customer_id
			left join tbl_make ma on cr.car_make = ma.make_id 
			left join tbl_model mo on cr.car_model = mo.model_id
			inner join tbl_add_facture_simulation facsim on facsim.devis_simulation_id = devsim.devis_id
			WHERE devsim.devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	public function getRepairCarDevisSimuInfo($con, $devisId)
	{

		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, devsim.*, princ_tel, add_date_visitetech, ma.*, mo.*, adv.*
			from tbl_add_devis_simulation devsim
			join tbl_attri_devis_vehicule adv on adv.devis_simulation_id = devsim.devis_id
			left join tbl_add_car cr on cr.VIN = adv.imma_vehi_client
            left join tbl_add_customer cus on cus.customer_id = cr.customer_id
			left join tbl_make ma on cr.car_make = ma.make_id 
			left join tbl_model mo on cr.car_model = mo.model_id
			WHERE devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getBoncmdeInfo($con, $bcdeId)
	{

		$query = "SELECT bcde.*, s_name
			from tbl_add_boncmde bcde
			inner join tbl_add_supplier su ON su.supplier_id = bcde.supplier_id
			WHERE boncmde_id = " . (int) $bcdeId;

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	public function getVehiDataByImmaVehi($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		if (isset($imma_vehi) && !empty($imma_vehi)) {

			// exécution de la réquête

			$query = "SELECT * from tbl_add_car WHERE vin = '" . (string) $imma_vehi . "'";

			// On stocke le résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRepairCarDevisInfo($con, $devisSimuId)
	{

		$query = "SELECT *
			from tbl_add_devis_simulation
			WHERE devis_id ='" . (int) $devisSimuId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getDroitMenuComptaInfo($con, $compta_droit_acces)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role
			WHERE role_name = '" . $compta_droit_acces . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getDroitMenuClientInfo($con, $client_droit_acces)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role
			WHERE role_name = '" . $client_droit_acces . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getDroitMenuRecepInfo($con, $recep_droit_acces)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role
			WHERE role_name = '" . $recep_droit_acces . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getDroitMenuMechElecInfo($con, $mech_elec_droit_acces)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role
			WHERE role_name = '" . $mech_elec_droit_acces . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getAllDroitMenuRoleInfo($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getDroitMenuRoleInfo($con, $mech_elec_droit_acces, $recep_droit_acces, $client_droit_acces, $compta_droit_acces)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT *
			from tbl_droit_menu_role
			WHERE role_name IN ('" . $mech_elec_droit_acces . "','" . $recep_droit_acces . "','" . $client_droit_acces . "','" . $compta_droit_acces . "')";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getRoleMecanoEletroInfoByRoleName($con, $supplier_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_supplier where supplier_id=" . (int) $supplier_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getPersonnelInfoByPersonnelId($con, $perso_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_personnel where per_id=" . (int) $perso_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getUserInfoByUserId($con, $user_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_user where usr_id=" . (int) $user_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getAllBonCmdeData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_boncmde", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function saveUpdatePersonnelInformation($con, $data)
	{
		if (!empty($data)) {
			if ($data['personnel_id'] == '0') {

				$query = "INSERT INTO tbl_add_personnel(per_name, per_telephone, per_fonction, per_date_naiss, per_lieu_naiss,
				per_lieu_ori, per_num_cni, per_etat_civile, per_nom_conjoint, per_adrs, per_nom_pere, per_nom_mere, perso_data,
				per_sal, per_type_contrat, per_mat, per_date_emb
				)

				values('$data[txtPersName]','$data[telPers]','$data[foncPers]','$data[dateNaisPers]','$data[lieuNaisPers]',
				'$data[lieuOriPers]','$data[numcniPers]','$data[etatcivilePers]','$data[nomconjointPers]','$data[adrsPers]',
				'$data[nomperePers]','$data[nomerePers]','$data[perso_data]', '$data[salPers]', '$data[typctrPers]', '$data[matPers]',
				'$data[datembPers]'
				)";
				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_personnel` 
				SET `per_name`='" . $data['txtPersName'] . "',`per_telephone`='" . $data['telPers'] . "',
				`per_fonction`='" . $data['foncPers'] . "',
				`per_lieu_naiss`='" . $data['lieuNaisPers'] . "', `per_date_naiss`='" . $data['dateNaisPers'] . "',
				`per_lieu_ori`='" . $data['lieuOriPers'] . "', `per_num_cni`='" . $data['numcniPers'] . "',
				`per_etat_civile`='" . $data['etatcivilePers'] . "', `per_nom_conjoint`='" . $data['nomconjointPers'] . "',
				`per_nom_conjoint`='" . $data['nomconjointPers'] . "', `per_adrs`='" . $data['adrsPers'] . "',
				`per_nom_pere`='" . $data['nomperePers'] . "', `per_nom_mere`='" . $data['nomerePers'] . "',
				`per_sal`='" . $data['salPers'] . "', `per_type_contrat`='" . $data['typctrPers'] . "',
				`per_mat`='" . $data['matPers'] . "', `per_date_emb`='" . $data['datembPers'] . "'
				WHERE per_id='" . $data['personnel_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function saveUpdateBonCmdeInfo_2($con, $data, $boncmde_data)
	{
		if (!empty($data)) {
			if ($data['boncmde_id'] == '0') {

				$boncmde_date_creation = date('d/m/Y');

				$query = "INSERT INTO tbl_add_boncmde(boncmde_num, boncmde_designation, boncmde_qte, boncmde_pu_ht, boncmde_total_ht, supplier_id, boncmde_date_creation, bon_cmde_type, car_id, boncmde_data)

				values('$data[numboncmde]','$data[codedesiboncmde]','$data[qteboncmde]',null,null,
				'$data[four]','$boncmde_date_creation','$data[bon_cmde_type]','$data[car_id]','$boncmde_data')";
				$result = mysql_query($query, $con);
			} else {

				$query = "UPDATE `tbl_add_boncmde` 
				SET `boncmde_num`='" . $data['numboncmde'] . "',`boncmde_designation`='" . $data['codedesiboncmde'] . "',
				`boncmde_qte`='" . $data['qteboncmde'] . "',`boncmde_pu_ht`='" . $data['prixhtboncmde'] . "',
				`boncmde_total_ht`='" . $data['tothtboncmde'] . "'
				WHERE per_id='" . $data['personnel_id'] . "'";
				$result = mysql_query($query, $con);
			}

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	public function getAllUserData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_user", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getCarMakeDataByMakeName($con, $make_name)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_make where make_name LIKE '" . $make_name . "'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data = $row['make_name'];
		}
		return $data;
	}

	public function getAllRepairCarDiagnosticDevisListByMechId($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT rd.id as vehi_diag_id, devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			WHERE attribution_mecanicien = " . (int) $mecanicien_id;

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByMecanicien_3($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, title, 
		rvr.car_id, rvr.add_car_id, diag.id as vehi_diag_id
		FROM tbl_recep_vehi_repar rvr
		inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id 
		inner join tbl_add_mechanics mec on mec.mechanics_id = rvr.attribution_mecanicien
		inner join tbl_mechanics_designation mecdes on mecdes.designation_id = mec.designation_id
		left join tbl_repaircar_diagnostic diag on diag.car_id = rvr.add_car_id
		WHERE attribution_mecanicien = '" . (int) $mecanicien_id . "' LIMIT 10 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getRepairCarDiagnosticFactureInfoByDiagId($con, $diagId, $devisId)
	{

		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, nom_client, fac.*, ma.*, mo.*, add_date_visitetech, princ_tel
			from tbl_repaircar_diagnostic rd
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			inner join tbl_add_car cr on rd.car_id = cr.car_id
			inner join tbl_make ma on cr.car_make = ma.make_id 
			inner join tbl_model mo on cr.car_model = mo.model_id 
			inner join tbl_add_customer cus on cus.customer_id = cr.customer_id
			WHERE repaircar_diagnostic_id ='" . (int) $diagId . "' AND dev.devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRepairCarDiagnosticDevisInfoByDiagId($con, $diagId, $devisId)
	{

		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile,
		c_address, VIN, add_date_mise_circu, dev.*, nom_client, princ_tel, add_date_visitetech, ma.*, mo.*
			from tbl_repaircar_diagnostic rd
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_car cr on rd.car_id = cr.car_id
			inner join tbl_make ma on cr.car_make = ma.make_id 
			inner join tbl_model mo on cr.car_model = mo.model_id 
			inner join tbl_add_customer cus on cus.customer_id = cr.customer_id
			WHERE repaircar_diagnostic_id ='" . (int) $diagId . "' AND devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRepairCarDevisFactureInfoByDiagId($con, $diagId, $devisId)
	{

		$query = "SELECT car_make, car_model, chasis_no, devis_data, c_name, c_email, c_mobile, princ_tel,
		c_address, VIN, add_date_mise_circu, fac.*, ma.*, mo.*, add_date_visitetech
			from tbl_repaircar_diagnostic rd
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			inner join tbl_add_car cr on rd.car_id = cr.car_id
			inner join tbl_make ma on cr.car_make = ma.make_id 
			inner join tbl_model mo on cr.car_model = mo.model_id 
			inner join tbl_add_customer cus on cus.customer_id = cr.customer_id
			WHERE repaircar_diagnostic_id ='" . (int) $diagId . "' AND dev.devis_id ='" . (int) $devisId . "'";

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);

		return $row;
	}

	/*
	* @email function
	*/
	public function sendCustomerEmailNotification($con, $car_id, $progress, $invoice_id)
	{
		if ($data = $this->getCustomerAndCarDetailsByCarId($con, $car_id)) {
			$this->saveCustomerRemindDetails($con, $invoice_id, $car_id, $data['customer_id'], $progress);
			if ($site_config_data = $this->getWebsiteSettingsInformation($con)) {
				$from = $site_config_data['email'];
				$to = $data['c_email'];
				$subject = 'Voiture de réparation Progress Notification';
				$headers = "From: " . strip_tags($from) . "\r\n";
				$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				$message = '<html><body>';
				$message .= '<div style="border-bottom:solid 1px #666;"><img src="' . WEB_URL . 'img/logo.png"></div>';
				$message .= '<h4>Your Car Repair Notification</h4>';
				$message .= '<div>Dear ' . $data['c_name'] . ',</div>';
				$message .= '<div>Your car ' . $data['car_name'] . ', registration no ' . $data['car_reg_no'] . ', progress is ' . $progress . '%. We will complete your job soon and send you final notification email thanks.</div>';
				$message .= '</body></html>';
				mail($to, $subject, $message, $headers);
			}
		}
	}

	/*
	* @contact us reply email
	*/
	public function sendCustomerFactureEmail($con, $to, $subject, $details, $facture_id, $date_facture)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array(
			'logo' => WEB_URL . 'img/logo.png',
			'site_url' => WEB_URL,
			'site_name' => $site_config_data['site_name'],
			'subject' => $subject,
			'message' => $details,
			'date_facture' => $date_facture,
			'facture_id' => $facture_id
		);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_facture_validation.html', $variables);
		$result = mail($to, $subject, $message, $headers);
		return $result;
	}

	public function getFactureInfoByDiagId($con, $diagId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT diag.*, fac.*, dev.*
			from tbl_add_devis dev
			inner join tbl_repaircar_diagnostic diag on diag.id = dev.repaircar_diagnostic_id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			WHERE repaircar_diagnostic_id = " . (int) $diagId;

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDevisBcmdeListByClient($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			-- inner join tbl_add_boncmde bcmd on bcmd.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "' LIMIT 10";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getRepairCarDiagnosticDevisByClient($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			WHERE cus.customer_id ='" . (int) $cusId . "' AND confirm_devis = 1 LIMIT 10 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarDevisFactureList_2($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, facture_id
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getDevisInfoByDiagId($con, $diagId)
	{
		$query = "SELECT dev.*, diag.*
			from tbl_add_devis dev
			left join tbl_repaircar_diagnostic diag on diag.id = dev.repaircar_diagnostic_id
			-- left join tbl_add_boncmde bcmd on bcmd.devis_id = dev.devis_id
			WHERE repaircar_diagnostic_id = " . (int) $diagId;

		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getAllRepairCarFactureListByCustId($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis, fac.*
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			-- inner join tbl_add_boncmde bcmd on bcmd.devis_id = dev.devis_id
			inner join tbl_add_facture fac on fac.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDevisBcmdeListByCustId($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, dev.devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			-- inner join tbl_add_boncmde bcmd on bcmd.devis_id = dev.devis_id
			WHERE cus.customer_id ='" . (int) $cusId . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDiagnosticDevisListByCustId($con, $cusId)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT rd.id as vehi_diag_id, devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id, dev.confirm_devis
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			WHERE cus.customer_id ='" . (int) $cusId . "' AND confirm_devis = 1 ";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function sendMechBoncmdeEmail($con, $to, $subject, $details)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array(
			'logo' => WEB_URL . 'img/logo.png',
			'site_url' => WEB_URL,
			'site_name' => $site_config_data['site_name'],
			'subject' => $subject,
			'message' => $details,
			'today_date' => date('d/m/Y'),
			// 'devis_id' => $devis_id
		);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_boncmde_validation.html', $variables);
		$result = mail($to, $subject, $message, $headers);
		return $result;
	}

	public function sendAdminBoncmdeEmail($con, $to, $subject, $details)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array(
			'logo' => WEB_URL . 'img/logo.png',
			'site_url' => WEB_URL,
			'site_name' => $site_config_data['site_name'],
			'subject' => $subject,
			'message' => $details,
			'today_date' => date('d/m/Y'),
			// 'devis_id' => $devis_id
		);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_boncmde_validation.html', $variables);
		$result = mail($to, $subject, $message, $headers);
		return $result;
	}

	public function getBonCmdeByDevisId($con, $devis_id)
	{
		$query = "SELECT bc.*, m_email
		FROM tbl_add_boncmde bc
		inner join tbl_add_devis dev on dev.devis_id = bc.devis_id
		inner join tbl_repaircar_diagnostic diag on diag.id = dev.repaircar_diagnostic_id 
		inner join tbl_add_mechanics mec on mec.mechanics_id = diag.mech_id
		-- left join tbl_add_mechanics mec on mec.mechanics_id = diag.mech_id
		where dev.devis_id = '" . (int) $devis_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		$row = mysql_fetch_assoc($result);
		return $row;
	}

	/*
	* @contact us reply email
	*/
	public function sendCustomerDevisEmail($con, $to, $subject, $details, $devis_id)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array(
			'logo' => WEB_URL . 'img/logo.png',
			'site_url' => WEB_URL,
			'site_name' => $site_config_data['site_name'],
			'subject' => $subject,
			'message' => $details,
			'today_date' => date('d/m/Y'),
			'devis_id' => $devis_id
		);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_devis_validation.html', $variables);
		$result = mail($to, $subject, $message, $headers);
		return $result;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarDiagnosticListByMechId($con, $mecanicien_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT tbl_repaircar_diagnostic.id as vehi_diag_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			tbl_repaircar_diagnostic.car_id
			from tbl_recep_vehi_repar
			inner join tbl_add_customer on tbl_recep_vehi_repar.customer_name = tbl_add_customer.customer_id
			inner join tbl_repaircar_diagnostic on tbl_repaircar_diagnostic.car_id = tbl_recep_vehi_repar.add_car_id
			WHERE attribution_mecanicien = " . (int) $mecanicien_id;

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all mechanics information
	*/
	public function getAllMechanicsListByTitle_2($con)
	{
		$data = array();
		$result = mysql_query('SELECT *,d.title FROM tbl_add_mechanics m 
		LEFT JOIN tbl_mechanics_designation d ON d.designation_id = m.designation_id 
		WHERE d.title IN ("Chef mecanicien","Chef electricien")', $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllRepairCarDiagnosticDevisList_2($con)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		// On récupère les infos du devis de réparation d'un véhicule en les regroupant par 
		// identifiants de diagnostic
		$query = "SELECT rd.id as vehi_diag_id, devis_id, repair_car_id, num_matricule, c_name, add_date_recep_vehi, add_date_assurance, add_date_visitetech, 
			rd.car_id
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id
			inner join tbl_repaircar_diagnostic rd on rd.car_id = rvr.add_car_id
			inner join tbl_add_devis dev on dev.repaircar_diagnostic_id = rd.id
			";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getComparPrixPieceRechangeInfoByDiagId($con, $diagId)
	{
		$data = array();
		if (!empty($diagId)) {
			$query = "SELECT s_name, cppr.*
			from tbl_compar_prix_piece_rechange cppr
			inner join tbl_add_supplier su on su.supplier_id = cppr.supplier_id
			WHERE repaircar_diagnostic_id = " . (int) $diagId;

			$result = mysql_query($query, $con);

			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}

			// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
			// On la stocke dans un array associatif de données
			while ($row = mysql_fetch_assoc($result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	/*
	* @get supplier info by id
	*/
	public function getAllSuppliers($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_supplier", $con);
		// Exécution et stockage du résultat de la requête

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getRepairCarDiagnosticInfoByDiagId($con, $diagId)
	{
		$data = array();
		if (!empty($diagId)) {
			$query = "SELECT tbl_repaircar_diagnostic.id as vehi_diag_id, rvr.repair_car_id, num_matricule, c_name, add_date_recep_vehi, 
			cr.add_date_assurance, cr.add_date_visitetech, tbl_repaircar_diagnostic.car_id, ma.*, mo.*,
			tbl_repaircar_diagnostic.*, cr.car_make, cr.car_model
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_customer on rvr.customer_name = tbl_add_customer.customer_id
			inner join tbl_repaircar_diagnostic on tbl_repaircar_diagnostic.car_id = rvr.add_car_id
			join tbl_add_car cr on cr.car_id = rvr.add_car_id
			inner join tbl_make ma on rvr.car_make = ma.make_id 
			inner join tbl_model mo on rvr.car_model = mo.model_id 
			WHERE tbl_repaircar_diagnostic.id = " . (int) $diagId;
			$result = mysql_query($query, $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			} else {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
		return $data;
	}

	public function getRecepRepairCarInfoDiagnostic($con, $addCarId, $carId)
	{
		$data = array();
		if (!empty($carId)) {
			$query = "SELECT c_name, tel_wa, ac.*
			from tbl_recep_vehi_repar rvr
			inner join tbl_add_car ac on ac.car_id = rvr.add_car_id
			inner join tbl_add_customer cus on rvr.customer_name = cus.customer_id 
			-- inner join tbl_make ma on rvr.car_make = ma.make_id 
			-- inner join tbl_model mo on rvr.car_model = mo.model_id 
			WHERE rvr.add_car_id ='" . (int) $addCarId . "' AND rvr.car_id ='" . (int) $carId . "'";
			$result = mysql_query($query, $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			} else {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getHistoAssurListByCarId($con, $car_id)
	{

		// On initialise un array vide
		$data = array();

		// Requête pour vérifier que la donnée à enregistrer n'existe pas déja dans la table
		$query = "SELECT * FROM tbl_histo_assurance WHERE car_id='" . $car_id . "' ORDER BY assurance_id DESC";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getHistoVisetechListByCarId($con, $car_id)
	{

		// On initialise un array vide
		$data = array();

		// Requête pour vérifier que la donnée à enregistrer n'existe pas déja dans la table
		$query = "SELECT * FROM tbl_histo_visite_technique WHERE car_id='" . $car_id . "' ORDER BY visitetech_id DESC";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @save or update model settings
	*/
	public function saveUpdatePrixPrestationService($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_prix_prestation_service SET presta_serv_id = '" . $data['ddlPresta'] . "', prix_presta_serv = '" . trim($data['txtPrixPrestaServ']) . "' WHERE prix_presta_serv_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_prix_prestation_service(prix_presta_serv, presta_serv_id) values('$data[txtPrixPrestaServ]','$data[ddlPresta]')", $con);
			}
		}
	}

	/*
	* @delete make data
	*/
	public function deletePrixPrestationData($con, $prix_presta_serv_id)
	{
		mysql_query("DELETE from tbl_prix_prestation_service where prix_presta_serv_id = " . (int) $prix_presta_serv_id, $con);
	}

	/*
	* @get car make data by make id
	*/
	public function getPrixPrestationDataByPrixPrestationId($con, $prix_presta_serv_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_prix_prestation_service where prix_presta_serv_id = '" . (int) $prix_presta_serv_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @delete make data
	*/
	public function deleteAssuranceData($con, $assur_vehi_id)
	{
		mysql_query("DELETE from tbl_assurance_vehicule where assur_vehi_id = " . (int) $assur_vehi_id, $con);
	}

	/*
	* @get car make data by make id
	*/
	public function getPrestationDataByPrestationId($con, $presta_serv_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_prestation_service where presta_serv_id = '" . (int) $presta_serv_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getAssuranceDataByAssuranceId($con, $assur_vehi_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_assurance_vehicule where assur_vehi_id = '" . (int) $assur_vehi_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get all model list
	*/
	public function get_all_prix_prestation_list($con)
	{
		$model = array();
		$result = mysql_query("SELECT * FROM tbl_prix_prestation_service pps 
		INNER JOIN tbl_prestation_service ps ON pps.presta_serv_id = ps.presta_serv_id order by ps.presta_serv_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$model[] = array(
				'prix_presta_serv_id'	=> $row['prix_presta_serv_id'],
				'presta_serv_id'		=> $row['presta_serv_id'],
				'prix_presta_serv'	=> $row['prix_presta_serv'],
				'presta_serv_name'		=> $row['presta_serv_name']
			);
		}
		return $model;
	}

	/*
	* @get all make list
	*/
	public function get_all_prestation_list($con)
	{
		$prestation_services = array();
		$result = mysql_query("SELECT * FROM tbl_prestation_service order by presta_serv_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$prestation_services[] = array(
				'presta_serv_id'		=> $row['presta_serv_id'],
				'presta_serv_name'		=> $row['presta_serv_name']
			);
		}
		return $prestation_services;
	}

	public function get_all_assurance_vehicule_list($con)
	{
		$assurances_vehicule = array();
		$result = mysql_query("SELECT * FROM tbl_assurance_vehicule order by assur_vehi_libelle ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$assurances_vehicule[] = array(
				'assur_vehi_id'		=> $row['assur_vehi_id'],
				'assur_vehi_libelle'		=> $row['assur_vehi_libelle']
			);
		}
		return $assurances_vehicule;
	}

	/*
	* @save or update make settings
	*/
	public function saveUpdateAssuranceVehicule($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_assurance_vehicule SET assur_vehi_libelle = '" . trim($data['txtAssurVehiLib']) . "' WHERE assur_vehi_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_assurance_vehicule(assur_vehi_libelle) values('$data[txtAssurVehiLib]')", $con);
			}
		}
	}

	/*
	* @save or update make settings
	*/
	public function saveUpdatePrestationService($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_prestation_service SET presta_serv_name = '" . trim($data['txtPrestaServName']) . "' WHERE presta_serv_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_prestation_service(presta_serv_name) values('$data[txtPrestaServName]')", $con);
			}
		}
	}

	/*
	* @get all model list
	*/
	public function get_model_make_list_by_make($con, $make_id, $model_name)
	{
		// Liste des modèles de voiture videvide
		$model = array();

		// Requête pour récupérer la liste des modèles de véhicule en fonction de la marque
		$query = "SELECT ma.*, mo.model_id, mo.model_name FROM tbl_model mo 
		INNER JOIN tbl_make ma ON mo.make_id = ma.make_id 
		WHERE ma.make_id='" . $make_id . "' AND mo.model_name='" . $model_name . "'
		order by ma.make_name ASC";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$model[] = $row;
		}
		return $model;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepCarListByCustomer($con, $customer_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();

		$query = "SELECT * 
		FROM tbl_recep_vehi_repar rvr
		inner join tbl_add_customer c on rvr.customer_name = c.customer_id 
		WHERE c.customer_id = '" . (int) $customer_id . "'";

		// Exécution et stockage du résultat de la requête
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function updateDateSignRecepDepot($con, $dateSignRecepDepot, $car_id)
	{
		// Enregistrement du nom du fichier image de la signature du client en base de données
		$query = "UPDATE tbl_recep_vehi_repar SET date_sign_recep_depot='" . $dateSignRecepDepot . "' WHERE car_id='" . (int) $car_id . "'";

		// On teste le résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function updateDateSignRecepSortie($con, $dateSignRecepSortie, $car_id)
	{
		// Enregistrement du nom du fichier image de la signature du client en base de données
		$query = "UPDATE tbl_recep_vehi_repar SET date_sign_recep_sortie='" . $dateSignRecepSortie . "' WHERE car_id='" . (int) $car_id . "'";

		// On teste le résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function updateDateSignCliDepot($con, $dateSignClientDepot, $car_id)
	{
		// Enregistrement du nom du fichier image de la signature du client en base de données
		$query = "UPDATE tbl_recep_vehi_repar SET date_sign_cli_depot='" . $dateSignClientDepot . "' WHERE car_id='" . (int) $car_id . "'";

		// On teste le résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function updateDateSignCliSortie($con, $dateSignClientSortie, $car_id)
	{
		// Enregistrement du nom du fichier image de la signature du client en base de données
		$query = "UPDATE tbl_recep_vehi_repar SET date_sign_cli_sortie='" . $dateSignClientSortie . "' WHERE car_id='" . (int) $car_id . "'";

		// On teste le résultat de la requête
		$result = mysql_query($query, $con);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	public function saveHistoEmplVehi($con, $dateSignClientDepot, $emplacement_vehi, $immavehi, $car_id)
	{

		// Requête d'insertion dans la table d'historisation des emplacements des véhicules 
		// Lors de la signature du client au dépot du véhicule
		// Le but de cette table est de savoir quand la voiture était au garage et quand la voiture
		// était hors du garage
		$query = "INSERT INTO tbl_histo_emplacement_vehicule (date_emplacement, emplacement_vehi, immatriculation_vehi, car_id) 
		VALUES('$dateSignClientDepot','$emplacement_vehi', '$immavehi', '$car_id')";

		// Exécution et stockage du résultat de la requête sous forme de ressource
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	/*
	* @get all car model list
	*/
	public function getHistoAssurVehi($con, $dateDebutAssurance, $dateFinAssurance, $car_id)
	{

		// On initialise un array vide
		$data = array();

		// Requête pour vérifier que la donnée à enregistrer n'existe pas déja dans la table
		$query = "SELECT * FROM tbl_histo_assurance WHERE date_debut_assurance='" . $dateDebutAssurance . "' AND 
		date_fin_assurance='" . $dateFinAssurance . "' AND car_id='" . $car_id . "'";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getHistoVistechVehi($con, $dateProchVistech, $car_id)
	{

		// On initialise un array vide
		$data = array();

		// Requête pour vérifier que la donnée à enregistrer n'existe pas déja dans la table
		$query = "SELECT * FROM tbl_histo_visite_technique WHERE
		date_prochaine_visitetech='" . $dateProchVistech . "' AND car_id='" . $car_id . "'";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getHistoEmplVehi($con, $dateSignClientDepot, $emplacement_vehi, $immavehi, $car_id)
	{

		// On initialise un array vide
		$data = array();

		// Requête pour vérifier que la donnée à enregistrer n'existe pas déja dans la table
		$query = "SELECT * FROM tbl_histo_emplacement_vehicule WHERE date_emplacement='" . $dateSignClientDepot . "' AND emplacement_vehi='" . $emplacement_vehi . "' AND immatriculation_vehi='" . $immavehi . "' AND
	car_id='" . $car_id . "'";

		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}


	/*
	* @get all car model list
	*/
	public function getCarListByCustomerId($con, $cust_id)
	{

		// On initialise un array vide
		$data = array();

		// On vérifie que l'id du client existe et n'est pas vide
		if (isset($cust_id) && !empty($cust_id)) {

			// exécution de la réquête
			$query = "SELECT * from tbl_add_car WHERE customer_id = " . (int) $cust_id;

			// On stocke le résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getMarkModelListByImmaVehi($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		// if (isset($imma_vehi) && !empty($imma_vehi)) {

		// formulation de la réquête
		$query = "SELECT tbl_make.make_id, tbl_model.model_id, make_name, model_name, VIN , cus.customer_id, cus.princ_tel, cus.c_name,
		car_id, tbl_make.*,tbl_model.*
			FROM tbl_add_car JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
			JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model 
			JOIN tbl_add_customer cus ON tbl_add_car.customer_id = cus.customer_id
			WHERE vin = '" . (string) $imma_vehi . "'";

		// Exécution et stockage du résultat de la requête sous forme de ressource
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		// }

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getMarkModelListByImmaVehi_2($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		if (isset($imma_vehi) && !empty($imma_vehi)) {

			// formulation de la réquête
			$query = "SELECT car_make, car_model, VIN, car_id, cus.customer_id
			FROM tbl_add_car cr
			-- JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
			-- JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model 
			JOIN tbl_add_customer cus ON cr.customer_id = cus.customer_id
			WHERE vin = '" . (string) $imma_vehi . "'";

			// Exécution et stockage du résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getMarkModelListByCustomerId($con, $cust_id)
	{
		// On initialise un array vide
		$data = array();

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		if (isset($cust_id) && !empty($cust_id)) {

			// formulation de la réquête
			$query = "SELECT tbl_make.make_id, tbl_model.model_id, make_name, model_name, VIN, tbl_add_customer.customer_id, tbl_add_car.car_id as add_car_id FROM tbl_add_car JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
			JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model JOIN tbl_add_customer ON tbl_add_car.customer_id = tbl_add_customer.customer_id WHERE tbl_add_customer.customer_id = '" . (int) $cust_id . "'";

			// Exécution et stockage du résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On parcours le jeu de résultat puis pour chaque ligne du jeu de résultat
		// On la stocke dans un array associatif de données
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getDateAssurVistechByImmaVehi_2($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		// if (isset($imma_vehi) && !empty($imma_vehi)) {

		// formulation de la réquête
		$query = "SELECT add_date_visitetech, add_date_assurance 
			FROM tbl_add_car 
			-- JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
			-- JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model 
			WHERE vin = '" . (string) $imma_vehi . "'";

		// Exécution et stockage du résultat de la requête sous forme de ressource
		$result = mysql_query($query, $con);

		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		// }

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getDateAssurVistechByImmaVehi($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		if (isset($imma_vehi) && !empty($imma_vehi)) {

			// formulation de la réquête
			$query = "SELECT add_date_visitetech, add_date_assurance FROM tbl_add_car JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
			JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model WHERE vin = '" . (string) $imma_vehi . "'";

			// Exécution et stockage du résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	// public function getModelListByImmaVehi($con, $imma_vehi)
	// {

	// 	// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
	// 	if (isset($imma_vehi) && !empty($imma_vehi)) {

	// 		// formulation de la réquête
	// 		$query = "SELECT model_id, model_name FROM tbl_add_car JOIN tbl_make ON tbl_add_car.car_make = tbl_make.make_id 
	// 		JOIN tbl_model ON tbl_model.model_id = tbl_add_car.car_model WHERE vin = '" . (string)$imma_vehi . "'";

	// 		// Exécution et stockage du résultat de la requête sous forme de ressource
	// 		$result = mysql_query($query, $con);

	// 		// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
	// 		if (!$result) {
	// 			$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 			$message .= 'Whole query: ' . $query;
	// 			die($message);
	// 		}
	// 	}

	// 	// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
	// 	$row = mysql_fetch_assoc($result);
	// 	return $row;
	// }

	public function getMarkByImmaVehi($con, $imma_vehi)
	{

		// On vérifie que l'immatriculation du véhicule existe et n'est pas vide
		if (isset($imma_vehi) && !empty($imma_vehi)) {

			// exécution de la réquête
			// $query = "SELECT * from tbl_add_car inner join tbl_make on tbl_add_car.car_make = tbl_make.make_id WHERE tbl_add_car.VIN = ".(string)$imma_vehi;

			$query = "SELECT make_id, make_name from tbl_add_car inner join tbl_make on tbl_add_car.car_make = tbl_make.make_id WHERE vin = '" . (string) $imma_vehi . "'";

			// On stocke le résultat de la requête sous forme de ressource
			$result = mysql_query($query, $con);

			// S'il y a eu une erreur lors de l'exécution de la réquête, on affiche le message d'erreur
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}

		// On extrait les données du jeu de résultat dans un array associatif puis on le retourne
		$row = mysql_fetch_assoc($result);
		return $row;
	}

	public function getRecepRepairCarByCarId($con, $carId)
	{
		$data = array();
		if (!empty($carId)) {
			$query = "SELECT tbl_recep_vehi_repar.*, tbl_add_customer.*, tbl_make.*
			from tbl_recep_vehi_repar 
			inner join tbl_make on tbl_recep_vehi_repar.car_make = tbl_make.make_id 
			-- join tbl_add_car cr on cr.car_id = tbl_recep_vehi_repar.add_car_id
			inner join tbl_add_customer on tbl_recep_vehi_repar.customer_name = tbl_add_customer.customer_id 
			WHERE tbl_recep_vehi_repar.car_id = " . (int) $carId;
			$result = mysql_query($query, $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			} else {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRecepRepairCarListByCustomer($con, $cust_id)
	{
		// Déclaration et initialisation d'un array vide
		$data = array();
		// Exécution et stockage du résultat de la requête
		$result = mysql_query("SELECT * from tbl_recep_vehi_repar 
		inner join tbl_add_customer on tbl_recep_vehi_repar.customer_name = tbl_add_customer.customer_id", $con);

		// Tant qu'il y a des enregistrements ou lignes dans le jeu de résultat de la requête
		// Pour chaque ligne, on l'affecte à une variable tampon
		// Puis dans l'array
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @save/update Voiture de réparation information
	*/
	public function saveRecepRepairCarInformation($con, $data, $image_url)
	{

		// Date actuelle de la visite technique
		$datetech = DateTime::createFromFormat('d/m/Y', $data['add_date_visitetech']);

		$timestampstechnique =  $datetech->format('U');

		//assurance
		$dateassur = DateTime::createFromFormat('d/m/Y', $data['add_date_assurance']);

		$timestampsassurance =  $dateassur->format('U');

		$query = "INSERT INTO tbl_recep_vehi_repar(repair_car_id, customer_name, car_make, car_model, num_matricule, heure_reception, 
			nivo_carbu_recep_vehi, km_reception_vehi, cle_recep_vehi, cle_recep_vehi_text, carte_grise_recep_vehi, add_date_visitetech, 
			add_date_assurance, timestampstechnique, timestampsassurance,
			assur_recep_vehi, visitetech_recep_vehi, cric_levage_recep_vehi, rallonge_roue_recep_vehi, panneau_remorquage_recep_vehi, 
			scanner_recep_vehi, elec_recep_vehi, meca_recep_vehi, pb_meca_recep_vehi, pb_electro_recep_vehi, pb_demar_recep_vehi, 
			conf_cle_recep_vehi, sup_adblue_recep_vehi, sup_fil_parti_recep_vehi, sup_vanne_egr_recep_vehi,
			arriv_remarq_recep_vehi_text, accident_recep_vehi, etat_proprete_arrivee,
			pare_brise_avant, phare_gauche, clignotant_droit, pare_choc_avant, feu_avant, vitre_avant, poignet_avant, 
			plaque_avant, feu_brouillard, balai_essuie_glace, retroviseur_gauche, symbole_avant, poignet_capot, alternateur, 
			pare_brise_arriere, phare_droit, clignotant_gauche, pare_choc_arriere, feu_arriere, vitre_arriere, poignet_arriere, 
			plaque_arriere, controle_pneu, batterie, retroviseur_droit, symbole_arriere, cache_moteur, poste_auto, coffre_gant, 
			tapis_plafond, ecran_bord, retroviseur_interne, bouton_vitre_arriere, tableau_bord, tapis_sol, commutateur_central, 
			ampoule_interieure, bouton_vitre_avant, bouton_siege, travo_effec, autres_obs, etat_reparation_sortie, etat_proprete_sortie, 
			sortie_remarq_recep_vehi, sortie_remarq_recep_vehi_text, add_date_recep_vehi, cle_roue,
			pneu_secours, triangle, boite_pharma, extincteur, voyant_1, voyant_2, voyant_3, voyant_4, voyant_5, voyant_6, voyant_7, voyant_8, 
			voyant_9, voyant_10, voyant_11, voyant_12, voyant_13, voyant_14, voyant_15, voyant_16, voyant_17, voyant_18, voyant_19, voyant_20,
			voyant_21, voyant_22, voyant_23, voyant_24, type_km, remarque_prise_charge, remarque_access_vehi,
			remarque_motif_depot, remarque_etat_vehi_arrive, remarque_aspect_ext, remarque_aspect_int, remarque_etat_vehi_sortie, 
			etat_vehi_arrive, add_car_id, pj1_url, pj2_url, pj3_url, pj4_url, pj5_url, pj6_url, pj7_url, pj8_url, pj9_url, pj10_url, pj11_url, 
			pj12_url, attrib_recep, dimension_pneu, dupli_cle, climatisation
				
			) 
			values('$data[hfInvoiceId]','$data[ddlCustomerList]','$data[ddlMake]','$data[ddlModel]','$data[ddlImma]','$data[heure_reception]',
			'$data[nivo_carbu_recep_vehi]','$data[km_reception_vehi]','$data[cle_recep_vehi]','$data[cle_recep_vehi_text]',
			'$data[carte_grise_recep_vehi]', '$data[add_date_visitetech]', '$data[add_date_assurance]',
			'$timestampstechnique', '$timestampsassurance','$data[assur_recep_vehi]','$data[visitetech_recep_vehi]',
			'$data[cric_levage_recep_vehi]', '$data[rallonge_roue_recep_vehi]','$data[panneau_remorquage_recep_vehi]',
			'$data[scanner_recep_vehi]','$data[elec_recep_vehi]','$data[meca_recep_vehi]','$data[pb_meca_recep_vehi]',
			'$data[pb_electro_recep_vehi]','$data[pb_demar_recep_vehi]','$data[conf_cle_recep_vehi]','$data[sup_adblue_recep_vehi]',
			'$data[sup_fil_parti_recep_vehi]','$data[sup_vanne_egr_recep_vehi]','$data[arriv_remarq_recep_vehi_text]',
			'$data[accident_recep_vehi]','$data[etat_proprete_arrivee]','$data[pare_brise_avant]',
			'$data[phare_gauche]', '$data[clignotant_droit]','$data[pare_choc_avant]','$data[feu_avant]','$data[vitre_avant]',
			'$data[poignet_avant]','$data[plaque_avant]','$data[feu_brouillard]','$data[balai_essuie_glace]','$data[retroviseur_gauche]', 
			'$data[symbole_avant]','$data[poignet_capot]','$data[alternateur]','$data[pare_brise_arriere]','$data[phare_droit]',
			'$data[clignotant_gauche]','$data[pare_choc_arriere]','$data[feu_arriere]','$data[vitre_arriere]', '$data[poignet_arriere]',
			'$data[plaque_arriere]','$data[controle_pneu]','$data[batterie]','$data[retroviseur_droit]','$data[symbole_arriere]',
			'$data[cache_moteur]','$data[poste_auto]','$data[coffre_gant]', '$data[tapis_plafond]','$data[ecran_bord]',
			'$data[retroviseur_interne]','$data[bouton_vitre_arriere]','$data[tableau_bord]','$data[tapis_sol]',
			'$data[commutateur_central]','$data[ampoule_interieure]','$data[bouton_vitre_avant]', '$data[bouton_siege]',
			'$data[travo_effec]','$data[autres_obs]','$data[etat_reparation_sortie]','$data[etat_proprete_sortie]',
			'$data[sortie_remarq_recep_vehi]','$data[sortie_remarq_recep_vehi_text]','$data[add_date]','$data[cle_roue]','$data[pneu_secours]',
			'$data[triangle]','$data[boite_pharma]','$data[extincteur]',
			'$data[voyant_1]', '$data[voyant_2]', '$data[voyant_3]', '$data[voyant_4]','$data[voyant_5]','$data[voyant_6]',
			'$data[voyant_7]', '$data[voyant_8]', '$data[voyant_9]', '$data[voyant_10]', '$data[voyant_11]','$data[voyant_12]',
			'$data[voyant_13]', '$data[voyant_14]', '$data[voyant_15]', '$data[voyant_16]', '$data[voyant_17]','$data[voyant_18]',
			'$data[voyant_19]', '$data[voyant_20]', '$data[voyant_21]', '$data[voyant_22]', '$data[voyant_23]','$data[voyant_24]',
			'$data[type_km]','$data[remarque_prise_charge]','$data[remarque_access_vehi]','$data[remarque_motif_depot]',
			'$data[remarque_etat_vehi_arrive]','$data[remarque_aspect_ext]','$data[remarque_aspect_int]',
			'$data[remarque_etat_vehi_sortie]','$data[etat_vehi_arrive]','$data[add_car_id]',
			'$data[pj1_url]','$data[pj2_url]','$data[pj3_url]','$data[pj4_url]','$data[pj5_url]',
			'$data[pj6_url]','$data[pj7_url]','$data[pj8_url]','$data[pj9_url]','$data[pj10_url]','$data[pj11_url]','$data[pj12_url]'
			,'$data[recep_id]','$data[dim_pneu]','$data[dupli_cle_recep_vehi]','$data[climatisation]'
			)";

		$result = mysql_query($query, $con);

		if ($result) {
			printf("Nombre de ligne ajoutée : %d\n", mysql_affected_rows());
		} else {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}

		// var_dump($data);
		// var_dump($image_url);
	}

	/*
	* @Enregistrer les informations de pointage
	*/
	public function saveDatePointage($con, $employe, $dateArrivee, $dateDepart)
	{

		mysql_query("INSERT INTO tbl_pointage(employe, date_arrivee, date_depart) values('$employe', '$dateArrivee', '$dateDepart')", $con);
	}

	/*
	* @Mettre à jour les informations de pointage
	*/
	public function saveUpdateDatePointage($con, $data)
	{

		mysql_query("UPDATE `tbl_pointage` SET `date_depart`='" . $data['date_depart_modif'] . "' WHERE id='" . (int) $data['pointage_id'] . "'", $con);
	}

	/*
	* @get all Liste de présences
	*/
	public function getAllPresenceList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_pointage order by id ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get pointage info by id
	*/
	public function getPointageInfoByEmploye($con, $pointage_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_pointage where id = '" . (int) $pointage_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @delete pointage
	*/
	public function deletePointage($con, $cid)
	{
		mysql_query("DELETE FROM `tbl_pointage` WHERE id = " . (int) $cid, $con);
	}

	public function getAllCountries($con)
	{
		$countries = array();
		$result = mysql_query("SELECT * FROM tbl_countries order by name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$countries[] = array(
				'country_id'	=> $row['id'],
				'name'	=> $row['name']
			);
		}
		return $countries;
	}

	//return all states based on country
	public function getStateByCountryId($con, $cid)
	{
		$states = array();
		$result = mysql_query("SELECT * FROM tbl_states WHERE country_id = " . (int) $cid . " order by name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$states[] = array(
				'id'	=> $row['id'],
				'name'	=> $row['name']
			);
		}
		return $states;
	}

	/*
	* @get all Liste de clients
	*/
	public function getAllCustomerList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_customer order by c_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all work status list
	*/
	public function getAllWorkStatusList($con, $mech_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_daily_work WHERE mechanic_id = '" . (int) $mech_id . "' order by work_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all mechanic salery list
	*/
	public function getAllMechnahicSaleryList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_mcncsslary ms left join tbl_add_mechanics am on am.mechanics_id = ms.mechanics_id order by ms.m_salary_id", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all mechanic list sort byName
	*/
	public function getAllMechanicListSortByName($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_mechanics order by m_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all state list
	*/
	public function getAllStateData($con, $country_id)
	{
		$data = array();
		$result = mysql_query("SELECT * from tbl_states where country_id = " . (int) $country_id, $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarListByCustomer($con, $customer_id)
	{
		$data = array();
		$result = mysql_query("SELECT ac.image as car_image, ac.*, c.*, ma.*, mo.*
		FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id 
		inner join tbl_make ma on ma.make_id = ac.car_make 
		inner join tbl_model mo on mo.model_id = ac.car_model 
		-- inner join tbl_year y on y.year_id = ac.year 
		WHERE c.customer_id = '" . (int) $customer_id . "'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}


	/*
	* @get all Voiture de réparation list
	*/
	// public function getAllRepairCarListAtGarage($con)
	// {
	// 	$data = array();
	// 	$result = mysql_query("SELECT DISTINCT ac.car_id, car_name, chasis_no, stat_empla_vehi, date_emplacement
	// 	FROM tbl_add_car ac inner join tbl_histo_emplacement_vehicule hev on hev.car_id = ac.car_id 
	// 	inner join tbl_recep_vehi_repar rvr on rvr.add_car_id = ac.car_id 
	//     where rvr.stat_empla_vehi = 'au garage'
	// 	order by ac.car_id DESC", $con);
	// 	while ($row = mysql_fetch_array($result)) {
	// 		$data[] = $row;
	// 	}
	// 	return $data;
	// }



	/*
	* @get all Voiture de réparation list
	*/
	public function getAllRepairCarHistoAssurVisitetechList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,ac.image as car_image,c.c_name,c.image as customer_image,c.c_email,c.c_mobile,m.make_name,mo.model_name,y.year_name,ac.repair_car_id 
		FROM tbl_add_car ac join tbl_add_customer c on c.customer_id = ac.customer_id 
		join tbl_make m on m.make_id = ac.car_make 
		join tbl_model mo on mo.model_id = ac.car_model 
		join tbl_year y on y.year_id = ac.year 
		join tbl_histo_assurance ha on ha.car_id = ac.car_id
		join tbl_histo_visite_technique vt on vt.car_id = ac.car_id
		order by ac.car_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get customer Voiture de réparation list
	*/
	public function getCustomerRepairCarList($con, $customer_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,ac.image as car_image,c.c_name,c.image as customer_image,c.c_email,c.c_mobile,m.make_name,mo.model_name,y.year_name,ac.repair_car_id FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id inner join tbl_make m on m.make_id = ac.car_make inner join tbl_model mo on mo.model_id = ac.car_model inner join tbl_year y on y.year_id = ac.year WHERE ac.customer_id = " . (int) $customer_id . " order by ac.car_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}


	/*
	* @get customer repair Détails de la voiture
	*/
	public function getCustomerRepairCarDetails($con, $customer_id, $repair_car_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,ac.image as car_image,c.c_name,c.image as customer_image,c.c_email,c.c_mobile,m.make_name,mo.model_name,y.year_name,ac.repair_car_id FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id inner join tbl_make m on m.make_id = ac.car_make inner join tbl_model mo on mo.model_id = ac.car_model inner join tbl_year y on y.year_id = ac.year WHERE ac.customer_id = " . (int) $customer_id . " AND ac.repair_car_id = " . (int) $repair_car_id . " order by ac.car_id DESC", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @estimate ajax parts list filter
	*/
	public function ajaxPartsListByMakeModelYear($con, $post)
	{
		$data = array();
		$result = mysql_query("SELECT * from tbl_parts_fit_data fd INNER JOIN  tbl_parts_stock_manage ps ON ps.parts_id = fd.parts_id where fd.make_id = '" . (int) $post['make_id'] . "' AND fd.model_id = '" . (int) $post['model_id'] . "' AND fd.year_id = '" . (int) $post['year_id'] . "'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @estimate ajax parts like filter
	*/
	public function ajaxPartsListByPartsName($con, $post)
	{
		$data = array();
		$result = mysql_query("SELECT * from tbl_parts_stock where parts_name LIKE '%" . trim($post['filter_name']) . "%'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @ajax Salaire Mécanicien
	*/
	public function ajaxGetMechanicsSalary($con, $mid)
	{
		$data = array();
		$result = mysql_query("SELECT * from tbl_add_mechanics where mechanics_id = '" . (int) $mid . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @ajax mechanics per month hour
	*/
	public function ajaxGetMechanicsMonthTotalHour($con, $mechanic_id, $month_id, $year_id)
	{
		$data = array();
		$result = mysql_query("SELECT sum(total_hour) as total_hour from tbl_daily_work where mechanic_id = '" . (int) $mechanic_id . "' AND MONTH(work_date) = '" . $month_id . "' AND YEAR(work_date) = '" . $year_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get all Liste Fabricants
	*/
	public function getAllManufacturerList($con)
	{
		$manufacturers = array();
		$result = mysql_query("SELECT * FROM tbl_manufacturer order by manufacturer_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$image = WEB_URL . 'img/no_image.jpg';
			if ($row['manufacturer_image'] != '') {
				$image = WEB_URL . 'img/upload/' . $row['manufacturer_image'];
			}
			$manufacturers[] = array(
				'id'		=> $row['manufacturer_id'],
				'name'		=> $row['manufacturer_name'],
				'image' 	=> $image
			);
		}
		return $manufacturers;
	}
	/*
	* get manufacturer id for supplier
	*/
	public function getManufacturersForSupplier($con, $sid)
	{
		$supplierManufacturer = array();
		$result = mysql_query("SELECT *,m.manufacturer_name,m.manufacturer_image FROM tbl_supplier_manufacturer sm inner join tbl_manufacturer m on m.manufacturer_id = sm.manufacturer_id WHERE sm.supplier_id = " . (int) $sid . " order by sm.manufacturer_id ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$image = '';
			if ($row['manufacturer_image'] != '') {
				$image = WEB_URL . 'img/upload/' . $row['manufacturer_image'];
			}
			$supplierManufacturer[] = array(
				'image'					=> $image,
				'name'					=> $row['manufacturer_name'],
				'supplier_id'			=> $row['supplier_id'],
				'manufacturer_id'		=> $row['manufacturer_id']
			);
		}
		return $supplierManufacturer;
	}

	/*
	* @get all parts list
	*/
	public function getAllPartsList($con, $page, $limit)
	{
		$parts_list = array();
		$start_from = ($page - 1) * $limit;
		//$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name,m.make_name,mo.model_name,y.year_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id left join tbl_make m on m.make_id = ps.make_id left join tbl_model mo on mo.model_id = ps.model_id left join tbl_year y on y.year_id = ps.year_id ORDER BY ps.parts_name ASC",$con);
		$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name FROM tbl_parts_stock_manage ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id ORDER BY ps.parts_name ASC LIMIT " . $start_from . "," . $limit, $con);
		while ($row = mysql_fetch_array($result)) {
			$image = '';
			if ($row['parts_image'] != '') {
				$image = WEB_URL . 'img/upload/' . $row['parts_image'];
			}
			$parts_list[] = array(
				'parts_id'				=> $row['parts_id'],
				'parts_name'			=> $row['parts_name'],
				//'make_id'				=> $row['make_id'],
				//'model_id'			=> $row['model_id'],
				//'year_id'				=> $row['year_id'],
				'supplier_id'			=> $row['supplier_id'],
				'manufacturer_id'		=> $row['manufacturer_id'],
				'parts_condition'		=> $row['condition'],
				'quantity'				=> $row['quantity'],
				'parts_warranty'		=> !empty($row['parts_warranty']) ? $row['parts_warranty'] : 'NO',
				'parts_sku'				=> $row['part_no'],
				'parts_sell_price'		=> $row['price'],
				'parts_image'			=> $image,
				//'make'				=> $row['make_name'],
				//'model'				=> $row['model_name'],
				//'year'				=> $row['year_name'],
				'manufacturer_name'		=> $row['manufacturer_name'],
				'supplier_name'			=> $row['s_name']
			);
		}
		return $parts_list;
	}

	/*
	* @count all parts list by M M Y
	*/
	public function countAllPartsListByMakeModelYear($con, $data)
	{
		$count = 0;
		$result = array();
		if (!empty($data['make']) && !empty($data['model']) && !empty($data['year'])) {
			$result = mysql_query("SELECT count(ps.parts_id) as total FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " AND pft.model_id = " . (int) $data['model'] . " AND pft.year_id = " . (int) $data['year'] . " ORDER BY ps.parts_name ASC", $con);
		} else if (!empty($data['make']) && !empty($data['model'])) {
			$result = mysql_query("SELECT count(ps.parts_id) as total FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " AND pft.model_id = " . (int) $data['model'] . " ORDER BY ps.parts_name ASC", $con);
		} else if (!empty($data['make'])) {
			$result = mysql_query("SELECT count(ps.parts_id) as total FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " ORDER BY ps.parts_name ASC", $con);
		}
		if (!empty($result)) {
			if ($row = mysql_fetch_array($result)) {
				$count = $row['total'];
			}
		}
		return $count;
	}

	/*
	* @get all parts list based on make model and year
	*/
	public function getAllPartsListByMakeModelYear($con, $page, $limit, $data)
	{
		$parts_list = array();
		$start_from = ($page - 1) * $limit;
		$result = '';
		if (!empty($data['make']) && !empty($data['model']) && !empty($data['year'])) {
			$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " AND pft.model_id = " . (int) $data['model'] . " AND pft.year_id = " . (int) $data['year'] . " ORDER BY ps.parts_name ASC LIMIT " . $start_from . "," . $limit, $con);
		} else if (!empty($data['make']) && !empty($data['model'])) {
			$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " AND pft.model_id = " . (int) $data['model'] . " ORDER BY ps.parts_name ASC LIMIT " . $start_from . "," . $limit, $con);
		} else if (!empty($data['make'])) {
			$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name FROM tbl_parts_fit_data pft INNER JOIN tbl_parts_stock_manage ps ON ps.parts_id = pft.parts_id LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE pft.make_id = " . (int) $data['make'] . " ORDER BY ps.parts_name ASC LIMIT " . $start_from . "," . $limit, $con);
		}
		if (!empty($result)) {
			while ($row = mysql_fetch_array($result)) {
				$image = '';
				if ($row['parts_image'] != '') {
					$image = WEB_URL . 'img/upload/' . $row['parts_image'];
				}
				$parts_list[] = array(
					'parts_id'				=> $row['parts_id'],
					'parts_name'			=> $row['parts_name'],
					'supplier_id'			=> $row['supplier_id'],
					'manufacturer_id'		=> $row['manufacturer_id'],
					'parts_condition'		=> $row['condition'],
					'quantity'				=> $row['quantity'],
					'parts_warranty'		=> !empty($row['parts_warranty']) ? $row['parts_warranty'] : 'NO',
					'parts_sku'				=> $row['part_no'],
					'parts_sell_price'		=> $row['price'],
					'parts_image'			=> $image,
					'manufacturer_name'		=> $row['manufacturer_name'],
					'supplier_name'			=> $row['s_name']
				);
			}
		}
		return $parts_list;
	}

	/*
	* @get parts info by id
	*/
	/*public function getPartsInformationById($parts_id, $con) {
		$parts_list = array();
		$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name,m.make_name,mo.model_name,y.year_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id left join tbl_make m on m.make_id = ps.make_id left join tbl_model mo on mo.model_id = ps.model_id left join tbl_year y on y.year_id = ps.year_id WHERE parts_id = '".(int)$parts_id."'",$con);
		if($row = mysql_fetch_array($result)){
			$image = '';
			if($row['parts_image'] != ''){ $image = WEB_URL . 'img/upload/' . $row['parts_image'];}
			$parts_list = array(
				'parts_id'				=> $row['parts_id'],
				'parts_name'			=> $row['parts_name'],
				'make_id'				=> $row['make_id'],
				'model_id'				=> $row['model_id'],
				'year_id'				=> $row['year_id'],
				'supplier_id'			=> $row['supplier_id'],
				'manufacturer_id'		=> $row['manufacturer_id'],
				'parts_condition'		=> $row['parts_condition'],
				'parts_buy_price'		=> $row['parts_buy_price'],
				'parts_quantity'		=> $row['parts_quantity'],
				'parts_sku'				=> $row['parts_sku'],
				'parts_warranty'		=> !empty($row['parts_warranty']) ? $row['parts_warranty'] : 'N/A',
				'parts_sell_price'		=> $row['parts_sell_price'],
				'parts_image'			=> $image,
				'parts_added_date'		=> $row['parts_added_date'],
				'make'					=> $row['make_name'],
				'model'					=> $row['model_name'],
				'year'					=> $row['year_name'],
				'manufacturer_name'		=> $row['manufacturer_name'],
				'supplier_name'			=> $row['s_name']
			);
		}
		return $parts_list;
	}*/

	public function getPartsInformationById($parts_id, $con)
	{
		$parts_list = array();
		$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name FROM tbl_parts_stock_manage ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE parts_id = '" . (int) $parts_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$image = '';
			if ($row['parts_image'] != '') {
				$image = WEB_URL . 'img/upload/' . $row['parts_image'];
			}
			$parts_list = array(
				'parts_id'				=> $row['parts_id'],
				'parts_name'			=> $row['parts_name'],
				'supplier_id'			=> $row['supplier_id'],
				'manufacturer_id'		=> $row['manufacturer_id'],
				'parts_condition'		=> $row['condition'],
				'parts_quantity'		=> $row['quantity'],
				'parts_sku'				=> $row['part_no'],
				'parts_warranty'		=> !empty($row['parts_warranty']) ? $row['parts_warranty'] : 'N/A',
				'parts_sell_price'		=> $row['price'],
				'parts_image'			=> $image,
				'manufacturer_name'		=> $row['manufacturer_name'],
				'supplier_name'			=> $row['s_name']
			);
		}
		return $parts_list;
	}

	/*
	* @get all make list
	*/
	public function get_all_make_list($con)
	{
		$make = array();
		$result = mysql_query("SELECT * FROM tbl_make order by make_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$make[] = array(
				'make_id'		=> $row['make_id'],
				'make_name'		=> $row['make_name']
			);
		}
		return $make;
	}

	/*
	* @get all model list
	*/
	public function get_all_model_list($con)
	{
		$model = array();
		$result = mysql_query("SELECT * FROM tbl_model mo 
		INNER JOIN tbl_make ma ON mo.make_id = ma.make_id order by ma.make_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$model[] = array(
				'model_id'		=> $row['model_id'],
				'make_id'		=> $row['make_id'],
				'model_name'	=> $row['model_name'],
				'make_name'		=> $row['make_name']
			);
		}
		return $model;
	}

	/*
	* @get all year list
	*/
	public function get_all_year_list($con)
	{
		$model = array();
		$result = mysql_query("SELECT *,m.make_name,mo.model_name FROM tbl_year y inner join tbl_make m on m.make_id = y.make_id inner join tbl_model mo on mo.model_id = y.model_id order by make_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$model[] = array(
				'year_id'		=> $row['year_id'],
				'make_id'		=> $row['make_id'],
				'model_id'		=> $row['model_id'],
				'year_name'		=> $row['year_name'],
				'make_name'		=> $row['make_name'],
				'model_name'	=> $row['model_name']
			);
		}
		return $model;
	}

	/*
	* @get all year list
	*/
	/*public function getEstimateRespairData($con, $car_id, $customer_id) {
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_car WHERE car_id = '".(int)$car_id."' AND customer_id = '".(int)$customer_id."'",$con);
		if($row = mysql_fetch_array($result)){
			$data = $row;
		}
		return $data;
	}*/

	/*
	* @get customer and car info by card id
	*/
	public function getCustomerAndCarDetailsByCarId($con, $car_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,cu.customer_id, cu.c_name, cu.c_email FROM tbl_add_car ca INNER JOIN tbl_add_customer cu on ca.customer_id = cu.customer_id WHERE ca.car_id = '" . (int) $car_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get buy parts list by parts id
	*/
	public function getBuyPartsListByPartsId($con, $invoice_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,psm.price FROM tbl_parts_stock ps INNER JOIN tbl_parts_stock_manage psm on psm.parts_id = ps.parts_id where ps.invoice_id = '" . trim($invoice_id) . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get Stock de pièces information by parts id
	*/
	public function getPartsStockInfoByPartsId($con, $parts_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_parts_stock_manage psm where psm.parts_id = '" . (int) $parts_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get website settings data
	*/
	public function getWebsiteSettingsInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_settings", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}
	/*
	* @save customer remind deatils
	*/
	public function saveCustomerRemindDetails($con, $invoice_id, $car_id, $customer_id, $progress)
	{
		mysql_query("INSERT INTO tbl_customer_notification(invoice_id, car_id, customer_id, progress, notify_date) VALUES('" . $invoice_id . "'," . (int) $car_id . "," . (int) $customer_id . "," . (int) $progress . ",'" . date('Y-m-d H:i:s') . "')", $con);
	}

	/*
	* @save system information
	*/
	public function saveSystemInformation($con, $data, $site_logo)
	{
		mysql_query("DELETE FROM tbl_settings", $con);
		$footer_text_1 = mysql_real_escape_string($data['footer_box_1']);
		$footer_text_2 = mysql_real_escape_string($data['footer_box_2']);
		$footer_text_3 = mysql_real_escape_string($data['footer_box_3']);
		$footer_text_4 = mysql_real_escape_string($data['footer_box_4']);
		$footer_text_5 = mysql_real_escape_string($data['footer_box_5']);
		//header
		$header_text_1 = mysql_real_escape_string($data['header_box_1']);
		$header_text_2 = mysql_real_escape_string($data['header_box_2']);
		//contact us
		$contact_us_text_1 = mysql_real_escape_string($data['contact_us_text_1']);
		$map_api_key = mysql_real_escape_string($data['google_api_key']);
		$map_address = mysql_real_escape_string($data['map_address']);
		//subscribe
		$mc_api_key = mysql_real_escape_string($data['mc_api_key']);
		$mc_list_id = mysql_real_escape_string($data['mc_list_id']);

		mysql_query("INSERT INTO tbl_settings(site_name,currency,email,address,site_logo,footer_box_1,footer_box_2,footer_box_3,footer_box_4,footer_box_5,header_box_1,header_box_2,contact_us_text_1,gogole_api_key,map_address,mc_api_key,mc_list_id) VALUES('" . $data['txtWorkshopName'] . "','" . $data['txtCurrency'] . "','" . $data['txtEmailAddress'] . "','" . $data['txtAddress'] . "','" . $site_logo . "','" . $footer_text_1 . "','" . $footer_text_2 . "','" . $footer_text_3 . "','" . $footer_text_4 . "','" . $footer_text_5 . "','" . $header_text_1 . "','" . $header_text_2 . "','" . $contact_us_text_1 . "','" . $map_api_key . "','" . $map_address . "','" . $mc_api_key . "','" . $mc_list_id . "')", $con);
	}

	/*
	* @get car and customer information by invoice ID
	*/
	public function getCarAndCustomerInformationByInvoiceId($con, $invoice_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,ac.image as car_image,c.c_name,c.image as customer_image,c.c_address,c.c_email,c.c_mobile,m.make_name,mo.model_name,y.year_name,ac.estimate_no FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id inner join tbl_make m on m.make_id = ac.car_make inner join tbl_model mo on mo.model_id = ac.car_model inner join tbl_year y on y.year_id = ac.year WHERE ac.estimate_no = '" . (int) $invoice_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get all delivery car list
	*/
	public function getAllDeliveryCarList($con)
	{
		$data = array();
		//$result = mysql_query("SELECT *,ac.image as car_image,c.c_name,c.image as customer_image,c.c_address,c.c_email,c.c_mobile,m.make_name,mo.model_name,y.year_name,ac.estimate_no FROM tbl_add_car ac inner join tbl_add_customer c on c.customer_id = ac.customer_id inner join tbl_make m on m.make_id = ac.car_make inner join tbl_model mo on mo.model_id = ac.car_model inner join tbl_year y on y.year_id = ac.year WHERE ac.delivery_status = 1",$con);
		$result = mysql_query("SELECT *,c.image as customer_image,ac.image as car_image,m.make_name,mo.model_name,y.year_name FROM tbl_car_estimate ce INNER JOIN tbl_add_car ac on ce.car_id = ac.car_id INNER JOIN tbl_add_customer c on c.customer_id = ce.customer_id left join tbl_make m on m.make_id = ac.car_make left join tbl_model mo on mo.model_id = ac.car_model left join tbl_year y on y.year_id = ac.year WHERE ce.delivery_status = 1", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all delivery Voiture de réparation list for report
	*/
	public function getRepairCarDateForReport($con, $filter)
	{
		$data = array();
		$sql = "SELECT *,c.image as customer_image,ac.image as car_image,m.make_name,mo.model_name,y.year_name FROM tbl_car_estimate ce INNER JOIN tbl_add_car ac on ce.car_id = ac.car_id INNER JOIN tbl_add_customer c on c.customer_id = ce.customer_id left join tbl_make m on m.make_id = ac.car_make left join tbl_model mo on mo.model_id = ac.car_model left join tbl_year y on y.year_id = ac.year";
		if ($filter['status'] == '') {
			$sql .= " WHERE ce.delivery_status IN(1,0)";
		} else {
			$sql .= " WHERE ce.delivery_status = '" . $filter['status'] . "'";
		}
		if (!empty($filter['date'])) {
			$sql .= " AND ce.delivery_done_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if ($filter['status'] == '1') {
				if (!empty($filter['month'])) {
					$sql .= " AND MONTH(ce.delivery_done_date) = '" . $filter['month'] . "'";
				}
				if (!empty($filter['year'])) {
					$sql .= " AND YEAR(ce.delivery_done_date) = '" . $filter['year'] . "'";
				}
			} else {
				if (!empty($filter['month'])) {
					$sql .= " AND MONTH(ce.created_date) = '" . $filter['month'] . "'";
				}
				if (!empty($filter['year'])) {
					$sql .= " AND YEAR(ce.created_date) = '" . $filter['year'] . "'";
				}
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND payment_due > 0";
			} else {
				$sql .= " AND payment_due = 0.00";
			}
		}
		//echo $sql;
		//die();
		//
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}


	// Vehicules bientot en echeance

	public function getRepairCarDateForReportEcheance($con)
	{
		$data = array();
		$datetech = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));

		$timestampstechnique =  $datetech->format('U');

		//assurance
		$dateassur = DateTime::createFromFormat('d/m/Y', date('d/m/Y'));

		$timestampsassurance =  $dateassur->format('U');
		//$result = mysql_query("SELECT MONTHNAME(`invoice_date`) as month_name, (select SUM(quantity) as total_parts from tbl_parts_sell ps WHERE ps.sold_id = tbl_parts_sold_invoice.sold_id ) as total_parts FROM tbl_parts_sold_invoice WHERE YEAR(`invoice_date`) = '".$year."' GROUP BY MONTH(`invoice_date`) ORDER BY MONTH(`invoice_date`)",$con);

		$result = mysql_query("SELECT *,c.image as customer_image,ac.image as car_image,m.make_name,mo.model_name,y.year_name FROM tbl_car_estimate ce INNER JOIN tbl_add_car ac on ce.car_id = ac.car_id INNER JOIN tbl_add_customer c on c.customer_id = ce.customer_id left join tbl_make m on m.make_id = ac.car_make left join tbl_model mo on mo.model_id = ac.car_model left join tbl_year y on y.year_id = ac.year WHERE ac.timestampsassurance >= '" . $timestampsassurance . "' OR ac.timestampstechnique >= '" . $timestampstechnique . " ORDER BY ac.timestampstechnique ASC LIMIT 10'", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get Notification client data
	*/
	public function getCustomerNotificationEmails($con)
	{
		$data = array();
		$result = mysql_query("SELECT cn.n_id,cn.progress,cn.notify_date,c.c_name,ac.car_name FROM tbl_customer_notification cn inner join tbl_add_customer c on c.customer_id = cn.customer_id inner join tbl_add_car ac on ac.car_id = cn.car_id order by cn.n_id desc", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard sell car pie chart
	*/
	public function getSellCarMonthlyData($con, $year)
	{
		$data = array();
		$result = mysql_query("SELECT MONTHNAME(`selling_date`) as month_name,count(`carsell_id`) as total_sell FROM tbl_carsell WHERE YEAR(`selling_date`) = '" . $year . "' GROUP BY MONTH(`selling_date`) ORDER BY MONTH(`selling_date`)", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}


	/*
	* @dashboard sell parts pie chart
	*/
	public function getSellPartsMonthlyData($con, $year)
	{
		$data = array();

		//$result = mysql_query("SELECT MONTHNAME(`invoice_date`) as month_name, (select SUM(quantity) as total_parts from tbl_parts_sell ps WHERE ps.sold_id = tbl_parts_sold_invoice.sold_id ) as total_parts FROM tbl_parts_sold_invoice WHERE YEAR(`invoice_date`) = '".$year."' GROUP BY MONTH(`invoice_date`) ORDER BY MONTH(`invoice_date`)",$con);
		$result = mysql_query("select *,sum(total_parts) as total_parts from vw_parts_sold where year_name = '" . $year . "' group by month_name", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard mechanice monthly hour report
	*/
	public function getMechaniceMonthlyHourData($con, $year, $mech_id)
	{
		$data = array();
		$result = mysql_query("SELECT MONTHNAME(`work_date`) as month_name,sum(`total_hour`) as total_hour FROM tbl_daily_work WHERE YEAR(`work_date`) = '" . $year . "' AND mechanic_id = " . (int) $mech_id . " GROUP BY MONTH(`work_date`) ORDER BY MONTH(`work_date`) ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard car repair chart
	*/
	public function getCarRepairChartData($con, $year)
	{
		$data = array();
		$result = mysql_query("SELECT MONTHNAME(`delivery_done_date`) as month_name,count(`estimate_id`) as total_repair FROM tbl_car_estimate WHERE YEAR(`delivery_done_date`) = '" . $year . "' GROUP BY MONTH(`delivery_done_date`) ORDER BY MONTH(`delivery_done_date`)", $con);

		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard mechanices salary chart each month
	*/
	public function getMechaniceSalaryReportChartData($con, $year, $mech_id)
	{
		$data = array();
		$result = mysql_query("select MONTHNAME(STR_TO_DATE(`month_id`, '%m')) as month_name, paid_amount from tbl_mcncsslary WHERE year_id = " . $year . " AND mechanics_id=" . (int) $mech_id, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard customer repair chart by month
	*/
	public function getCustomerRepairReportChartData($con, $year, $cust_id)
	{
		$data = array();
		$result = mysql_query("select MONTHNAME(`created_date`) as month_name, total_cost as paid_amount from tbl_car_estimate WHERE job_status = 1 AND YEAR(created_date) = " . $year . " AND customer_id=" . (int) $cust_id, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @dashboard mechanices get Heure totale
	*/
	public function getMechaniceTotalHourList($con, $mech_id)
	{
		$data = 0;
		$result = mysql_query("select sum(total_hour) as total_hour from tbl_daily_work WHERE mechanic_id=" . (int) $mech_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row['total_hour'];
		}
		return $data;
	}

	/*
	* @dashboard mechanices get total Montant payé
	*/
	public function getMechaniceTotalPaidAmount($con, $mech_id)
	{
		$data = array();
		$result = mysql_query("select sum(total) as total, sum(paid_amount) as total_paid_amount, sum(due_amount) as total_due_amount from tbl_mcncsslary WHERE mechanics_id=" . (int) $mech_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get all car list
	*/
	public function getAllCarList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id order by bc.buycar_id ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}


	/*
	* @get all sell car report info
	*/
	public function getSellCarReportInformationList($con, $filter)
	{
		$data = array();
		$sql = '';
		if ($filter['condition'] != 'both') {
			$sql = "SELECT * FROM tbl_carsell cs left join tbl_buycar bc on bc.buycar_id = cs.car_id WHERE cs.car_condition = '" . (string) $filter['condition'] . "' AND cs.is_return = 0";
		} else {
			$sql = "SELECT * FROM tbl_carsell cs left join tbl_buycar bc on bc.buycar_id = cs.car_id WHERE cs.is_return = 0";
		}
		if (!empty($filter['date'])) {
			$sql .= " AND cs.selling_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if (!empty($filter['month'])) {
				$sql .= " AND MONTH(cs.selling_date) = '" . $filter['month'] . "'";
			}
			if (!empty($filter['year'])) {
				$sql .= " AND YEAR(cs.selling_date) = '" . $filter['year'] . "'";
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND due_amount > 0";
			} else {
				$sql .= " AND due_amount = 0.00";
			}
		}
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all buy car list // Report
	*/
	public function getAllBuyCarReportList($con, $filter)
	{
		$data = array();
		$sql = '';
		if ($filter['condition'] != 'both') {
			$sql = "SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE bc.car_status = '" . (int) $filter['status'] . "' AND bc.car_condition = '" . (string) $filter['condition'] . "'";
		} else {
			$sql = "SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE bc.car_status = '" . (int) $filter['status'] . "'";
		}

		if (!empty($filter['date'])) {
			$sql .= " AND bc.buy_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if (!empty($filter['month'])) {
				$sql .= " AND MONTH(bc.buy_date) = '" . $filter['month'] . "'";
			}
			if (!empty($filter['year'])) {
				$sql .= " AND YEAR(bc.buy_date) = '" . $filter['year'] . "'";
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND bc.buy_price - bc.buy_given_amount > 0";
			} else {
				$sql .= " AND bc.buy_price - bc.buy_given_amount = 0";
			}
		}
		//
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all buy parts list // Report
	*/
	public function getAllPurchasedPartsReportList($con, $filter)
	{
		$data = array();
		$sql = '';
		if ($filter['condition'] == 'both') {
			$sql = 'SELECT *,s.s_name,mu.manufacturer_name,s.s_name as supplier_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE parts_condition IN("new","old")';
		} else {
			$sql = 'SELECT *,s.s_name,mu.manufacturer_name,s.s_name as supplier_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE parts_condition = "' . $filter['condition'] . '"';
		}

		if (!empty($filter['date'])) {
			$sql .= " AND ps.parts_added_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if (!empty($filter['month'])) {
				$sql .= " AND MONTH(ps.parts_added_date) = '" . $filter['month'] . "'";
			}
			if (!empty($filter['year'])) {
				$sql .= " AND YEAR(ps.parts_added_date) = '" . $filter['year'] . "'";
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND ps.pending_amount > 0";
			} else {
				$sql .= " AND ps.pending_amount = 0";
			}
		}

		$sql .= " ORDER BY ps.parts_name ASC";
		//
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Vendre une liste de pièces // Report
	*/
	public function getAllSellPartsReportList($con, $filter)
	{
		$data = array();
		$sql = 'SELECT *,(SELECT count(sold_id) FROM tbl_parts_sell ps WHERE ps.sold_id = si.sold_id) as total_parts FROM tbl_parts_sold_invoice si WHERE si.grand_total > 0';
		if (!empty($filter['date'])) {
			$sql .= " AND si.invoice_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if (!empty($filter['month'])) {
				$sql .= " AND MONTH(si.invoice_date) = '" . $filter['month'] . "'";
			}
			if (!empty($filter['year'])) {
				$sql .= " AND YEAR(si.invoice_date) = '" . $filter['year'] . "'";
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND si.due_amount > 0";
			} else {
				$sql .= " AND si.due_amount = 0";
			}
		}
		if (!empty($filter['invoice_no'])) {
			$sql .= " AND si.invoice_id = '" . $filter['invoice_no'] . "'";
		}

		$sql .= " order by si.invoice_date ASC";
		//
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Mechanices salary // Report
	*/
	public function getMechanicesSalaryReportList($con, $filter)
	{
		$data = array();
		$sql = "SELECT * FROM tbl_mcncsslary ms left join tbl_add_mechanics am on am.mechanics_id = ms.mechanics_id WHERE ms.mechanics_id > 0";
		if (!empty($filter['mid'])) {
			$sql .= " AND ms.mechanics_id = '" . $filter['mid'] . "'";
		}
		if (!empty($filter['date'])) {
			$sql .= " AND ms.sl_date = '" . $this->datepickerDateToMySqlDate($filter['date']) . "'";
		} else {
			if (!empty($filter['month'])) {
				$sql .= " AND month_id = '" . $filter['month'] . "'";
			}
			if (!empty($filter['year'])) {
				$sql .= " AND year_id = '" . $filter['year'] . "'";
			}
		}
		if (!empty($filter['payment'])) {
			if ($filter['payment'] == 'due') {
				$sql .= " AND ms.due_amount > 0";
			} else {
				$sql .= " AND ms.due_amount = 0";
			}
		}
		$sql .= " order by ms.m_salary_id";
		//
		$result = mysql_query($sql, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car list
	*/
	public function getAllActiveCarList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_car", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @filter car list
	*/
	public function filterCarListByMakeModelYear($con, $datax)
	{
		$data = array();
		$result = array();
		if (!empty($datax['make']) && !empty($datax['model']) && !empty($datax['year'])) {
			$result = mysql_query("SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE m.make_id = $datax[make] AND mo.model_id = $datax[model] AND y.year_id = $datax[year] AND bc.car_status = 0 order by bc.buycar_id ASC", $con);
		} else if (!empty($datax['make']) && !empty($datax['model'])) {
			$result = mysql_query("SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE m.make_id = $datax[make] AND mo.model_id = $datax[model] AND bc.car_status = 0 order by bc.buycar_id ASC", $con);
		} else if (!empty($datax['make'])) {
			$result = mysql_query("SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE m.make_id = $datax[make] AND bc.car_status = 0 order by bc.buycar_id ASC", $con);
		}
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car list with pagination
	*/
	public function getAllCarListWithPagination($con, $page, $limit)
	{
		$data = array();
		$start_from = ($page - 1) * $limit;
		$result = mysql_query("SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id WHERE car_status = 0 order by bc.buycar_id ASC LIMIT " . $start_from . "," . $limit, $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get car door information
	*/
	public function getCarDoorInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_cardoor order by door_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get car color information
	*/
	public function getCarColorInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_carcolor order by color_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Liste Fournisseurs
	*/
	public function getAllSupplierData_2($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.name as country_name,sa.name as state_name FROM tbl_add_supplier s inner join tbl_countries c on c.id = s.country_id inner join tbl_states sa on sa.id = s.state_id order by s.supplier_id", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllSupplierData($con)
	{

		$data = array();

		$query = "SELECT *
		FROM tbl_add_supplier s 
		order by s.supplier_id";

		$result = mysql_query($query, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllReceptionnisteData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_reception", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @count all car list
	*/
	public function countAllCarList($con)
	{
		$data = 0;
		$result = mysql_query("SELECT count(buycar_id) as total FROM tbl_buycar WHERE car_status = 0", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row['total'];
		}
		return $data;
	}

	/*
	* @count all parts list
	*/
	public function countAllPartsList($con)
	{
		$data = 0;
		$result = mysql_query("SELECT count(parts_id) as total FROM tbl_parts_stock_manage WHERE status = 1", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row['total'];
		}
		return $data;
	}

	/*
	* @get all car make list
	*/
	public function getAllCarMakeList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_make order by make_name ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car model list
	*/
	public function getModelListByMakeId($con, $makeId)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_model WHERE make_id = " . (int) $makeId . " order by model_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car year list
	*/
	public function getYearlListByMakeIdAndModelId($con, $makeId, $modelId)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_year WHERE model_id = " . (int) $modelId . " AND make_id = " . (int) $makeId . " order by year_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @delete notification email
	*/
	public function deleteNotificationEmailAlert($con, $n_id)
	{
		mysql_query("DELETE FROM tbl_customer_notification WHERE n_id = '" . (int) $n_id . "'", $con);
	}

	/*
	* @delete make data
	*/
	public function deleteMakeData($con, $make_id)
	{
		mysql_query("DELETE from tbl_make where make_id = " . (int) $make_id, $con);
	}

	/*
	* @delete model data
	*/
	public function deleteModelData($con, $model_id)
	{
		mysql_query("DELETE from tbl_model where model_id = " . (int) $model_id, $con);
	}

	/*
	* @delete year data
	*/
	public function deleteYearData($con, $year_id)
	{
		mysql_query("DELETE from tbl_year where year_id = " . (int) $year_id, $con);
	}

	/*
	* @delete car color data
	*/
	public function deleteCarColorData($con, $color_id)
	{
		mysql_query("DELETE from tbl_carcolor where color_id = '" . (int) $color_id . "'", $con);
	}

	/*
	* @delete car door data
	*/
	public function deleteCarDoorData($con, $door_id)
	{
		mysql_query("DELETE from tbl_cardoor where door_id = '" . (int) $door_id . "'", $con);
	}

	/*
	* @delete supplier info
	*/
	public function deletePersoInfo($con, $p_id)
	{
		mysql_query("DELETE FROM `tbl_add_personnel` WHERE perso_id = " . (int) $p_id, $con);
	}

	public function deleteBonCmdeInfo($con, $bcde_id)
	{
		mysql_query("DELETE FROM `tbl_add_boncmde` WHERE boncmde_id = " . (int) $bcde_id, $con);
	}

	/*
	* @delete supplier info
	*/
	public function deleteSupplierInformation($con, $s_id)
	{
		mysql_query("DELETE FROM `tbl_add_supplier` WHERE supplier_id = " . (int) $s_id, $con);
	}

	/*
	* @delete parts list data
	*/
	public function deleteBuyPartsInformation($con, $invoice_id)
	{
		mysql_query("DELETE FROM `tbl_parts_stock` WHERE invoice_id = " . trim($invoice_id), $con);
	}

	/*
	* @delete parts from stock
	*/
	// public function deleteStockPartsInformation($con, $parts_id)
	// {
	// 	mysql_query("DELETE FROM `tbl_parts_stock_manage` WHERE parts_id = " . (int)$parts_id, $con);
	// }

	public function deleteStockPartsInformation($con, $parts_id)
	{
		mysql_query("DELETE FROM `tbl_piece_stock` WHERE piece_stock_id = " . (int) $parts_id, $con);
		mysql_query("DELETE FROM `tbl_add_piece` WHERE add_piece_id = " . (int) $parts_id, $con);
	}

	/*
	* @delete parts list data
	*/
	public function deleteCarInformation($con, $car_id)
	{
		mysql_query("DELETE FROM `tbl_buycar` WHERE buycar_id = " . (int) $car_id, $con);
	}

	/*
	* @delete customer
	*/
	public function deleteCustomer($con, $cid)
	{
		mysql_query("DELETE FROM `tbl_add_customer` WHERE customer_id = " . (int) $cid, $con);
	}

	public function deleteutilisateurInformation($con, $uid)
	{
		mysql_query("DELETE FROM `tbl_add_user` WHERE usr_id = " . (int) $uid, $con);
	}

	/*
	* @delete work status
	*/
	public function deleteWorkStatus($con, $wid)
	{
		mysql_query("DELETE FROM `tbl_daily_work` WHERE work_id = " . (int) $wid, $con);
	}

	/*
	* @delete mechanice salery
	*/
	public function deleteMechanicSalery($con, $sid)
	{
		mysql_query("DELETE FROM `tbl_mcncsslary` WHERE m_salary_id = " . (int) $sid, $con);
	}

	/*
	* @delete Voiture de réparation
	*/
	public function deleteRepairCar($con, $cid)
	{
		mysql_query("DELETE FROM `tbl_add_car` WHERE car_id = " . (int) $cid, $con);
	}

	/*
	* @contact us reply email
	*/
	public function sendContactReplyEmail($con, $to, $subject, $details)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array('logo' => WEB_URL . 'img/logo.png', 'site_url' => WEB_URL, 'site_name' => $site_config_data['site_name'], 'subject' => $subject, 'message' => $details);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_contact_us_reply.html', $variables);
		$result = mail($to, $subject, $message, $headers);
		return $result;
	}

	/*
	* @forgot email
	*/
	public function sendForgotPasswordEmail($con, $to, $subject, $details)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$from = $site_config_data['email'];
		$variables = array('logo' => WEB_URL . 'img/logo.png', 'site_url' => WEB_URL, 'site_name' => $site_config_data['site_name'], 'subject' => $subject, 'message' => $details);
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_forgot_password.html', $variables);
		mail($to, $subject, $message, $headers);
	}

	/*
	* @contact us email
	*/
	public function sendContactUSEmail($con, $name, $from, $subject, $details)
	{
		$site_config_data = $this->getWebsiteSettingsInformation($con);
		$variables = array('logo' => WEB_URL . 'img/logo.png', 'site_url' => WEB_URL, 'site_name' => $site_config_data['site_name'], 'name' => $name, 'email' => $from, 'subject' => $subject, 'message' => $details);
		$to = $site_config_data['email'];
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = $this->loadEmailTemplate('tmp_contact_us.html', $variables);
		mail($to, $subject, $message, $headers);
	}

	/*
	* @customer custom email function
	*/
	public function sendCustomerCustomEmail($from, $to, $subject, $details)
	{
		$headers = "From: " . strip_tags($from) . "\r\n";
		$headers .= "Reply-To: " . strip_tags($from) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$message = '<html><body>';
		$message .= '<div style="border-bottom:solid 1px #666;"><img src="' . WEB_URL . 'img/logo.png"></div><br/><br/>';
		$message .= '<div>' . $details . ',</div>';
		$message .= '</body></html>';
		mail($to, $subject, $message, $headers);
	}

	/*
	* @get estimate information with car and Détails du client for delivery
	*/
	public function getEstimateAndCarAndCustomerDetails($con, $estimate_no)
	{
		$data = array();
		if (!empty($estimate_no)) {
			$result = mysql_query("SELECT *,m.make_name,mo.model_name,y.year_name,c.image as car_image FROM tbl_car_estimate e INNER JOIN tbl_add_car c on c.car_id = e.car_id INNER JOIN tbl_add_customer ac on ac.customer_id = e.customer_id left join tbl_make m on m.make_id = c.car_make left join tbl_model mo on mo.model_id = c.car_model left join tbl_year y on y.year_id = c.year WHERE e.estimate_no = '" . trim($estimate_no) . "'", $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	/*
	* @get sell information for invoice view
	*/
	public function carSellInvoiceGenerate($con, $invoice_no)
	{
		$data = array();
		if (!empty($invoice_no)) {
			$result = mysql_query("SELECT * FROM tbl_carsell WHERE invoice_id = '" . trim($invoice_no) . "'", $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	/*
	* @get sell information for based on sold if
	*/
	public function carSoldDetailsBasedOnSellId($con, $sell_id)
	{
		$data = array();
		if (!empty($sell_id)) {
			$result = mysql_query("SELECT * FROM tbl_carsell WHERE carsell_id = '" . (int) $sell_id . "'", $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	/*
	* @get sell car information
	*/
	public function getSellCarInformationList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_carsell cs left join tbl_buycar bc on bc.buycar_id = cs.car_id WHERE cs.is_return = 0 ORDER BY cs.carsell_id ASC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @car return
	*/
	public function returnSellCarInformation($con, $rid, $rcarid)
	{
		mysql_query("UPDATE tbl_carsell SET is_return = 1 WHERE carsell_id = " . (int) $rid, $con);
		mysql_query("UPDATE tbl_buycar SET car_status = 0 WHERE buycar_id = " . (int) $rcarid, $con);
	}

	/*
	* @delete car sell information
	*/
	public function deleteCarSellInformation($con, $id)
	{
		mysql_query("DELETE FROM `tbl_carsell` WHERE carsell_id = " . (int) $id, $con);
	}

	/*
	* @save car sell information
	*/
	public function saveCarSaleInformatiom($con, $data)
	{
		if (!empty($data)) {
			$query = "INSERT INTO tbl_carsell(car_id,buyer_name,buyer_mobile,buyer_email,sellernid,company_name,ctl, present_address,permanent_address,selling_price,advance_amount,due_amount,selling_date,sell_note,invoice_id,car_name,make_name, model_name, year_name, color_name, door_name, car_condition, car_totalmileage, car_chasis_no, car_engine_name, service_warranty) values('$data[carid]','$data[txtBuyerName]','$data[txtMobile]','$data[txtEmail]','$data[txtNid]','$data[txtCompanyname]','$data[txtCTL]','$data[txtprestAddress]','$data[txtpermanentAddress]','$data[txtSellPrice]','$data[txtAdvanceamount]','$data[due_amount]','" . $this->datepickerDateToMySqlDate($data['txtSellDate']) . "','$data[txtSellnote]','$data[invoice_id]','$data[_car_name]','$data[_make]','$data[_model]','$data[_year]','$data[_color]','$data[_door]','$data[_condition]','$data[_total_mileage]','$data[_chasis_no]','$data[_engine_name]','$data[ddlServiceWarranty]')";
			mysql_query($query, $con);

			//update sold status
			$query_sold = "UPDATE tbl_buycar set car_status = 1 WHERE buycar_id = " . (int) $_POST['carid'];
			mysql_query($query_sold, $con);
		}
	}

	/*
	* @update car sell information
	*/
	public function updateCarSaleInformatiom($con, $data)
	{
		if (!empty($data)) {
			$query = "UPDATE `tbl_carsell` SET `car_id`='" . $data['carid'] . "',`buyer_name`='" . $data['txtBuyerName'] . "',`buyer_mobile`='" . $data['txtMobile'] . "',`buyer_email`='" . $data['txtEmail'] . "',`sellernid`='" . $data['txtNid'] . "',`company_name`='" . $data['txtCompanyname'] . "',`ctl`='" . $data['txtCTL'] . "',`present_address`='" . $data['txtprestAddress'] . "',`permanent_address`='" . $data['txtpermanentAddress'] . "',`selling_price`='" . $data['txtSellPrice'] . "',`advance_amount`='" . $data['txtAdvanceamount'] . "',`selling_date`='" . $this->datepickerDateToMySqlDate($data['txtSellDate']) . "',`sell_note`='" . $data['txtSellnote'] . "',`service_warranty`='" . $data['ddlServiceWarranty'] . "',`selling_price`='" . $data['txtSellPrice'] . "',`advance_amount`='" . $data['txtAdvanceamount'] . "',`due_amount`='" . $data['due_amount'] . "' WHERE carsell_id='" . $data['hdn'] . "'";
			mysql_query($query, $con);
		}
	}

	/*
	* @ajax update estimate Data
	*/
	public function ajaxUpdateEstimateData($con, $data)
	{
		if (!empty($data)) {
			mysql_query("UPDATE tbl_car_estimate SET delivery_status = '" . (int) $data['deliver'] . "', discount = '" . (float) $data['discount'] . "',payment_done = '" . (float) $data['payment_done'] . "', payment_due = '" . (float) $data['payment_due'] . "', grand_total = '" . (float) $data['grand_total'] . "', delivery_done_date = '" . $this->datepickerDateToMySqlDate($data['deliver_date']) . "' WHERE car_id = '" . (int) $data['car_id'] . "' AND estimate_no = '" . (string) $data['estimate_no'] . "' AND customer_id = '" . (string) $data['customer_id'] . "'", $con);
		}
	}

	public function getRepairCarEstimateData($con, $estimate_no)
	{
		$data = array();
		if (!empty($estimate_no)) {
			$result = mysql_query("SELECT * FROM tbl_car_estimate WHERE estimate_no = '" . trim($estimate_no) . "'", $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	public function getRepairCarAllEstimateData($con, $car_id, $customer_id)
	{
		$data = array();
		if (!empty($car_id)) {
			$result = mysql_query("SELECT * FROM tbl_car_estimate WHERE car_id = '" . (int) $car_id . "' AND customer_id = '" . (int) $customer_id . "' ORDER BY estimate_id DESC", $con);
			while ($row = mysql_fetch_array($result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	/*
	* @get customer all estimate list
	*/
	public function getAllRepairCarEstimateList($con, $customer_id)
	{
		$data = array();
		if (!empty($customer_id)) {
			$result = mysql_query("SELECT * FROM tbl_car_estimate WHERE customer_id = '" . (int) $customer_id . "' ORDER BY estimate_id DESC", $con);
			while ($row = mysql_fetch_array($result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	/*
	* @filter Vendre une liste de pièces
	*/
	public function filterSellPartsList($con, $query)
	{
		$data = array();
		if (!empty($query)) {
			$result = mysql_query($query, $con);
			while ($row = mysql_fetch_array($result)) {
				$data[] = $row;
			}
		}
		return $data;
	}

	/*added some changes*/
	public function saveUpdateCarEstimateDate($con, $data = array())
	{
		$row = $this->getRepairCarEstimateData($con, $data['estimate_no']);
		if (!empty($row) && count($row) > 0) {
			//update
			mysql_query("UPDATE tbl_car_estimate SET estimate_data = '" . (string) $data['estimate_data'] . "', job_status = '" . (int) $data['job_status'] . "', work_status = '" . (int) $data['work_status'] . "', total_cost = '" . (float) $data['total_cost'] . "', payment_due = '" . (float) $data['payment_due'] . "', grand_total = '" . (float) $data['grand_total'] . "', estimate_delivery_date = '" . $data['estimate_delivery_date'] . "' WHERE estimate_no = '" . (string) trim($data['estimate_no']) . "' AND customer_id = '" . (int) $data['customer_id'] . "' AND car_id = '" . (int) $data['car_id'] . "'", $con);
		} else {
			//insert;
			mysql_query("INSERT INTO `tbl_car_estimate`(`estimate_no`, `car_id`, `work_status`, `job_status`, `estimate_data`, `total_cost`, `payment_due`, `grand_total`, `customer_id`, `created_date`, `estimate_delivery_date`) VALUES ('" . trim($data['estimate_no']) . "','" . $data['car_id'] . "','" . $data['work_status'] . "','" . $data['job_status'] . "','" . $data['estimate_data'] . "','" . $data['total_cost'] . "','" . $data['payment_due'] . "','" . $data['grand_total'] . "','" . $data['customer_id'] . "','" . date('Y-m-d H:i:s') . "','" . $data['estimate_delivery_date'] . "')", $con);
		}
	}

	/*
	* @insert parts checkout data
	*/
	public function savePartsCheckoutData($con, $data)
	{
		if (isset($_SESSION['parts_cart']) && !empty($_SESSION['parts_cart'])) {
			mysql_query("INSERT INTO tbl_parts_sold_invoice(invoice_id, total, discount, paid_amount, due_amount, grand_total, customer_name, telephone, email, company_name, customer_address, delivery_address, note, invoice_date) values('$data[invoice_id]', '$data[total]', '$data[discount]', '$data[paid_amount]', '$data[due_amount]', '$data[grand_total]', '$data[customer_name]', '$data[telephone]', '$data[email]', '$data[company_name]', '$data[customer_address]', '$data[delivery_address]', '$data[note]', '$data[invoice_date]')", $con);
			$sold_id = mysql_insert_id();
			foreach ($_SESSION['parts_cart'] as $cartdata) {
				mysql_query("INSERT INTO tbl_parts_sell(sold_id, parts_name, parts_warranty, parts_id, quantity, parts_price,parts_condition) values($sold_id, '$cartdata[name]', '$cartdata[warranty]', '$cartdata[parts_id]', '$cartdata[qty]', '$cartdata[price]', '$cartdata[condition]')", $con);
				$result_parts = mysql_query("SELECT * FROM tbl_parts_stock_manage where parts_id=" . (int) $cartdata['parts_id'], $con);
				if ($row_parts = mysql_fetch_array($result_parts)) {
					$qty = $row_parts['quantity'];
					if ((int) $qty > 0) {
						$qty = (int) $qty - (int) $cartdata['qty'];
						mysql_query("UPDATE tbl_parts_stock_manage SET quantity=" . (int) $qty . " WHERE parts_id=" . (int) $cartdata['parts_id'], $con);
					}
				}
			}
			unset($_SESSION['parts_cart']);
		} else {
			echo 'ohh no session expired';
			die();
		}
	}

	/*
	* @insert parts checkout data
	*/
	public function updatePartsCheckoutData($con, $data)
	{
		mysql_query("UPDATE tbl_parts_sold_invoice SET total='$data[total]', discount='$data[discount]', paid_amount='$data[paid_amount]', due_amount='$data[due_amount]', grand_total='$data[grand_total]', customer_name='$data[customer_name]', telephone='$data[telephone]', email='$data[email]', company_name='$data[company_name]', customer_address='$data[customer_address]', delivery_address='$data[delivery_address]', note='$data[note]', invoice_date='$data[invoice_date]' WHERE sold_id=$data[sold_id]");
	}

	/*
	* @delete sold parts and recover
	*/
	public function deleteAndReturnPartsData($con, $sold_id, $parts_id, $sold_qty = 0)
	{
		$result_parts = mysql_query("SELECT * FROM tbl_parts_stock where parts_id=" . (int) $parts_id, $con);
		if ($row_parts = mysql_fetch_array($result_parts)) {
			$qty = (int) $row_parts['parts_quantity'] + (int) $sold_qty;
			mysql_query("UPDATE tbl_parts_stock SET parts_quantity=" . (int) $qty . " WHERE parts_id=" . (int) $parts_id, $con);
		}
		mysql_query("DELETE FROM tbl_parts_sell WHERE sold_id=" . (int) $sold_id . " AND parts_id=" . (int) $parts_id, $con);
	}

	/*
	* @parts sell details by id
	*/
	public function getSellPartsInformationBySellId($con, $psid)
	{
		$data = array();
		if (!empty($psid)) {
			$result = mysql_query("SELECT *,pas.parts_name,pas.parts_condition,pas.parts_warranty,pas.parts_sku FROM tbl_parts_sell ps INNER JOIN tbl_parts_stock pas on pas.parts_id = ps.parts_id where ps.parts_sell_id=" . (int) $psid, $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	/*
	* @parts sold details by invoiceId
	*/
	public function getSoldPartsInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,(SELECT count(sold_id) FROM tbl_parts_sell ps WHERE ps.sold_id = si.sold_id) as total_parts FROM tbl_parts_sold_invoice si order by si.invoice_date DESC", $con);
		while ($row_parts = mysql_fetch_assoc($result)) {
			$data[] = $row_parts;
		}
		return $data;
	}

	/*
	* @delete parts sold information
	*/
	public function deletePartsSoldItem($con, $sold_id)
	{
		mysql_query("DELETE FROM `tbl_parts_sold_invoice` WHERE sold_id = " . (int) $sold_id, $con);
		mysql_query("DELETE FROM `tbl_parts_sell` WHERE sold_id = " . (int) $sold_id, $con);
	}

	/*
	* @parts sold details by invoiceId
	*/
	public function getSellPartsInformationByInvoiceId($con, $invoiceId)
	{
		$data = array();
		if (!empty($invoiceId)) {
			$result = mysql_query("SELECT * FROM tbl_parts_sold_invoice WHERE invoice_id =" . (int) $invoiceId, $con);
			if ($row = mysql_fetch_assoc($result)) {
				$data['invoice'] = $row;
				$result_parts = mysql_query("SELECT * FROM tbl_parts_sell WHERE sold_id =" . (int) $row['sold_id'], $con);
				$gtotal = 0;
				while ($row_parts = mysql_fetch_assoc($result_parts)) {
					$xtotal = (float) $row_parts['parts_price'] * (int) $row_parts['quantity'];
					$data['parts'][] = array(
						'parts_id'			=> $row_parts['parts_id'],
						'parts_name'		=> $row_parts['parts_name'],
						'parts_warranty'	=> $row_parts['parts_warranty'],
						'parts_condition'	=> $row_parts['parts_condition'],
						'quantity'			=> $row_parts['quantity'],
						'parts_price'		=> $row_parts['parts_price'],
						'total'				=> number_format($xtotal, 2)
					);
					$gtotal += (float) $xtotal;
				}
				$data['total'] = number_format($gtotal, 2);
			}
		}
		return $data;
	}

	/*
	* @parts purchase details by invoiceId
	*/
	public function getPurchasePartsInformationByInvoiceId($con, $invoiceId)
	{
		$data = array();
		if (!empty($invoiceId)) {
			$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name,s.s_name as supplier_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id WHERE invoice_id = '" . trim($invoiceId) . "'", $con);
			if ($row = mysql_fetch_array($result)) {
				$data = $row;
			}
		}
		return $data;
	}

	/*
	* @parts sold details by invoiceId
	*/
	public function getSellPartsInformationBySoldId($con, $sold_id)
	{
		$data = array();
		if (!empty($sold_id)) {
			$result = mysql_query("SELECT * FROM tbl_parts_sold_invoice WHERE sold_id =" . (int) $sold_id, $con);
			if ($row = mysql_fetch_assoc($result)) {
				$data['invoice'] = $row;
				$result_parts = mysql_query("SELECT * FROM tbl_parts_sell WHERE sold_id =" . (int) $sold_id, $con);
				$gtotal = 0;
				while ($row_parts = mysql_fetch_assoc($result_parts)) {
					$xtotal = (float) $row_parts['parts_price'] * (int) $row_parts['quantity'];
					$data['parts'][] = array(
						'parts_id'			=> $row_parts['parts_id'],
						'parts_name'		=> $row_parts['parts_name'],
						'parts_warranty'	=> $row_parts['parts_warranty'],
						'quantity'			=> $row_parts['quantity'],
						'parts_price'		=> $row_parts['parts_price'],
						'total'				=> number_format($xtotal, 2)
					);
					$gtotal += (float) $xtotal;
				}
				$data['total'] = number_format($gtotal, 2);
			}
		}
		return $data;
	}

	/*
	* @mini cart html load
	*/
	public function loadMiniCartHtml()
	{
		$data = 0;
		if (isset($_SESSION['parts_cart']) && !empty($_SESSION['parts_cart'])) {
			foreach ($_SESSION['parts_cart'] as $cartdata) {
				$data += (int) $cartdata['qty'];
			}
		}
		return $data;
	}

	/*
	* @retrieve shopping cart html
	*/
	public function getShoppingCartDate($con)
	{
		$html = '';
		if (isset($_SESSION['parts_cart']) && !empty($_SESSION['parts_cart'])) {
			$total = 0;
			$settings = $this->getWebsiteSettingsInformation($con);
			foreach ($_SESSION['parts_cart'] as $cartdata) {
				$parts_total = (float) $cartdata['price'] * $cartdata['qty'];
				$total += (float) $parts_total;
				$parts_total = number_format($parts_total, 2);
				$parts_info = $this->getPartsInformationById($cartdata['parts_id'], $con);
				$html .= "<tr>";
				$html .= "	<td><img class='img-thumbnail' style='width:70px;' src='" . $parts_info['parts_image'] . "'></td>";
				$html .= "	<td>" . $parts_info['parts_name'] . "</td>";
				$html .= "	<td>" . $parts_info['parts_warranty'] . "</td>";
				$html .= "	<td style='text-transform:capitalize;'>" . $parts_info['parts_condition'] . "</td>";
				$html .= "	<td>" . $settings['currency'] . $cartdata['price'] . "</td>";
				$html .= "	<td>" . $cartdata['qty'] . "</td>";
				$html .= "	<td><b>" . $settings['currency'] . $parts_total . "</b></td>";
				$html .= "	<td><a href='javascript:;' onclick='deleteCartParts(" . $cartdata['parts_id'] . ");' class='btn btn-danger'><i class='fa fa-trash'></a></a></td>";
				$html .= "</tr>";
			}
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Total: </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . number_format($total, 2) . "</b><input type='hidden' id='hdntotal' name='hdntotal' value='" . $total . "'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Discount (%): </b></td>";
			$html .= "	<td><input type='text' class='allownumberonly'' style='text-align:left;font-weight:bold;border:none;border-bottom:solid 1px #ccc;' size='8' name='txtSellDiscount' value='0.00' id='txtSellDiscount'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Montant payé (" . $settings['currency'] . "): </b></td>";
			$html .= "	<td><input type='text' class='allownumberonly' style='text-align:left;font-weight:bold;border:none;border-bottom:solid 1px #ccc;' size='8' name='txtSellPaidamount' value='0' id='txtSellPaidamount'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Montant dû : </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . "<span id='due_amount'>" . number_format($total, 2) . "</span></b></td>";
			$html .= "	<td>&nbsp;<input type='hidden' name='hdn_due_amount' id='hdn_due_amount' value='" . $total . "'></td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Grand Total: </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . "<span id='grand_total'>" . number_format($total, 2) . "</span></b></td>";
			$html .= "	<td>&nbsp;<input type='hidden' name='hdn_grand_total' id='hdn_grand_total' value='" . number_format($total, 2) . "'></td>";
			$html .= "</tr>";
		}
		return $html;
	}

	/*
	* @retrieve shopping cart html based on sold id
	*/
	public function getShoppingCartHtmlBasedOnSoldId($con, $cartInfo, $discount, $due_amount, $paid_amount, $grand_total, $sold_id)
	{
		$html = '';
		if (!empty($cartInfo)) {
			$total = 0;
			$grand_total = 0;
			$due_amount = 0;
			$settings = $this->getWebsiteSettingsInformation($con);
			foreach ($cartInfo as $cartdata) {
				$parts_total = (float) $cartdata['parts_price'] * $cartdata['quantity'];
				$total += (float) $parts_total;
				$parts_total = number_format($parts_total, 2);
				$parts_info = $this->getPartsInformationById($cartdata['parts_id'], $con);
				$html .= "<tr>";
				$html .= "	<td><img class='img-thumbnail' style='width:70px;' src='" . $parts_info['parts_image'] . "'></td>";
				$html .= "	<td>" . $parts_info['parts_name'] . "</td>";
				$html .= "	<td>" . $parts_info['parts_warranty'] . "</td>";
				$html .= "	<td style='text-transform:capitalize;'>" . $parts_info['parts_condition'] . "</td>";
				$html .= "	<td>" . $settings['currency'] . $cartdata['parts_price'] . "</td>";
				$html .= "	<td>" . $cartdata['quantity'] . "</td>";
				$html .= "	<td><b>" . $settings['currency'] . $parts_total . "</b></td>";
				$html .= "	<td><a href='javascript:;' onclick='deleteCartPartsAfterSold(" . $sold_id . "," . $cartdata['parts_id'] . "," . $cartdata['quantity'] . ");' class='btn btn-danger'><i class='fa fa-trash'></a></a></td>";
				$html .= "</tr>";
			}
			/*Discount*/
			if ((float) $discount > 0) {
				$grand_total = (float) ((float) $total - (float) ((float) ((float) $total * (float) $discount) / 100));
			} else {
				$grand_total = $total;
			}
			if ((float) $paid_amount > 0) {
				$due_amount = (float) $grand_total - (float) $paid_amount;
			}
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Total: </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . number_format($total, 2) . "</b><input type='hidden' id='hdntotal' name='hdntotal' value='" . $total . "'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Discount (%): </b></td>";
			$html .= "	<td><input type='text' class='allownumberonly'' style='text-align:left;font-weight:bold;border:none;border-bottom:solid 1px #ccc;' size='8' name='txtSellDiscount' value='" . $discount . "' id='txtSellDiscount'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Montant payé (" . $settings['currency'] . "): </b></td>";
			$html .= "	<td><input type='text' class='allownumberonly' style='text-align:left;font-weight:bold;border:none;border-bottom:solid 1px #ccc;' size='8' name='txtSellPaidamount' value='" . $paid_amount . "' id='txtSellPaidamount'></td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Montant dû : </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . "<span id='due_amount'>" . number_format($due_amount, 2) . "</span></b></td>";
			$html .= "	<td>&nbsp;<input type='hidden' name='hdn_due_amount' id='hdn_due_amount' value='" . number_format($due_amount, 2) . "'></td>";
			$html .= "</tr>";
			$html .= "<tr>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td>&nbsp;</td>";
			$html .= "	<td align='right'><b>Grand Total: </b></td>";
			$html .= "	<td><b>" . $settings['currency'] . "<span id='grand_total'>" . number_format($grand_total, 2) . "</span></b></td>";
			$html .= "	<td>&nbsp;<input type='hidden' name='hdn_grand_total' id='hdn_grand_total' value='" . number_format($grand_total, 2) . "'></td>";
			$html .= "</tr>";
		}
		return $html;
	}

	/*
	* @CMS menu work
	*/
	public function getMenuList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,(select menu_name from tbl_menu me where me.menu_id = m.parent_id) as p_menu FROM tbl_menu m LEFT JOIN tbl_cms c ON c.cms_id = m.cms_page order by m.menu_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	/*
	* @get parent menu list
	*/
	public function getParentMenuList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_menu where parent_id = 0 order by menu_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	/*
	* @get cms page list
	*/
	public function getCMSPageList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_cms order by page_title", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all service list
	*/
	public function getServiceList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_service ORDER BY sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all active service list
	*/
	public function getAllActiveServiceList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.seo_url FROM tbl_service s LEFT JOIN tbl_cms c ON c.cms_id = s.page_id WHERE s.status = 1 ORDER BY sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all slider list
	*/
	public function getAllSliderList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM  tbl_slider order by sort_id ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all Comments list
	*/
	public function getAllCommentsList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_customer_comments order by comments_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all News Comments list
	*/
	public function getAllNewsCommentsList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,b.blog_title FROM tbl_blog_comments bc INNER JOIN tbl_blog b ON b.blog_id = bc.blog_id order by bc.blog_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all home view Comments list
	*/
	public function getAllActiveCommentsList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_customer_comments WHERE status = 1 AND approve = 1 order by comments_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image = '';
			if ($row['image_url'] != '') {
				$image = WEB_URL . 'img/comments/' . $row['image_url'];
			}
			$data[] = array(
				'comments'		=> $row['comments'],
				'author'		=> $row['author'],
				'profession'	=> $row['profession'],
				'image_url'		=> $image
			);
		}
		return $data;
	}

	/*
	* @get all active slider list
	*/
	public function getAllActiveSliderList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_slider WHERE status = 1 ORDER BY sort_id ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all mechanics deg list
	*/
	public function getMechanicsDesignation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_mechanics_designation ORDER BY title ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get frontend menu array
	*/
	public function getFrontentMenuList($con)
	{
		$menu_array = array();
		$result = mysql_query("select *,c.seo_url from tbl_menu m LEFT JOIN tbl_cms c ON c.cms_id = m.cms_page where m.parent_id = 0 and m.menu_status= 1 order by m.menu_sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			//1 label
			$href_parent = '';
			$child_menu = array();
			$result_child = mysql_query("select *,c.seo_url from tbl_menu m LEFT JOIN tbl_cms c ON c.cms_id = m.cms_page where m.parent_id = '" . $row['menu_id'] . "' and m.menu_status= 1 order by m.menu_sort_order ASC", $con);
			while ($row_child = mysql_fetch_assoc($result_child)) {
				$href_child = '';
				if (!empty($row['fixed_page_url'])) {
					$href_child = $row['fixed_page_url'];
				} else {
					$href_child = $row_child['seo_url'];
				}
				$child_menu[] = array(
					'menu_id'			=> $row_child['menu_id'],
					'parent_id'			=> $row_child['parent_id'],
					'menu_name'			=> $row_child['menu_name'],
					'menu_sort_order'	=> $row_child['menu_sort_order'],
					'href'				=> $href_child,
					'menu_status'		=> $row_child['menu_status']
				);
			}
			if (!empty($row['fixed_page_url'])) {
				$href_parent = $row['fixed_page_url'];
			} else {
				$href_parent = $row['seo_url'];
			}
			$menu_array[] = array(
				'menu_id'			=> $row['menu_id'],
				'parent_id'			=> $row['parent_id'],
				'menu_name'			=> $row['menu_name'],
				'menu_sort_order'	=> $row['menu_sort_order'],
				'href'				=> $href_parent,
				'menu_status'		=> $row['menu_status'],
				'url_slug'			=> $row['url_slug'],
				'child_menu'		=> $child_menu
			);
		}
		return $menu_array;
	}

	/*
	* @save/update service information
	*/
	public function saveUpdateServiceInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			$cmspage = 0;
			if (isset($data['rbCMSPage']) && is_numeric($data['rbCMSPage']) && (int) $data['rbCMSPage'] > 0) {
				$cmspage = $data['rbCMSPage'];
			}
			if ($data['service_id'] == '0') {
				mysql_query("INSERT INTO tbl_service(service_name,image_url,short_description,page_id,sort_order,status) values('$data[service_title]','$image_url','$data[service_sort_desc]','$data[service_description]','$cmspage','$data[sort_order]','$data[status]')", $con);
			} else {
				mysql_query("UPDATE tbl_service SET service_name='$data[service_title]',image_url='$image_url',short_description='$data[service_sort_desc]',page_id='$cmspage',sort_order='$data[sort_order]',status='$data[status]' WHERE service_id=$data[service_id]", $con);
			}
		}
	}

	/*
	* @save/update cms information
	*/
	public function saveUpdateCMSInformation($con, $data)
	{
		if (!empty($data)) {
			$seo_url = '';
			$desc = mysql_real_escape_string($data['txtCmcontent']);
			if (!empty($data['txtSeo'])) {
				$seo_url = $data['txtSeo'];
			} else {
				$seo_url = $this->generateSeoUrl($data['txtPtitle']);
			}
			if ($data['cms_id'] == '0') {
				mysql_query("INSERT INTO tbl_cms(page_title,seo_url,cms_status,page_details) values('$data[txtPtitle]','$seo_url','$data[txtStatus]','$desc')", $con);
			} else {
				mysql_query("UPDATE `tbl_cms` SET `page_title`='" . $data['txtPtitle'] . "',`seo_url`='" . $seo_url . "',`cms_status`='" . $data['txtStatus'] . "',`page_details`='" . $desc . "' WHERE cms_id='" . (int) $data['cms_id'] . "'", $con);
			}
		}
	}

	/*
	* @get service info by id
	*/
	public function getServiceInfoByServiceId($con, $service_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_service where service_id = '" . (int) $service_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get slider info by id
	*/
	public function getSliderInfoBySliderId($con, $slider_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_slider where slider_id = '" . (int) $slider_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get comments info by id
	*/
	public function getCommentsInfoByCommentsId($con, $comments_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_customer_comments where comments_id = '" . (int) $comments_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get comments info by id
	*/
	public function getNewsCommentsInfoByCommentsId($con, $comments_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_blog_comments where comments_id = '" . (int) $comments_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @gallery home view
	*/
	public function getBlogAllCommentsByBlogId($con, $blog_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_blog_comments WHERE status = 1 AND approve = 1 AND blog_id = " . (int) $blog_id . " ORDER BY comments_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image = WEB_URL . 'img/no_comment.png';
			if ($row['image'] != '' && file_exists(ROOT_PATH . 'img/upload/' . $row['image'])) {
				$image = WEB_URL . 'img/upload/' . $row['image'];
			}
			$phpdate = strtotime($row['comments_date']);
			$mysqldate = date('d F Y', $phpdate);
			$data[] = array(
				'name'			=> $row['name'],
				'email'			=> $row['email'],
				'comments'		=> $row['comments'],
				'image'			=> $image,
				'status'		=> $row['status'],
				'comments_date'	=> $mysqldate
			);
		}
		return $data;
	}

	/*
	* @delete service
	*/
	public function deleteService($con, $service_id)
	{
		mysql_query("DELETE FROM tbl_service where service_id = '" . (int) $service_id . "'", $con);
	}

	/*
	* @delete slider
	*/
	public function deleteSlider($con, $slider_id)
	{
		mysql_query("DELETE FROM tbl_slider where slider_id = '" . (int) $slider_id . "'", $con);
	}

	/*
	* @delete comments
	*/
	public function deleteComments($con, $comments_id)
	{
		mysql_query("DELETE FROM tbl_customer_comments where comments_id = '" . (int) $comments_id . "'", $con);
	}

	/*
	* @delete news comments
	*/
	public function deleteNewsComments($con, $comments_id)
	{
		mysql_query("DELETE FROM tbl_blog_comments where comments_id = '" . (int) $comments_id . "'", $con);
	}

	/*
	* @delete gallery
	*/
	public function deleteGallery($con, $gallery_id)
	{
		mysql_query("DELETE FROM tbl_gallery_category where gallery_id = '" . (int) $gallery_id . "'", $con);
		mysql_query("DELETE FROM tbl_gallery_images where category_id = '" . (int) $gallery_id . "'", $con);
	}

	/*
	* @delete cms
	*/
	public function deleteCMS($con, $cms_id)
	{
		mysql_query("DELETE FROM `tbl_cms` WHERE cms_id = " . (int) $cms_id, $con);
	}

	/*
	* @save/update slider information
	*/
	public function saveUpdateSliderInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['slider_id'] == '0') {
				mysql_query("INSERT INTO tbl_slider(slider_text,slider_url,html_text,slider_image,sort_id,status) values('$data[txtStext]','$data[txtSurl]','$data[html_text]','$image_url','$data[txtSid]','$data[status]')", $con);
			} else {
				mysql_query("UPDATE tbl_slider SET slider_text='$data[txtStext]',slider_url='$data[txtSurl]',html_text='$data[html_text]',slider_image='$image_url',sort_id='$data[txtSid]',status='$data[status]' WHERE slider_id=$data[slider_id]", $con);
			}
		}
	}


	/*
	* @save/update customer news comments
	*/
	public function saveUpdateNewsCommentsInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			$approve = 0;
			if (isset($data['chkApprove']) && $data['chkApprove'] == 'on') {
				$approve = 1;
			}
			$added_date = date('Y-m-d');
			$desc = mysql_real_escape_string($data['txtComments']);
			if ($data['comments_id'] == '0') {
				mysql_query("INSERT INTO  tbl_blog_comments(blog_id,name,email,comments,image,approve,status,comments_date) values('$data[ddlBlog]','$data[txtAuthorName]','$data[txtEmail]','$desc','$image_url','$approve','$data[status]','$added_date')", $con);
			} else {
				mysql_query("UPDATE  tbl_blog_comments SET blog_id='$data[ddlBlog]',name='$data[txtAuthorName]',email='$data[txtEmail]',comments='$desc',image='$image_url',approve='$approve',status='$data[status]',comments_date='$added_date' WHERE comments_id=$data[comments_id]", $con);
			}
		}
	}


	/*
	* @save/update customer comments
	*/
	public function saveUpdateCommentsInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			$approve = 0;
			if (isset($data['chkApprove']) && $data['chkApprove'] == 'on') {
				$approve = 1;
			}
			if ($data['comments_id'] == '0') {
				mysql_query("INSERT INTO tbl_customer_comments(comments,author,profession,image_url,approve,status) values('$data[txtComments]','$data[txtAuthorName]','$data[txtAuthorProfession]','$image_url','$approve','$data[status]')", $con);
			} else {
				mysql_query("UPDATE tbl_customer_comments SET comments='$data[txtComments]',author='$data[txtAuthorName]',profession='$data[txtAuthorProfession]',image_url='$image_url',approve='$approve',status='$data[status]' WHERE comments_id=$data[comments_id]", $con);
			}
		}
	}

	/*
	* @save/update gallery category
	*/
	public function saveUpdateGalleryCategoryInformation($con, $data)
	{
		$gallery_id = 0;
		if (!empty($data)) {
			if ($data['gallery_id'] == '0') {
				mysql_query("INSERT INTO tbl_gallery_category(gallery_name,sort_order,status) values('$data[txtWorkCategoryName]','$data[txtSortOrder]','$data[status]')", $con);
				$gallery_id = mysql_insert_id();
			} else {
				mysql_query("UPDATE tbl_gallery_category SET gallery_name='$data[txtWorkCategoryName]',sort_order='$data[txtSortOrder]',status='$data[status]' WHERE gallery_id=$data[gallery_id]", $con);
				$gallery_id = $data['gallery_id'];
			}
		}
		if ($gallery_id > 0) {
			mysql_query("DELETE FROM  tbl_gallery_images where category_id = '" . (int) $gallery_id . "'", $con);
		}
		return $gallery_id;
	}

	/*
	* @gallery home view
	*/
	public function galleryHomeView($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_gallery_category WHERE status = 1 ORDER BY sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = array(
				'gallery_id'	=> $row['gallery_id'],
				'gallery_name'	=> $row['gallery_name'],
				'class'			=> $this->generateSeoUrl($row['gallery_name']),
				'sort_order'	=> $row['sort_order'],
				'status'		=> $row['status'],
				'images'		=> $this->getAllGalleryImagesByCategoryId($con, $row['gallery_id'])
			);
		}
		return $data;
	}

	/*
	* @save gallery images
	*/
	public function saveUpdateGalleryInformation($con, $data)
	{
		if (!empty($data)) {
			mysql_query("INSERT INTO tbl_gallery_images(category_id,image_url,text,sort_order) values('$data[category_id]','$data[image_url]','$data[text]','$data[sort_order]')", $con);
		}
	}

	/*
	* @get all gellery Information
	*/
	public function getAllGalleryInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_gallery_category ORDER BY gallery_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = array(
				'gallery_id'	=> $row['gallery_id'],
				'gallery_name'	=> $row['gallery_name'],
				'sort_order'	=> $row['sort_order'],
				'status'		=> $row['status'],
				'images'		=> $this->getAllGalleryImagesByCategoryId($con, $row['gallery_id'])
			);
		}
		return $data;
	}
	public function getAllGalleryImagesByCategoryId($con, $category_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_gallery_images WHERE category_id = " . (int) $category_id . " ORDER BY sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image = '';
			if ($row['image_url'] != '') {
				$image = WEB_URL . 'img/gallery/' . $row['image_url'];
			}
			$data[] = array(
				'image' 		=> $row['image_url'],
				'image_url' 	=> $image,
				'sort_order'	=> $row['sort_order'],
				'text'			=> $row['text']
			);
		}
		return $data;
	}
	public function getGalleryInformationById($con, $category_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_gallery_category WHERE gallery_id = " . (int) $category_id . " ORDER BY gallery_name ASC", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = array(
				'gallery_id'	=> $row['gallery_id'],
				'gallery_name'	=> $row['gallery_name'],
				'sort_order'	=> $row['sort_order'],
				'status'		=> $row['status'],
				'images'		=> $this->getAllGalleryImagesByCategoryId($con, $category_id)
			);
		}
		return $data;
	}

	/*
	* @save/update mechanics information
	*/
	public function saveUpdateMechanicsInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			$join_date = $this->datepickerDateToMySqlDate($data['txtJoiningDate']);
			if ($data['mechanics_id'] == '0') {
				$query = "INSERT INTO tbl_add_mechanics(m_name,m_cost,m_phone_number,m_password,m_email,m_present_address,m_permanent_address,m_notes,m_image,designation_id,status,joining_date, num_cni) 
				values('$data[txtSName]','$data[cost_per_month]','$data[txtPhonenumber]','$data[txtSPassword]','$data[txtSEmail]','$data[present_address]','$data[permanent_address]','$data[notes]','$image_url','$data[designation]','$data[status]','$join_date','$data[txtNCard]')";
				$result = mysql_query($query, $con);
			} else {
				$query = "UPDATE `tbl_add_mechanics` SET `m_name`='" . $data['txtSName'] . "',
				`m_cost`='" . $data['cost_per_month'] . "',`m_phone_number`='" . $data['txtPhonenumber'] . "',
				`m_password`='" . $data['txtSPassword'] . "',`m_email`='" . $data['txtSEmail'] . "',
				`m_present_address`='" . $data['present_address'] . "',`m_permanent_address`='" . $data['permanent_address'] . "',
				`m_notes`='" . $data['notes'] . "',`m_image`='" . $image_url . "',designation_id='" . $data['designation'] . "',
				status='" . $data['status'] . "',joining_date='" . $join_date . "'
				WHERE mechanics_id='" . (int) $data['mechanics_id'] . "'";
				$result = mysql_query($query, $con);
			}
		}

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	/*
	* @save/update mechanics information
	*/
	public function saveUpdateCustomerInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['customer_id'] == '0') {

				$query = "INSERT INTO tbl_add_customer(c_name,c_email, c_address,c_password,
				image, type_client, civilite_client, princ_tel, tel_wa, pj1_url, pj2_url, pj3_url, pj4_url, pj5_url,
				pj6_url, pj7_url, pj8_url, pj9_url, pj10_url, pj11_url, pj12_url
				) 
				values('$data[txtCName]','$data[txtCEmail]','$data[txtCAddress]','$data[txtCPassword]','$image_url',
				'$data[type_client]','$data[civilite_client]','$data[princ_tel]','$data[tel_wa]',
				'$data[pj1_client_url]','$data[pj2_client_url]','$data[pj3_client_url]','$data[pj4_client_url]','$data[pj5_client_url]',
				'$data[pj6_client_url]',null,null,null,null,null,null
				)";

				$result = mysql_query($query, $con);
			} else {
				$query = "UPDATE `tbl_add_customer` SET `c_name`='" . $data['txtCName'] . "',`c_email`='" . $data['txtCEmail'] . "',
				`c_address`='" . $data['txtCAddress'] . "',
				`c_password`='" . $data['txtCPassword'] . "',`image`='" . $image_url . "' ,
				`type_client`='" . $data['type_client'] . "', `civilite_client`='" . $data['civilite_client'] . "', 
				`princ_tel`='" . $data['princ_tel'] . "', `tel_wa`='" . $data['tel_wa'] . "',
				`pj1_url`='" . $data['pj1_url'] . "', `pj2_url`='" . $data['pj2_url'] . "', `pj3_url`='" . $data['pj3_url'] . "',
				`pj4_url`='" . $data['pj4_url'] . "', `pj5_url`='" . $data['pj5_url'] . "', `pj6_url`='" . $data['pj6_url'] . "'
				WHERE customer_id='" . (int) $data['customer_id'] . "'";
				$result = mysql_query($query, $con);
			}
		}

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	/*
	* @save/update mechanics work status
	*/
	public function saveUpdateMechanicsWorkStatus($con, $data)
	{
		if (!empty($data)) {
			if ($data['work_id'] == '0') {
				mysql_query("INSERT INTO tbl_daily_work(mechanic_id,work_date, total_hour, work_details) values('$data[mechanic_id]','" . $this->datepickerDateToMySqlDate($data['txtWorkDate']) . "','$data[txtTotalHour]','$data[txtWorkDetails]')", $con);
			} else {
				mysql_query("UPDATE `tbl_daily_work` SET `work_date`='" . $this->datepickerDateToMySqlDate($data['txtWorkDate']) . "',`total_hour`='" . $data['txtTotalHour'] . "',`work_details`='" . $data['txtWorkDetails'] . "' WHERE work_id='" . (int) $data['work_id'] . "'", $con);
			}
		}
	}

	/*
	* @Mettre à jour le profil de l'utilisateur
	*/
	public function updateAdminUserProfile($con, $data, $image_url)
	{
		if (!empty($data)) {
			mysql_query("UPDATE `tbl_admin` SET `name`='" . $data['txtUserName'] . "',`email`='" . $data['txtEmail'] . "',`password`='" . $data['txtPassword'] . "',`image`='" . $image_url . "' WHERE user_id = '" . (int) $data['hdnUserId'] . "'", $con);
		}
	}

	/*
	* @update mechanice profile
	*/
	public function updateMechanicesUserProfile($con, $data, $image_url)
	{
		if (!empty($data)) {
			mysql_query("UPDATE `tbl_add_mechanics` SET `m_name`='" . $data['txtUserName'] . "',`m_email`='" . $data['txtEmail'] . "',`m_password`='" . $data['txtPassword'] . "',`m_image`='" . $image_url . "' WHERE mechanics_id = '" . (int) $data['hdnUserId'] . "'", $con);
		}
	}

	/*
	* @update customer profile
	*/
	public function updateCustomerUserProfile($con, $data, $image_url)
	{
		if (!empty($data)) {
			mysql_query("UPDATE `tbl_add_customer` SET `c_name`='" . $data['txtUserName'] . "',`c_email`='" . $data['txtEmail'] . "',`c_password`='" . $data['txtPassword'] . "',`image`='" . $image_url . "' WHERE customer_id = '" . (int) $data['hdnUserId'] . "'", $con);
		}
	}

	/*
	* @save/update manufacturer information
	*/
	public function saveUpdateManufacturerInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['manufacturer_id'] == '0') {
				mysql_query("INSERT INTO tbl_manufacturer(manufacturer_name,manufacturer_image) values('$data[txtCName]','$image_url')", $con);
			} else {
				mysql_query("UPDATE `tbl_manufacturer` SET `manufacturer_name`='" . $data['txtCName'] . "',`manufacturer_image`='" . $image_url . "' WHERE manufacturer_id='" . $data['manufacturer_id'] . "'", $con);
			}
		}
	}

	/*
	* @save/update buy car information
	*/
	public function saveUpdateBuyCarInformation($con, $data, $image_url)
	{
		if (!empty($data)) {
			if ($data['buycar_id'] == '0') {
				mysql_query("INSERT INTO tbl_buycar(owner_name,owner_mobile,owner_email,nid,company_name,ctl, owner_address,car_name,car_condition,car_color,car_door,make_id,model_id,year_id,car_reg_no,car_reg_date,car_chasis_no,car_engine_name,car_totalmileage,car_sit,car_note,car_image,buy_price,asking_price,buy_given_amount,buy_note,buy_date) values('$data[txtOwnerName]','$data[txtMobile]','$data[txtEmail]','$data[txtNid]','$data[txtCompanyname]','$data[txtCTL]','$data[txtAddress]','$data[txtCarname]','$data[txtCondition]','$data[txtCarcolor]','$data[txtCardoor]','$data[ddlMake]','$data[ddlModel]','$data[ddlYear]','$data[txtRegnumber]','$data[txtRegDate]','$data[txtChasisnumber]','$data[txtEnginename]','$data[txtTotalmileasge]','$data[txtCarSeat]','$data[txtNote]','$image_url','$data[txtBuyPrice]','$data[txtAskingPrice]','$data[txtGivamount]','$data[txtBuynote]','" . $this->datepickerDateToMySqlDate($data['txtBuyDate']) . "')", $con);
			} else {
				mysql_query("UPDATE `tbl_buycar` SET `owner_name`='" . $data['txtOwnerName'] . "',`owner_mobile`='" . $data['txtMobile'] . "',`owner_email`='" . $data['txtEmail'] . "',`nid`='" . $data['txtNid'] . "',`company_name`='" . $data['txtCompanyname'] . "',`ctl`='" . $data['txtCTL'] . "',`owner_address`='" . $data['txtAddress'] . "',`car_name`='" . $data['txtCarname'] . "',`car_condition`='" . $data['txtCondition'] . "',`car_color`='" . $data['txtCarcolor'] . "',`car_door`='" . $data['txtCardoor'] . "',`make_id`='" . $data['ddlMake'] . "',`model_id`='" . $data['ddlModel'] . "',`year_id`='" . $data['ddlYear'] . "',`car_reg_no`='" . $data['txtRegnumber'] . "',`car_reg_date`='" . $data['txtRegDate'] . "',`car_chasis_no`='" . $data['txtChasisnumber'] . "',`car_engine_name`='" . $data['txtEnginename'] . "',`car_totalmileage`='" . $data['txtTotalmileasge'] . "',`car_sit`='" . $data['txtCarSeat'] . "',`car_note`='" . $data['txtNote'] . "',`car_image`='" . $image_url . "',`buy_price`='" . $data['txtBuyPrice'] . "',`asking_price`='" . $data['txtAskingPrice'] . "',`buy_given_amount`='" . $data['txtGivamount'] . "',`buy_note`='" . $data['txtBuynote'] . "',`buy_date`='" . $this->datepickerDateToMySqlDate($data['txtBuyDate']) . "' WHERE buycar_id='" . $data['buycar_id'] . "'", $con);
			}
		}
	}

	/*
	* @save/update mechanics salery information
	*/
	public function saveUpdateMechanicSaleryInformation($con, $data)
	{
		if (!empty($data)) {
			if ($data['salery_id'] == '0') {
				mysql_query("INSERT INTO tbl_mcncsslary(mechanics_id,fix_salary,total_time,paid_amount,due_amount,total,month_id,year_id,sl_date) values('$data[ddlMechanicslist]','$data[txtFixsalary]','$data[txtTotaltime]','$data[given_amount]','$data[pending_amount]','$data[txtTotal]','$data[ddlMonth]','$data[ddlYear]','" . $this->datepickerDateToMySqlDate($data['txtSalarydate']) . "')", $con);
			} else {
				mysql_query("UPDATE `tbl_mcncsslary` SET `mechanics_id`='" . $data['ddlMechanicslist'] . "',`fix_salary`='" . $data['txtFixsalary'] . "',`total_time`='" . $data['txtTotaltime'] . "',`paid_amount`='" . $data['given_amount'] . "',`due_amount`='" . $data['pending_amount'] . "',`total`='" . $data['txtTotal'] . "',`month_id`='" . $data['ddlMonth'] . "',`year_id`='" . $data['ddlYear'] . "',`sl_date`='" . $this->datepickerDateToMySqlDate($data['txtSalarydate']) . "' WHERE m_salary_id='" . $data['salery_id'] . "'", $con);
			}
		}
	}

	public function saveUpdateReceptionnisteInformation($con, $data, $image_url)
	{
		if (!empty($data)) {

			$query = "INSERT INTO tbl_add_reception(r_name,r_email,r_password) 
				values('$data[txtSName]','$data[txtSEmail]','$data[txtSPassword]')";
			$result = mysql_query($query, $con);

			if (!$result) {
				// var_dump($data);
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
			}
		}
	}

	/*
	* @save/update buy parts list information
	*/
	public function saveUpdateBuyPartsInformation_2($con, $data, $image_url)
	{
		if (!empty($data)) {
			$parts_id = $data['parts_id'];
			if (!empty($data['ddl_e_parts']) && (int) $data['ddl_e_parts'] > 0) {
				//buy exisiting
				//insert into putchase invoice table
				$parts_id = $data['ddl_e_parts'];
				mysql_query("INSERT INTO tbl_parts_stock(invoice_id,parts_id,parts_name,supplier_id,manufacturer_id,parts_condition,parts_buy_price,parts_quantity,parts_sku,parts_warranty,total_amount,given_amount,pending_amount,parts_image,parts_added_date) values('$data[invoice_id]','$parts_id','$data[parts_names]','$data[ddl_supplier]','$data[ddl_load_manufracturer]','$data[txtCondition]','$data[buy_prie]','$data[parts_quantity]','$data[parts_sku]','$data[parts_warranty]','$data[total_amount]','$data[given_amount]','$data[pending_amount]','$image_url','" . $this->datepickerDateToMySqlDate($data['parts_add_date']) . "')", $con);
				$stock_table = $this->getPartsStockStatusFromStockTable($con, $parts_id);
				if (!empty($stock_table)) {
					$qty = (int) $stock_table['quantity'] + (int) $data['parts_quantity'];
					mysql_query("UPDATE `tbl_parts_stock_manage` SET `parts_name` = '" . $data['parts_names'] . "', `parts_image`='" . $image_url . "', `part_no`='" . $data['parts_sku'] . "',`price`='" . $data['parts_sell_price'] . "', `condition`='" . $data['txtCondition'] . "', `parts_warranty`='" . $data['parts_warranty'] . "', `supplier_id`='" . $data['ddl_supplier'] . "', `manufacturer_id`='" . $data['ddl_load_manufracturer'] . "',`quantity`='" . (int) $qty . "' WHERE parts_id = '" . (int) $parts_id . "'", $con);
				}
			} else {
				$parts_id = $data['parts_id'];
				if ($parts_id == '0') {
					//insert into stock table
					mysql_query("INSERT INTO `tbl_parts_stock_manage`(`parts_id`, `parts_name`, `parts_image`, `part_no`, `price`, `condition`, `parts_warranty`, `supplier_id`, `manufacturer_id`,`quantity`) VALUES (" . (int) $parts_id . ",'" . $data['parts_names'] . "','" . $image_url . "','" . $data['parts_sku'] . "','" . $data['parts_sell_price'] . "','" . $data['txtCondition'] . "','" . $data['parts_warranty'] . "','" . $data['ddl_supplier'] . "','" . $data['ddl_load_manufracturer'] . "','" . $data['parts_quantity'] . "')", $con);

					$parts_id = mysql_insert_id();

					//insert into putchase invoice table
					mysql_query("INSERT INTO tbl_parts_stock(invoice_id,parts_id,parts_name,supplier_id,manufacturer_id,parts_condition,parts_buy_price,parts_quantity,parts_sku,parts_warranty,total_amount,given_amount,pending_amount,parts_image,parts_added_date) values('$data[invoice_id]','$parts_id','$data[parts_names]','$data[ddl_supplier]','$data[ddl_load_manufracturer]','$data[txtCondition]','$data[buy_prie]','$data[parts_quantity]','$data[parts_sku]','$data[parts_warranty]','$data[total_amount]','$data[given_amount]','$data[pending_amount]','$image_url','" . $this->datepickerDateToMySqlDate($data['parts_add_date']) . "')", $con);
				} else {
					mysql_query("UPDATE `tbl_parts_stock` SET `parts_name`='" . $data['parts_names'] . "',`supplier_id`='" . $data['ddl_supplier'] . "',`manufacturer_id`='" . $data['ddl_load_manufracturer'] . "',`parts_condition`='" . $data['txtCondition'] . "',`parts_buy_price`='" . $data['buy_prie'] . "',`parts_quantity`='" . $data['parts_quantity'] . "',`parts_sku`='" . $data['parts_sku'] . "',`parts_warranty`='" . $data['parts_warranty'] . "',`total_amount`='" . $data['total_amount'] . "',`given_amount`='" . $data['given_amount'] . "',`pending_amount`='" . $data['pending_amount'] . "',`parts_image`='" . $image_url . "',`parts_added_date`='" . $this->datepickerDateToMySqlDate($data['parts_add_date']) . "' WHERE invoice_id='" . trim($data['invoice_id']) . "'", $con);

					if ((int) $parts_id > 0) {
						$old_qty = $data['old_qty'];
						$new_qty = $data['parts_quantity'];
						$stock_table = $this->getPartsStockStatusFromStockTable($con, $parts_id);
						if (!empty($stock_table)) {
							$current_qty = (int) $stock_table['quantity'];
							$current_qty = (int) $current_qty - (int) $old_qty;
							$current_qty = (int) $current_qty + (int) $new_qty;
							//update stock table
							//$this->saveUpdatePartsVirtualStockTable($con, $parts_id, $current_qty, 'u');
							mysql_query("UPDATE `tbl_parts_stock_manage` SET `parts_name` = '" . $data['parts_names'] . "', `parts_image`='" . $image_url . "', `part_no`='" . $data['parts_sku'] . "',`price`='" . $data['parts_sell_price'] . "', `condition`='" . $data['txtCondition'] . "', `parts_warranty`='" . $data['parts_warranty'] . "', `supplier_id`='" . $data['ddl_supplier'] . "', `manufacturer_id`='" . $data['ddl_load_manufracturer'] . "',`quantity`='" . (int) $current_qty . "' WHERE parts_id = '" . (int) $parts_id . "'", $con);
						}
					}
				}
			}
			//clear filter tabale for this parts
			mysql_query("DELETE FROM `tbl_parts_fit_data` WHERE parts_id = " . (int) $parts_id, $con);
			//add again new
			if (isset($data['partsfilter']) && $data['partsfilter'] != '' && $parts_id > 0) {
				foreach ($data['partsfilter'] as $partsdata) {
					mysql_query("INSERT INTO tbl_parts_fit_data SET parts_id = '" . (int) $parts_id . "',make_id = '" . (int) $partsdata['make'] . "',model_id = '" . (int) $partsdata['model'] . "',year_id = '" . (int) $partsdata['year'] . "'", $con);
				}
			}
		}
	}


	/*
	* @update Stock de pièces information
	*/
	public function updatePartsStockInformation($con, $data, $image_url)
	{
		$parts_id = $data['parts_id'];
		if (!empty($data)) {
			mysql_query("UPDATE `tbl_parts_stock_manage` SET `parts_name` = '" . $data['parts_names'] . "', `parts_image`='" . $image_url . "', `part_no`='" . $data['parts_sku'] . "',`price`='" . $data['parts_sell_price'] . "', `condition`='" . $data['txtCondition'] . "', `parts_warranty`='" . $data['parts_warranty'] . "', `supplier_id`='" . $data['ddl_supplier'] . "', `manufacturer_id`='" . $data['ddl_load_manufracturer'] . "',`quantity`='" . $data['parts_quantity'] . "',`status`='" . $data['ddl_status'] . "' WHERE parts_id = '" . (int) $parts_id . "'", $con);
		}
		mysql_query("DELETE FROM `tbl_parts_fit_data` WHERE parts_id = " . (int) $parts_id, $con);
		if (isset($data['partsfilter']) && $data['partsfilter'] != '' && $parts_id > 0) {
			foreach ($data['partsfilter'] as $partsdata) {
				mysql_query("INSERT INTO tbl_parts_fit_data SET parts_id = '" . (int) $parts_id . "',make_id = '" . (int) $partsdata['make'] . "',model_id = '" . (int) $partsdata['model'] . "',year_id = '" . (int) $partsdata['year'] . "'", $con);
			}
		}
	}

	/*
	* @get specific parts exist to stock maintain table
	*/
	public function getPartsStockStatusFromStockTable($con, $parts_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_parts_stock_manage WHERE parts_id=" . (int) $parts_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getPieceStockStatusFromStockTable($con, $piece_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_piece_stock WHERE piece_stock_id=" . (int) $piece_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @save/update parts virtual stock table
	*/
	public function saveUpdatePartsVirtualStockTable($con, $parts_id, $stock, $token, $data)
	{
		if ($token == 'u') {
			mysql_query("UPDATE `tbl_parts_stock_manage` SET `stock`='" . (int) $stock . "' WHERE parts_id='" . (int) $parts_id . "'", $con);
		} else { }
	}

	/*
	* @get all parts fit data
	*/
	public function getAllPartsFitDate($con, $parts_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_parts_fit_data WHERE parts_id=" . (int) $parts_id, $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @save/update Voiture de réparation information
	*/
	public function saveUpdateRepairCarInformation($con, $data, $image_url)
	{
		if (!empty($data)) {

			//Date de la visite technique
			$datetech = DateTime::createFromFormat('d/m/Y', $data['add_date_visitetech']);

			$timestampstechnique =  $datetech->format('U');

			//assurance
			$dateassur = DateTime::createFromFormat('d/m/Y', $data['add_date_assurance']);

			$timestampsassurance =  $dateassur->format('U');

			if ($data['repair_car'] == '0') {
				$query = "INSERT INTO tbl_add_car(repair_car_id, car_name, customer_id, car_make, car_model, year,
                chasis_no, VIN, note, added_date, image, car_pneu_av, car_gente_ar, car_pneu_ar, car_gente_av, add_date_visitetech,
				add_date_assurance, add_date_assurance_fin, genre, energie, assurance, type_boite_vitesse,
				add_date_mise_circu, add_date_imma, nb_cylindre, couleur_vehi, fisc_vehi,
				pj1_url, pj2_url, pj3_url, pj4_url, pj5_url, pj6_url, pj7_url, pj8_url, pj9_url, pj10_url, pj11_url, pj12_url,
				duree_assurance, add_date_ctr_tech, delai_ctr_tech, add_date_derniere_vidange, add_date_changement_filtre_air,
				add_date_changement_filtre_huile, add_date_changement_filtre_pollen, km_last_vidange, statut_vistech,
				statut_assurance
				)
                   values('$data[hfInvoiceId]','$data[car_names]','$data[ddlCustomerList]','$data[ddlMake]','$data[ddlModel]',
				   '$data[ddlYear]','$data[car_chasis_no]','$data[vin]','$data[car_note]','$data[add_date]',
				   '$image_url','$data[car_pneu_av]','$data[car_gente_ar]','$data[car_pneu_ar]','$data[car_gente_av]',
				   '$data[add_date_visitetech_car]','$data[add_date_assurance_car]','$data[add_date_assurance_fin]', 
				   '$data[genre_vehi_recep]','$data[energie_vehi_recep]','$data[assurance_vehi_recep]','$data[boite_vitesse_vehi_recep]',
				   '$data[add_date_mise_circu]','$data[add_date_imma]','$data[nb_cylindre]','$data[couleur_vehi]','$data[fisc_vehi]',
				   '$data[pj1_url]','$data[pj2_url]','$data[pj3_url]','$data[pj4_url]','$data[pj5_url]','$data[pj6_url]','$data[pj7_url]',
				   '$data[pj8_url]','$data[pj9_url]','$data[pj10_url]','$data[pj11_url]','$data[pj12_url]','$data[duree_assurance]',
				   '$data[add_date_ctr_tech]','$data[delai_ctr_tech]','$data[add_date_derniere_vidange]',
				   '$data[add_date_changement_filtre_air]','$data[add_date_changement_filtre_huile]',
				   '$data[add_date_changement_filtre_pollen]','$data[km_last_vidange]','$data[statut_vistech]',
				   '$data[statut_assurance]'
				   )";
				$result = mysql_query($query, $con);
			} else {
				$query = "UPDATE `tbl_add_car` SET `customer_id`='" . $data['ddlCustomerList'] . "',
				`car_name`='" . $data['car_names'] . "',`car_make`='" . $data['ddlMake'] . "',`car_model`='" . $data['ddlModel'] . "',
				`year`='" . $data['ddlYear'] . "',`chasis_no`='" . $data['car_chasis_no'] . "',
				`VIN`='" . $data['vin'] . "',`note`='" . $data['car_note'] . "',`added_date`='" . $data['add_date'] . "',
				`image`='" . $image_url . "',`car_pneu_av`='" . $data['car_pneu_av'] . "',`car_gente_ar`='" . $data['car_gente_ar'] . "',
				`car_pneu_ar`='" . $data['car_pneu_ar'] . "',`car_gente_av`='" . $data['car_gente_av'] . "',
				`add_date_visitetech`='" . $data['add_date_visitetech'] . "',`add_date_assurance`='" . $data['add_date_assurance'] . "',
				`add_date_assurance_fin`='" . $data['add_date_assurance_fin'] . "',
				`timestampstechnique`='" . $timestampstechnique . "',`genre`='" . $data[genre_vehi_recep] . "',
				`energie`='" . $data[energie_vehi_recep] . "', `assurance`='" . $data[assurance_vehi_recep] . "',
				`type_boite_vitesse`='" . $data[boite_vitesse_vehi_recep] . "', `add_date_mise_circu`='" . $data[add_date_mise_circu] . "',
				`add_date_imma`='" . $data[add_date_imma] . "', `nb_cylindre`='" . $data[nb_cylindre] . "', 
				`couleur_vehi`='" . $data[couleur_vehi] . "', `fisc_vehi`='" . $data[fisc_vehi] . "',
				`add_date_derniere_vidange`='" . $data['add_date_derniere_vidange'] . "',
				`add_date_changement_filtre_air`='" . $data['add_date_changement_filtre_air'] . "', 
				`add_date_changement_filtre_huile`='" . $data['add_date_changement_filtre_huile'] . "',
				`add_date_changement_filtre_pollen`='" . $data['add_date_changement_filtre_pollen'] . "',
				`km_last_vidange`='" . $data['km_last_vidange'] . "',
				`pj1_url`='" . $data['pj1_url'] . "', `pj2_url`='" . $data['pj2_url'] . "', `pj3_url`='" . $data['pj3_url'] . "',
				`pj4_url`='" . $data['pj4_url'] . "', `pj5_url`='" . $data['pj5_url'] . "', `pj6_url`='" . $data['pj6_url'] . "',
				`pj7_url`='" . $data['pj7_url'] . "', `pj8_url`='" . $data['pj8_url'] . "', `pj9_url`='" . $data['pj9_url'] . "',
				`pj10_url`='" . $data['pj10_url'] . "', `pj11_url`='" . $data['pj11_url'] . "', `pj12_url`='" . $data['pj12_url'] . "'
				WHERE car_id='" . $data['repair_car'] . "'";
				$result = mysql_query($query, $con);
			}
		}

		if (!$result) {
			// var_dump($data);
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
	}

	/*
	* @save/update mechanics page builder
	*/
	public function saveUpdateMechanicsPageInformation($con, $data)
	{
		if (!empty($data)) {
			mysql_query("DELETE FROM tbl_mechanics_page where mechanic_id = '" . (int) $data['mechanics_id'] . "'", $con);
			$show_header = 0;
			if (isset($data['chkPageTitle']) && $data['chkPageTitle'] == 'on') {
				$show_header = 1;
			}
			$desc = mysql_real_escape_string($data['page_description']);
			mysql_query("INSERT INTO tbl_mechanics_page(mechanic_id,page_title,seo_url,page_details,hide_top_header,status) values('$data[mechanics_id]','$data[txtPageTitle]','$data[txtSeoUrl]','$desc','$show_header','$data[status]')", $con);
		}
	}

	/*
	* @save/update menu
	*/
	public function saveUpdateMenuInformation($con, $data)
	{
		if (!empty($data)) {
			$fixed_url = '';
			$cmspage = 0;
			if (isset($data['rbCMSPage']) && is_numeric($data['rbCMSPage']) && (int) $data['rbCMSPage'] > 0) {
				$cmspage = $data['rbCMSPage'];
			} else if (isset($data['rbCMSPage']) && is_string($data['rbCMSPage']) && !empty($data['rbCMSPage'])) {
				$fixed_url = $data['rbCMSPage'];
			}
			if ($data['menu_id'] == '0') {
				mysql_query("INSERT INTO tbl_menu(parent_id,menu_name,url_slug,menu_sort_order,cms_page,fixed_page_url,menu_status) values('$data[txtParent]','$data[txtMenuname]','$data[txtParentUrlSlug]','$data[txtSortodder]','$cmspage','$fixed_url','$data[txtStatus]')", $con);
			} else {
				mysql_query("UPDATE `tbl_menu` SET `parent_id`='" . $data['txtParent'] . "',`menu_name`='" . $data['txtMenuname'] . "',`url_slug`='" . $data['txtParentUrlSlug'] . "',`menu_sort_order`='" . $_POST['txtSortodder'] . "',`menu_status`='" . $_POST['txtStatus'] . "',`cms_page`='" . $cmspage . "',`fixed_page_url`='" . $fixed_url . "' WHERE menu_id='" . (int) $data['menu_id'] . "'", $con);
			}
		}
	}

	/*
	* @get all mechanics information
	*/
	public function getAllMechanicsList_2($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,d.title FROM tbl_add_mechanics m 
		LEFT JOIN tbl_mechanics_designation d ON d.designation_id = m.designation_id 
		ORDER BY m.mechanics_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllPersonnelList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_personnel
		-- WHERE usr_type = 'mecanicien' OR usr_type = 'electricien'
		ORDER BY per_id DESC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	public function getAllStockPiece($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_piece", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @delete mechanics
	*/
	public function deleteMechanics($con, $mechanics_id)
	{
		mysql_query("DELETE FROM tbl_add_mechanics where mechanics_id = '" . (int) $mechanics_id . "'", $con);
	}

	/*
	* @delete manufacturer
	*/
	public function deleteManufacturer($con, $manufacturer_id)
	{
		mysql_query("DELETE FROM `tbl_manufacturer` WHERE manufacturer_id = " . (int) $manufacturer_id, $con);
	}

	/*
	* @delete menu
	*/
	public function deleteMenu($con, $menu_id)
	{
		mysql_query("DELETE FROM `tbl_menu` WHERE menu_id = " . (int) $menu_id, $con);
	}

	/*
	* @get mechanics info by id
	*/
	public function getMechanicsInfoByMechanicsId($con, $mechanics_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_user where usr_id = '" . (int) $mechanics_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get customer info by id
	*/
	public function getCustomerInfoByCustomerId($con, $customer_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_customer where customer_id = '" . (int) $customer_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get work status info by id
	*/
	public function getWorkStatusInfoById($con, $w_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_daily_work where work_id = '" . (int) $w_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get manufacturer info by manufacturer id
	*/
	public function getManufacturerInfoByManufacturerId($con, $manufacturer_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_manufacturer where manufacturer_id = '" . (int) $manufacturer_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get buy car info by id
	*/
	public function getBuyCarInfoById($con, $buycar_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_buycar where buycar_id = '" . (int) $buycar_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get mechanic salery date by salery id
	*/
	public function getMechanicSlaeryInfoBySaleryId($con, $salery_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,m.m_name FROM `tbl_mcncsslary` ms inner join tbl_add_mechanics m on m.mechanics_id = ms.mechanics_id where ms.m_salary_id = '" . (int) $salery_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	public function getReceptonnisteInfoByReceptonnistId($con, $receptionniste_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_reception where reception_id=" . (int) $receptionniste_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get customer car info by car id
	*/
	public function getCustomerCarInfoByCardId($con, $car_id)
	{
		$data = array();
		$result = mysql_query("SELECT *,m.make_name,mo.model_name,y.year_name FROM tbl_add_car c left join tbl_make m on m.make_id = c.car_make left join tbl_model mo on mo.model_id = c.car_model left join tbl_year y on y.year_id = c.year where c.car_id = " . (int) $car_id, $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get Voiture de réparation info by id
	*/
	public function getRepairCarInfoByRepairCarId($con, $car_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_car where car_id = '" . (int) $car_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get all menu info by id
	*/
	public function getMenuInfoByMenuId($con, $menu_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_menu where menu_id = '" . (int) $menu_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get mechanics page info by id
	*/
	public function getMechanicsPageInfoByMechanicsId($con, $mechanics_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_mechanics_page where mechanic_id = '" . (int) $mechanics_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @team view save/update
	*/
	public function saveUpdateTeamWidgetView($con, $data)
	{
		if (!empty($data)) {
			mysql_query("DELETE FROM tbl_home_team_widget", $con);
			foreach ($data['chkTeamId'] as $team) {
				$sort_order = $data['txtSortOrder'][$team];
				mysql_query("INSERT INTO `tbl_home_team_widget`(`team_id`, `sort_order`) VALUES ($team,$sort_order)", $con);
			}
		}
	}

	/*
	* @get all FAQ information
	*/
	public function getFAQInformation($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_faq ORDER BY sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @FAQ save/update
	*/
	public function saveUpdateFAQ($con, $data)
	{
		mysql_query("DELETE FROM tbl_faq", $con);
		if (!empty($data)) {
			foreach ($data['faq'] as $faq) {
				$title = mysql_real_escape_string($faq['title']);
				$content = mysql_real_escape_string($faq['content']);
				$sort = $faq['sort'];
				mysql_query("INSERT INTO `tbl_faq`(`title`, `content`, `sort_order`) VALUES ('" . $title . "', '" . $content . "', $sort)", $con);
			}
		}
	}

	/*
	* @get team widget data
	*/
	public function getTeamWidgetData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_home_team_widget order by sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @filter Voiture de réparation
	*/
	public function filterRepairCarInfo($con, $post)
	{
		$data = array();
		$result = mysql_query("SELECT *,m.make_name,mo.model_name,y.year_name FROM tbl_add_car c left join tbl_make m on m.make_id = c.car_make left join tbl_model mo on mo.model_id = c.car_model left join tbl_year y on y.year_id = c.year where c.repair_car_id = '" . $post['txtInvoiceNo'] . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @filter car by Devis No
	*/
	public function filterRepairCarByEstimateNo($con, $invoice_no)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_car_estimate e WHERE e.estimate_no = '" . $invoice_no . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @buy parts list
	*/
	public function buyPartsList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name,s.s_name as supplier_name FROM tbl_parts_stock ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id ORDER BY ps.parts_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @Stock de pièces list
	*/
	public function partsStockList($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,s.s_name,mu.manufacturer_name,s.s_name as supplier_name FROM tbl_parts_stock_manage ps LEFT JOIN tbl_add_supplier s ON s.supplier_id = ps.supplier_id LEFT JOIN tbl_manufacturer mu ON mu.manufacturer_id = ps.manufacturer_id ORDER BY ps.parts_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @parts total qty for dashboard
	*/
	public function partsStockTotalQty_2($con)
	{
		$data = 0;
		$result = mysql_query("SELECT sum(quantity) as total_parts FROM tbl_parts_stock_manage", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row['total_parts'];
		}
		return $data;
	}

	public function partsStockTotalQty($con)
	{
		$data = 0;
		$result = mysql_query("SELECT sum(stock_piece) as total_parts FROM tbl_piece_stock", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row['total_parts'];
		}
		return $data;
	}

	/*
	* @get all widget list
	*/
	public function getAllWidgetList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_widgets order by name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all widget list
	*/
	public function getAllSupplierList($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_add_supplier order by s_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get cms page details by cms_id
	*/
	public function getCMSDetailsByCMSId($con, $cms_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_cms where cms_id='" . (int) $cms_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}


	/*
	* @get team widget home view data
	*/
	public function getTeamWidgetHomeData($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,am.m_name,am.m_image,md.title,mp.seo_url FROM tbl_home_team_widget hw INNER JOIN tbl_add_mechanics am ON am.mechanics_id = hw.team_id INNER JOIN tbl_mechanics_designation md ON md.designation_id = am.designation_id LEFT JOIN tbl_mechanics_page mp ON mp.mechanic_id = hw.team_id order by hw.sort_order ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image = '';
			$link = '';
			if ($row['m_image'] != '') {
				$image = WEB_URL . 'img/employee/' . $row['m_image'];
			}
			if (!empty($row['seo_url'])) {
				$link = $row['seo_url'];
			}
			$data[] = array(
				'image'		=> $image,
				'name'		=> $row['m_name'],
				'title'		=> $row['title'],
				'link'		=> $link,
				'status'	=> $row['status']
			);
		}
		return $data;
	}

	/*
	* @get all team members
	*/
	public function getAllTeamMembers($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,am.m_name,am.m_image,md.title,mp.seo_url FROM tbl_add_mechanics am INNER JOIN tbl_mechanics_designation md ON md.designation_id = am.designation_id LEFT JOIN tbl_mechanics_page mp ON mp.mechanic_id = am.mechanics_id order by am.m_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image = '';
			$link = '';
			if ($row['m_image'] != '') {
				$image = WEB_URL . 'img/employee/' . $row['m_image'];
			}
			if (!empty($row['seo_url'])) {
				$link = $row['seo_url'];
			}
			$data[] = array(
				'image'		=> $image,
				'name'		=> $row['m_name'],
				'title'		=> $row['title'],
				'link'		=> $link
			);
		}
		return $data;
	}

	/***************************** News Author ********************************************/
	/*
	* @get author data
	*/
	public function getAuthorData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_author order by author_name asc", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get author data by id
	*/
	public function getAuthorDataByAuthorId($con, $authod_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_author where author_id = '" . (int) $authod_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @delete author
	*/
	public function deleteAuthor($con, $author_id)
	{
		mysql_query("DELETE FROM `tbl_author` WHERE author_id = " . (int) $author_id, $con);
	}

	/*
	* @save/update author information
	*/
	public function saveUpdateAuthorInformation($con, $data)
	{
		if (!empty($data)) {
			if ($data['author_id'] == '0') {
				mysql_query("INSERT INTO tbl_author(author_name) values('$data[author_name]')", $con);
			} else {
				mysql_query("UPDATE `tbl_author` SET `author_name`='" . $data['author_name'] . "' WHERE author_id='" . (int) $data['author_id'] . "'", $con);
			}
		}
	}
	/***************************** News Category********************************************/
	/*
	* @save/update category information
	*/
	public function saveUpdateCategoryInformation($con, $data)
	{
		if (!empty($data)) {
			$seo_url = $data['category_seo_url'];
			if (empty($seo_url)) {
				$seo_url = $this->generateSeoUrl($data['category_name']);
			}
			if ($data['category_id'] == '0') {
				mysql_query("INSERT INTO tbl_category(category_name,seo_url) values('$data[category_name]','$seo_url')", $con);
			} else {
				mysql_query("UPDATE `tbl_category` SET `category_name`='" . $data['category_name'] . "',`seo_url`='" . $seo_url . "' WHERE category_id='" . (int) $data['category_id'] . "'", $con);
			}
		}
	}
	/*
	* @delete category
	*/
	public function deleteCategory($con, $category_id)
	{
		mysql_query("DELETE FROM `tbl_category` WHERE category_id = " . (int) $category_id, $con);
	}

	/*
	* @get category data by id
	*/
	public function getCategoryDataByCategoryId($con, $category_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_category where category_id = '" . (int) $category_id . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get category data
	*/
	public function getCategoryData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_category order by category_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	*	@save apointment information
	*/
	public function saveApointmentRequest($data, $con)
	{
		if (!empty($data)) {
			$name = mysql_real_escape_string($data['name']);
			$email = mysql_real_escape_string($data['email']);
			$telephone = mysql_real_escape_string($data['phone']);
			$details = mysql_real_escape_string($data['message']);
			mysql_query("INSERT INTO tbl_apointment(name, email, telephone, details, added_date) values('$name','$email','$telephone','$details', NOW())", $con);
		}
	}

	/*
	*	@save car request information
	*/
	public function saveCarRequestInformation($data, $con)
	{
		if (!empty($data)) {
			$carid = mysql_real_escape_string($data['carid']);
			$name = mysql_real_escape_string($data['name']);
			$email = mysql_real_escape_string($data['email']);
			$price = mysql_real_escape_string($data['price']);
			$telephone = mysql_real_escape_string($data['phone']);
			$details = mysql_real_escape_string($data['message']);
			mysql_query("INSERT INTO  tbl_car_request(car_id, name, email, phone, price, details, requested_date) values('$carid','$name','$email','$telephone','$price','$details', NOW())", $con);
		}
	}

	/*
	*	@save conatct information
	*/
	public function saveContactInfo($data, $con)
	{
		if (!empty($data)) {
			$name = mysql_real_escape_string($data['name']);
			$email = mysql_real_escape_string($data['email']);
			$subject = mysql_real_escape_string($data['subject']);
			$message = mysql_real_escape_string($data['message']);
			mysql_query("INSERT INTO tbl_contact(name, email, subject, message, added_date) values('$name','$email','$subject','$message', NOW())", $con);
		}
	}

	/*
	* @update apointment request status
	*/
	public function setCarRequestStatus($con, $car_request_id)
	{
		mysql_query("UPDATE tbl_car_request set status = 1 WHERE car_request_id = " . (int) $car_request_id, $con);
	}

	/*
	* @update contact status
	*/
	public function setContactStatus($con, $contact_id)
	{
		mysql_query("UPDATE tbl_contact set status = 1 WHERE contact_id = " . (int) $contact_id, $con);
	}

	/*
	* @get all apointment list
	*/
	public function get_all_apointment_list($con, $aid)
	{
		$data = array();
		$result = '';
		if ((int) $aid > 0) {
			$result = mysql_query("SELECT * FROM tbl_apointment WHERE apointment_id = " . (int) $aid, $con);
		} else {
			$result = mysql_query("SELECT * FROM tbl_apointment order by apointment_id DESC", $con);
		}
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all car Liste demandée
	*/
	public function get_all_car_request_list($con, $rid)
	{
		$data = array();
		$result = '';
		if ((int) $rid > 0) {
			$result = mysql_query("SELECT *,car_name,car_image FROM tbl_car_request cr INNER JOIN tbl_buycar bc ON bc.buycar_id = cr.car_id WHERE car_request_id = " . (int) $rid, $con);
		} else {
			$result = mysql_query("SELECT *,car_name,car_image FROM tbl_car_request cr INNER JOIN tbl_buycar bc ON bc.buycar_id = cr.car_id order by car_request_id DESC", $con);
		}
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all contact list
	*/
	public function get_all_contact_list($con, $cid)
	{
		$data = array();
		$result = '';
		if ((int) $cid > 0) {
			$result = mysql_query("SELECT * FROM tbl_contact WHERE contact_id = " . (int) $cid, $con);
		} else {
			$result = mysql_query("SELECT * FROM tbl_contact order by contact_id DESC", $con);
		}
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all waiting apointment list
	*/
	public function get_all_waiting_apointment_list($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_apointment WHERE status = 0 order by apointment_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all waiting car request list
	*/
	public function get_all_waiting_car_list($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,car_name,car_image FROM tbl_car_request cr INNER JOIN tbl_buycar bc ON bc.buycar_id = cr.car_id WHERE cr.status = 0 order by cr.car_request_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get all waiting contact us list
	*/
	public function get_all_contact_us_list($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_contact WHERE status = 0 order by contact_id DESC", $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/***********************************News*****************************************/
	/*
	* @News save/update
	*/
	public function saveUpdateNewsInformation($con, $data, $image_url, $image_url_2)
	{
		if (!empty($data)) {
			$allow_comments = 0;
			$show_home = 0;
			$seo_url = '';
			if (isset($data['allow_comment']) && $data['allow_comment'] == 'on') {
				$allow_comments = 1;
			}
			if (isset($data['show_home']) && $data['show_home'] == 'on') {
				$show_home = 1;
			}
			if (!empty($data['blog_seo_url'])) {
				$seo_url = $data['blog_seo_url'];
			} else {
				$seo_url = $this->generateSeoUrl($data['blog_title']);
			}

			$desc = mysql_real_escape_string($data['blog_details']);
			$sdesc = mysql_real_escape_string($data['blog_short_details']);
			$date = $this->datepickerDateToMySqlDate($data['blog_date']);
			if ($data['blog_id'] == '0') {
				mysql_query("INSERT INTO tbl_blog(blog_cat,blog_title,seo_url,blog_author,blog_details,short_desc,blog_image,thumb_image,blog_status,allow_comment,show_home,blog_date_time,blog_time) values('$data[blog_cat]','$data[blog_title]','$seo_url','$data[blog_author]','$desc','$sdesc','$image_url','$image_url_2','$data[blog_status]','$allow_comments','$show_home','$date','$data[blog_time]')", $con);
			} else {
				mysql_query("UPDATE `tbl_blog` SET `blog_cat`='" . $data['blog_cat'] . "',`blog_title`='" . $data['blog_title'] . "',`seo_url`='" . $seo_url . "',`blog_author`='" . $data['blog_author'] . "',`allow_comment`='" . $allow_comments . "',`show_home`='" . $show_home . "',`blog_details`='" . $desc . "',`short_desc`='" . $sdesc . "',`blog_status`='" . $data['blog_status'] . "',`blog_image`='" . $image_url . "',`thumb_image`='" . $image_url_2 . "',`blog_date_time`='" . $date . "',`blog_time`='" . $data['blog_time'] . "' WHERE blog_id='" . $data['blog_id'] . "'", $con);
			}
		}
	}

	/*
	* @get news list
	*/
	public function getNewsData($con)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_blog order by blog_title ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @get news category and count
	*/
	public function getNewsCategoryAndCount($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,(select count(blog_id) as total from tbl_blog where tbl_blog.blog_cat = tbl_category.category_id) as total FROM tbl_category order by category_name ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @filter parts based on make model year
	*/
	/*public function filterPartsBasedOnMakeModelYear($con, $filter) {
		$data = array();
		$sql = '';
		if(!empty($filter['makeid']) && !empty($filter['modelid']) && !empty($filter['yearid'])) {
			$sql = mysql_query('SELECT * FROM tbl_parts_fit_data pfd INNER JOIN tbl_parts_stock_manage psm ON psm.parts_id = pfd.parts_id WHERE pfd.make_id = "'.(int)$filter['makeid'].'" AND pfd.model_id = "'.(int)$filter['modelid'].'" AND pfd.year_id = "'.(int)$filter['yearid'].'"');
		} else if(!empty($filter['makeid']) && !empty($filter['modelid'])) {
			$sql = mysql_query('SELECT * FROM tbl_parts_fit_data pfd INNER JOIN tbl_parts_stock_manage psm ON psm.parts_id = pfd.parts_id WHERE pfd.make_id = "'.(int)$filter['makeid'].'" AND pfd.model_id = "'.(int)$filter['modelid'].'"');
		} else if(!empty($filter['makeid'])) {
			$sql = mysql_query('SELECT * FROM tbl_parts_fit_data pfd INNER JOIN tbl_parts_stock_manage psm ON psm.parts_id = pfd.parts_id WHERE pfd.make_id = "'.(int)$filter['makeid'].'"');
		}
		if(!empty($sql)) {
			while($row = mysql_fetch_assoc($sql)){
				$data[] = $row;
			}
		}
		return $data;
	}*/

	/*
	* @get news info by id
	*/
	public function getNewsDataByNewsId($con, $newsid)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_id,b.seo_url as blog_seo_url,c.seo_url as category_seo_url FROM tbl_blog b LEFT JOIN tbl_category c ON c.category_id = b.blog_cat where b.blog_id = '" . (int) $newsid . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get news list for home page
	*/
	public function getNewsDataForHomePage($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_name,b.seo_url as blog_seo_url,c.seo_url as category_seo_url,(select count(blog_id) from tbl_blog_comments where blog_id = b.blog_id) as total_comments FROM tbl_blog b left join tbl_category c on c.category_id = b.blog_cat where b.show_home = 1 order by b.blog_title ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image_thumb = '';
			if ($row['thumb_image'] != '') {
				$image_thumb = WEB_URL . 'img/blog/' . $row['thumb_image'];
			}
			$image_main = '';
			if ($row['blog_image'] != '') {
				$image_main = WEB_URL . 'img/blog/' . $row['blog_image'];
			}
			$phpdate = strtotime($row['blog_date_time']);
			$mysqldate = date('F d, Y', $phpdate);

			$data[] = array(
				'blog_title'		=> $row['blog_title'],
				'seo_url'			=> $row['blog_seo_url'],
				'category'			=> $row['category_seo_url'],
				'blog_cat'			=> $row['blog_cat'],
				'blog_author'		=> $row['blog_author'],
				'blog_details'		=> $row['blog_details'],
				'short_desc'		=> $row['short_desc'],
				'blog_image'		=> $image_main,
				'thumb_image'		=> $image_thumb,
				'blog_status'		=> $row['blog_status'],
				'allow_comment'		=> $row['allow_comment'],
				'show_home'			=> $row['show_home'],
				'comments'			=> $row['total_comments'],
				'blog_date_time'	=> $mysqldate,
			);
		}
		return $data;
	}

	/*
	* @get news list by category
	*/
	public function getNewsByCategory($con, $seo_key)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_name,b.seo_url as blog_seo_url,c.seo_url as category_seo_url,(select count(blog_id) from tbl_blog_comments where blog_id = b.blog_id) as total_comments FROM tbl_blog b inner join tbl_category c on c.category_id = b.blog_cat WHERE c.seo_url = '" . $seo_key . "' order by b.blog_title ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image_thumb = '';
			if ($row['thumb_image'] != '') {
				$image_thumb = WEB_URL . 'img/blog/' . $row['thumb_image'];
			}
			$image_main = '';
			if ($row['blog_image'] != '') {
				$image_main = WEB_URL . 'img/blog/' . $row['blog_image'];
			}
			$phpdate = strtotime($row['blog_date_time']);
			$mysqldate = date('F d, Y', $phpdate);
			if (empty($data['category'])) {
				$data['category']	= $row['category_name'];
			}
			$data['blogs'][] = array(
				'blog_title'		=> $row['blog_title'],
				'category_name'		=> $row['category_name'],
				'seo_url'			=> $row['blog_seo_url'],
				'comments'			=> $row['total_comments'],
				'category'			=> $row['category_seo_url'],
				'blog_cat'			=> $row['blog_cat'],
				'blog_author'		=> $row['blog_author'],
				'blog_details'		=> $row['blog_details'],
				'short_desc'		=> $row['short_desc'],
				'blog_image'		=> $image_main,
				'thumb_image'		=> $image_thumb,
				'blog_status'		=> $row['blog_status'],
				'allow_comment'		=> $row['allow_comment'],
				'show_home'			=> $row['show_home'],
				'blog_date_time'	=> $mysqldate,
			);
		}
		return $data;
	}

	/*
	* @get all nouvelles Collections
	*/
	public function getAllNewsCollections($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_name,b.seo_url as blog_seo_url,c.seo_url as category_seo_url,(select count(blog_id) from tbl_blog_comments where blog_id = b.blog_id) as total_comments FROM tbl_blog b inner join tbl_category c on c.category_id = b.blog_cat order by b.blog_title ASC", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image_thumb = '';
			if ($row['thumb_image'] != '') {
				$image_thumb = WEB_URL . 'img/blog/' . $row['thumb_image'];
			}
			$image_main = '';
			if ($row['blog_image'] != '') {
				$image_main = WEB_URL . 'img/blog/' . $row['blog_image'];
			}
			$phpdate = strtotime($row['blog_date_time']);
			$mysqldate = date('F d, Y', $phpdate);
			if (empty($data['category'])) {
				$data['category']	= $row['category_name'];
			}
			$data['blogs'][] = array(
				'blog_title'		=> $row['blog_title'],
				'category_name'		=> $row['category_name'],
				'seo_url'			=> $row['blog_seo_url'],
				'comments'			=> $row['total_comments'],
				'category'			=> $row['category_seo_url'],
				'blog_cat'			=> $row['blog_cat'],
				'blog_author'		=> $row['blog_author'],
				'blog_details'		=> $row['blog_details'],
				'short_desc'		=> $row['short_desc'],
				'blog_image'		=> $image_main,
				'thumb_image'		=> $image_thumb,
				'blog_status'		=> $row['blog_status'],
				'allow_comment'		=> $row['allow_comment'],
				'show_home'			=> $row['show_home'],
				'blog_date_time'	=> $mysqldate,
			);
		}
		return $data;
	}

	/*
	* @get 8 latest news list
	*/
	public function getFiveLatestNews($con)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_name,b.seo_url as blog_seo_url,c.seo_url as category_seo_url FROM tbl_blog b left join tbl_category c on c.category_id = b.blog_cat order by blog_id DESC Limit 5", $con);
		while ($row = mysql_fetch_assoc($result)) {
			$image_thumb = '';
			if ($row['thumb_image'] != '') {
				$image_thumb = WEB_URL . 'img/blog/' . $row['thumb_image'];
			}
			$image_main = '';
			if ($row['blog_image'] != '') {
				$image_main = WEB_URL . 'img/blog/' . $row['blog_image'];
			}
			$phpdate = strtotime($row['blog_date_time']);
			$mysqldate = date('F d, Y', $phpdate);

			$data[] = array(
				'blog_title'		=> $row['blog_title'],
				'category_name'		=> $row['category_name'],
				'seo_url'			=> $row['blog_seo_url'],
				'category'			=> $row['category_seo_url'],
				'blog_cat'			=> $row['blog_cat'],
				'blog_author'		=> $row['blog_author'],
				'blog_details'		=> $row['blog_details'],
				'short_desc'		=> $row['short_desc'],
				'blog_image'		=> $image_main,
				'thumb_image'		=> $image_thumb,
				'blog_status'		=> $row['blog_status'],
				'allow_comment'		=> $row['allow_comment'],
				'show_home'			=> $row['show_home'],
				'blog_time'			=> $row['blog_time'],
				'blog_date_time'	=> $mysqldate,
			);
		}
		return $data;
	}

	/*
	* @get news list for home page
	*/
	public function singlePageBlogDetailsBySeoUrl($con, $seo_url)
	{
		$data = array();
		$result = mysql_query("SELECT *,c.category_name,b.seo_url as blog_seo_url,c.seo_url as category_seo_url FROM tbl_blog b left join tbl_category c on c.category_id = b.blog_cat where b.seo_url = '$seo_url' order by b.blog_title ASC", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$image_thumb = '';
			if ($row['thumb_image'] != '') {
				$image_thumb = WEB_URL . 'img/blog/' . $row['thumb_image'];
			}
			$image_main = '';
			if ($row['blog_image'] != '') {
				$image_main = WEB_URL . 'img/blog/' . $row['blog_image'];
			}
			$phpdate = strtotime($row['blog_date_time']);
			$mysqldate = date('F d, Y', $phpdate);

			$data = array(
				'blog_id'			=> $row['blog_id'],
				'blog_title'		=> $row['blog_title'],
				'seo_url'			=> $row['blog_seo_url'],
				'category'			=> $row['category_seo_url'],
				'blog_cat'			=> $row['blog_cat'],
				'blog_author'		=> $row['blog_author'],
				'blog_details'		=> $row['blog_details'],
				'short_desc'		=> $row['short_desc'],
				'blog_image'		=> $image_main,
				'thumb_image'		=> $image_thumb,
				'blog_status'		=> $row['blog_status'],
				'allow_comment'		=> $row['allow_comment'],
				'show_home'			=> $row['show_home'],
				'blog_date_time'	=> $mysqldate,
				'blog_day'			=> date('d', $phpdate),
				'blog_month'		=> date('F', $phpdate),
				'blog_year'			=> date('Y', $phpdate)
			);
		}
		return $data;
	}

	/*
	* @delete blog
	*/
	public function deleteNews($con, $newsid)
	{
		mysql_query("DELETE FROM `tbl_blog` WHERE blog_id = " . (int) $newsid, $con);
	}

	/*
	* @delete apointment request
	*/
	public function deleteApointmentRequest($con, $apointment_id)
	{
		mysql_query("DELETE FROM `tbl_apointment` WHERE apointment_id = " . (int) $apointment_id, $con);
	}

	/*
	* @delete car request
	*/
	public function deleteCarRequest($con, $car_request_id)
	{
		mysql_query("DELETE FROM `tbl_car_request` WHERE car_request_id = " . (int) $car_request_id, $con);
	}

	/*
	* @delete contact us data
	*/
	public function deleteContactRequest($con, $contact_id)
	{
		mysql_query("DELETE FROM `tbl_contact` WHERE contact_id = " . (int) $contact_id, $con);
	}

	/*
	* @save or update car color
	*/
	public function saveUpdateCarColor($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_carcolor SET color_name = '" . trim($data['txtColorname']) . "' WHERE color_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_carcolor(color_name) values('$data[txtColorname]')", $con);
			}
		}
	}

	/*
	* @save or update car color
	*/
	public function saveUpdateCarDoor($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_cardoor SET door_name = '" . $data['txtDoor'] . "' WHERE door_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_cardoor(door_name) values('$data[txtDoor]')", $con);
			}
		}
	}

	/*
	* @save or update make settings
	*/
	public function saveUpdateMakeSetup($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_make SET make_name = '" . trim($data['txtMakeName']) . "' WHERE make_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_make(make_name) values('$data[txtMakeName]')", $con);
			}
		}
	}

	/*
	* @save or update model settings
	*/
	public function saveUpdateModelSetup($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_model SET make_id = '" . $data['ddlMake'] . "', model_name = '" . trim($data['txtModelName']) . "' WHERE model_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_model(make_id, model_name) values('$data[ddlMake]', '$data[txtModelName]')", $con);
			}
		}
	}

	/*
	* @save or update year settings
	*/
	public function saveUpdateYearSetup($con, $data)
	{
		if (!empty($data)) {
			if ((int) $data['submit_token'] > 0) {
				mysql_query("UPDATE tbl_year SET make_id = '" . $data['ddlMake'] . "',model_id = '" . $data['ddlModel'] . "', year_name = '" . trim($data['txtYear']) . "' WHERE year_id = " . (int) $data['submit_token'], $con);
			} else {
				mysql_query("INSERT INTO tbl_year(make_id, model_id, year_name) values('$data[ddlMake]', '$data[ddlModel]', '$data[txtYear]')", $con);
			}
		}
	}

	/*
	* @get car make data by make id
	*/
	public function getCarMakeDataByMakeId($con, $make_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_make where make_id = '" . (int) $make_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get car model data by model id
	*/
	public function getCarModelDataByModelId($con, $model_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_model where model_id = '" . (int) $model_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get car year data by year id
	*/
	public function getCarYearDataByYearId($con, $year_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_year where year_id = '" . (int) $year_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get car color info by color id
	*/
	public function getCarColorDataByColorId($con, $color_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_carcolor where color_id = '" . (int) $color_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @get car door info by door id
	*/
	public function getCarDoorDataByDoorId($con, $door_id)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM tbl_cardoor where door_id = '" . (int) $door_id . "'", $con);
		if ($row = mysql_fetch_array($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @fit html build
	*/
	public function getmakeHtml($makeid, $row, $con)
	{
		$make_html = "<select class='form-control' id=make_" . $row . " onchange='loadModelDatax(this," . $row . ");' name='partsfilter[" . $row . "][make]'><option value=''>--Sélectionnez Marque--</option>";
		$rows = $this->get_all_make_list($con);
		foreach ($rows as $row) {
			if ($row['make_id'] == $makeid) {
				$make_html .= "<option selected='selected' value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
			} else {
				$make_html .= "<option value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
			}
		}
		return $make_html . "</select>";
	}
	public function getmodelHtml($makeid, $modelid, $row, $con)
	{
		$model_html = "<select class='form-control' onchange='loadYearData(this," . $row . ");' name='partsfilter[" . $row . "][model]' id='model_" . $row . "'><option value=''>--Choisir un modèle--</option>";
		$rows = $this->getModelListByMakeId($con, $makeid);
		foreach ($rows as $row) {
			if ($row['model_id'] == $modelid) {
				$model_html .= "<option selected='selected' value='" . $row['model_id'] . "'>" . $row['model_name'] . "</option>";
			} else {
				$model_html .= "<option value='" . $row['model_id'] . "'>" . $row['model_name'] . "</option>";
			}
		}
		return $model_html . "</select>";
	}
	public function getyearHtml($makeid, $modelid, $yearid, $row, $con)
	{
		$year_html = "<select class='form-control' name='partsfilter[" . $row . "][year]' id='year_" . $row . "'><option value=''>--Sélectionnez Année--</option>";
		$rows = $this->getYearlListByMakeIdAndModelId($con, $makeid, $modelid);
		foreach ($rows as $row) {
			if ($row['year_id'] == $yearid) {
				$year_html .= "<option selected='selected' value='" . $row['year_id'] . "'>" . $row['year_name'] . "</option>";
			} else {
				$year_html .= "<option value='" . $row['year_id'] . "'>" . $row['year_name'] . "</option>";
			}
		}
		return $year_html . "</select>";
	}


	/*
	* @load email template
	*/
	public function loadEmailTemplate($temp_name, $variables = array())
	{
		$template = file_get_contents(ROOT_PATH . "/email_templates/" . $temp_name);
		foreach ($variables as $key => $value) {
			$template = str_replace('{{ ' . $key . ' }}', $value, $template);
		}
		return $template;
	}

	/*public function loadEmailTemplate($temp_name, $email_variables = array()) {
		$url = '../email_templates/'.$temp_name;
		$data = http_build_query($email_variables);
		// use key 'http' even if you send the request to https://...
		$options = array('http' => array(
			'method'  => 'POST',
			'content' => $data
		));
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		return $result;
	}*/

	/*
	* @seo url generate
	*/
	public function generateSeoUrl($text)
	{
		$title = mysql_real_escape_string($text);
		$title = htmlentities($title);
		$newtitle = $this->string_limit_words($title, 6);
		$urltitle = preg_replace('/[^a-z0-9]/i', ' ', $newtitle);
		$newurltitle = str_replace(" ", "-", $newtitle);
		$url = $newurltitle . '.html';
		$url = strtolower($newurltitle);
		return $url;
	}
	public function string_limit_words($string, $word_limit)
	{
		$words = explode(' ', $string);
		return implode(' ', array_slice($words, 0, $word_limit));
	}

	/*
	* @get mechanics page info by id
	*/
	public function getSeoDetailsById($con, $seo_key, $table)
	{
		$data = array();
		$result = mysql_query("SELECT * FROM " . $table . " where seo_url = '" . trim($seo_key) . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			$data = $row;
		}
		return $data;
	}

	/*
	* @execute multiple rows query
	*/
	public function deleteWorkProcessImage($image_dir_url)
	{
		if (file_exists($image_dir_url)) {
			unlink($image_dir_url);
		}
	}

	/*
	* @execute multiple rows query
	*/
	public function getMultipleRowData($con, $query)
	{
		$data = array();
		$result = mysql_query($query, $con);
		while ($row = mysql_fetch_array($result)) {
			$data[] = $row;
		}
		return $data;
	}

	/*
	* @datepicker date conversion //helper
	*/
	public function datepickerDateToMySqlDate($date)
	{
		$cdate = '0000-00-00';
		if (!empty($date)) {
			$x =  explode('/', $date);
			$cdate = $x[2] . '-' . $x[1] . '-' . $x[0];
		}
		return $cdate;
	}
	public function mySqlToDatePicker($date)
	{
		$cdate = '';
		if (!empty($date)) {
			$x =  explode('-', $date);
			$cdate = $x[2] . '/' . $x[1] . '/' . $x[0];
		}
		return $cdate;
	}

	/*
	* @ month color code for chart
	*/
	public function getMonthValueToMonthName($monthNum)
	{
		return date('F', mktime(0, 0, 0, $monthNum, 10));
	}
	public function getChartColorCodeByMonth($month)
	{
		$cc = '';
		if (!empty($month)) {
			switch ($month) {
				case 'January':
					$cc = '#ff6384';
					break;
				case 'February':
					$cc = '#ff9f40';
					break;
				case 'March':
					$cc = '#ffcd56';
					break;
				case 'April':
					$cc = '#4bc0c0';
					break;
				case 'May':
					$cc = '#36a2eb';
					break;
				case 'June':
					$cc = '#9966ff';
					break;
				case 'July':
					$cc = '#c9cbcf';
					break;
				case 'Auguest':
					$cc = '#00a65a';
					break;
				case 'September':
					$cc = '#0aff8c';
					break;
				case 'October':
					$cc = '#fc0202';
					break;
				case 'November':
					$cc = '#eef213';
					break;
				case 'December':
					$cc = '#ff851b';
					break;
				default:
					$cc = '#4bc0c0';
			}
		}
		return $cc;
	}

	/*
	* @login process
	*/
	public function forgot_operation($con, $data)
	{
		$obj_login = array();
		if ($data['ddlLoginType'] == 'admin') {
			$sql = mysql_query("SELECT * FROM tbl_admin WHERE email = '" . $this->make_safe($data['username']) . "'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['user_id'],
					'name'			=> $row['name'],
					'email'			=> $row['email'],
					'password'		=> $row['password'],
					'image'			=> $row['image']
				);
			}
		} else if ($data['ddlLoginType'] == 'customer') {
			$sql = mysql_query("SELECT * FROM tbl_add_customer WHERE c_email = '" . $this->make_safe($data['username']) . "'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['customer_id'],
					'name'			=> $row['c_name'],
					'email'			=> $row['c_email'],
					'password'		=> $row['c_password'],
					'image'			=> $row['image']
				);
			}
		} else if ($_POST['ddlLoginType'] == 'mechanics') {
			$sql = mysql_query("SELECT * FROM tbl_add_mechanics WHERE m_email = '" . $this->make_safe($data['username']) . "'", $con);
			if ($row = mysql_fetch_assoc($sql)) {
				$obj_login = array(
					'user_id'		=> $row['mechanics_id'],
					'name'			=> $row['m_name'],
					'email'			=> $row['m_email'],
					'password'		=> $row['m_password'],
					'image'			=> $row['m_image']
				);
			}
		}
		return $obj_login;
	}

	/*
	* @customer email exist checking
	*/
	public function checkCustomerEmailAddress($con, $email)
	{
		$result = mysql_query("SELECT * FROM tbl_add_customer WHERE c_email='" . trim($email) . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			return true;
			exit();
		}
		return false;
	}

	/*
	* @mechanics email exist checking
	*/
	public function checkMechanicsEmailAddress($con, $email)
	{
		$result = mysql_query("SELECT * FROM tbl_add_mechanics WHERE m_email='" . trim($email) . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			return true;
			exit();
		}
		return false;
	}

	/*
	* @supplier email exist checking
	*/
	public function checkSupplierEmailAddress($con, $email)
	{
		$result = mysql_query("SELECT * FROM tbl_add_supplier WHERE s_email='" . trim($email) . "'", $con);
		if ($row = mysql_fetch_assoc($result)) {
			return true;
			exit();
		}
		return false;
	}

	/*
	* @input string filter
	*/
	public function make_safe($variable)
	{
		$variable = strip_tags(mysql_real_escape_string(trim($variable)));
		return $variable;
	}

	/*
	* @distroy all connection
	*/
	public function close_db_connection($con)
	{
		mysql_close($con);
		$con = NULL;
	}

	/*
	* @mailchimp
	*/
	public function sendMailChimp($data, $con)
	{
		$settings = $this->getWebsiteSettingsInformation($con);
		if (!empty($settings) && !empty($settings['mc_api_key']) && !empty($settings['mc_list_id'])) {
			require_once(ROOT_PATH . 'library/MCAPI.class.php');
			$API_KEY = $settings['mc_api_key'];
			$LIST_ID = $settings['mc_list_id'];
			if (!$data['email']) {
				return "No email address provided";
			}
			if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*$/i", $data['email'])) {
				return "Email address is invalid";
			}
			$api = new MCAPI($API_KEY);
			$mergeVars = array('FNAME' => '', 'LNAME' => '');
			if ($api->listSubscribe($LIST_ID, $data['email'], $mergeVars) === true) {
				return -99;
			} else {
				return 'Error: ' . $api->errorMessage;
			}
		} else {
			return 'Please set your API key and LIST ID';
		}
	}

	/***END HERE */


	/*
	* @get page name
	*/

	/*public function getPageName() {
		if(basename($_SERVER['PHP_SELF']) == 'index.php') {
			return 'index';
		} else if(basename($_SERVER['PHP_SELF']) == 'news-latest-collection.php') {
			return str_replace('.php','',basename($_SERVER['PHP_SELF']));
		} else if(basename($_SERVER['PHP_SELF']) == 'cms.php') {
			return pathinfo($this->curPageURL(),PATHINFO_FILENAME);
		} else {
			return str_replace('.php','',basename($_SERVER['PHP_SELF']));
		}
	}
	public function curPageURL() {
	 $pageURL = 'http';
	 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	 }
	 return $pageURL;
	}*/
}
