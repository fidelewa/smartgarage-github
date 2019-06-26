<?php

include('../config.php');
include("../helper/common.php");
$wms = new wms_core();


if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	$response_array = array();

	if ($_POST['phone_number'] != "") {

		// On instancie un objet DateTime
		$dateHeure = new Datetime('now');
		// var_dump($dateHeure);

		// Définition de l'heure d'arrivé et de l'heure de départ
		$heureDebutWorkStr = '08:00:00';
		$heureFinWorkStr = '17:00:00';
		$heureDebutWork = DateTime::createFromFormat('H:i:s', $heureDebutWorkStr);
		$heureFinWork = DateTime::createFromFormat('H:i:s', $heureFinWorkStr);

		$dateHeurStr = $dateHeure->format('Y-m-d H:i:s');
		// var_dump($dateHeurStr);

		// On récupère uniquement l'heure
		$heure = date('H', strtotime($dateHeurStr));
		// var_dump($heure);

		// On récupère uniquement la date
		$dateStr = $dateHeure->format('Y-m-d');
		// var_dump($dateStr);

		// On récupère uniquement l'heure complète
		$heureComplete = $dateHeure->format('H:i:s');
		// var_dump($heureComplete);

		// En fonction de la plage horaire, on défini la salutation
		if ($heure >= 06 && $heure < 12) {
			$gretting = 'Bonjour';
		}
		if ($heure >= 12 && $heure < 18) {
			$gretting = 'Bonne après midi';
		}
		if ($heure >= 18 && $heure < 22) {
			$gretting = 'Bonne soirée';
		}
		if ($heure >= 22 && $heure < 24) {
			$gretting = 'Bonne nuit';
		}
		if ($heure >= 00 && $heure < 06) {
			$gretting = 'Bonne nuit';
		}

		// On vérifie bien que le numéro de téléphone qui a servi à faire le pointage
		// appartient bien à un employé

		$keyword = strval($_POST["phone_number"]);
		$query = "SELECT * FROM tbl_add_personnel WHERE per_telephone = '" . htmlentities($keyword) . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$result = mysql_query($query, $link);

		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' .  $query;
			die($message);
		}

		if (mysql_num_rows($result) > 0) {
			// Si le numéro de téléphone appartient bien à un employé

			// Extraction et affectation du jeu de résultat de la requête dans un array associatif
			if ($row = mysql_fetch_assoc($result)) {
				$dataEmploye = $row;
			}

			// Traitement du pointage

			// On vérifie que l'employé possédant ce numéro de téléphone 
			// à pointé en date d'arrivé et de départ aujourd'hui.
			$querySelDateArrDepart = "SELECT * 
			FROM tbl_add_pointage 
			WHERE date_arrivee = '" . $dateStr . "' AND date_depart = '" . $dateStr . "'
			GROUP BY num_tel
			HAVING num_tel = '" . htmlentities($_POST['phone_number']) . "'";

			// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
			$resultSelDateArrDepart = mysql_query($querySelDateArrDepart, $link);

			if (!$resultSelDateArrDepart) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' .  $querySelDateArrDepart;
				die($message);
			}

			if (mysql_num_rows($resultSelDateArrDepart) > 0) {

				$msg = "Pointage déjà éffectué, à demain " . $dataEmploye['per_name'];
				// echo($msg);

				$html = '<div class="alert alert-danger alert-dismissable" style="display:block">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4>' . $msg . '</h4>
				</div>';

				header('Content-Type: text/html');
				echo $html;

				// $response_array['msg'] = "Pointage déjà éffectué, à demain";
				// echo json_encode($response_array);

				// die();
			} else {

				// On vérifie que l'employé possédant ce numéro de téléphone 
				// à pointé en date d'arrivé aujourd'hui.
				$querySelDateArr = "SELECT * 
				FROM tbl_add_pointage
				WHERE date_arrivee = '" . $dateStr . "'
				GROUP BY num_tel
				HAVING num_tel = '" . htmlentities($_POST['phone_number']) . "'";

				// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
				$resultSelDateArr = mysql_query($querySelDateArr, $link);

				if (!$resultSelDateArr) {
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					$message .= 'Whole query: ' .  $querySelDateArr;
					die($message);
				}

				if (mysql_num_rows($resultSelDateArr) > 0) {
					// Si l'employé possédant ce numéro de téléphone à pointé aujourd'hui en date d'arrivée
					// c'est que son pointage courant concerne son départ
					// $rslt = array();
					$imagedata = base64_decode($_POST['img_data']);
					$filename = md5(date("dmYhisA"));
					//Location to where you want to created sign image
					$file_name = './doc_signs/' . $filename . '.png';
					file_put_contents($file_name, $imagedata);
					$response_array['status'] = 1;
					$response_array['file_name'] = $file_name;

					// Définition du nom de l'image de la signature de départ
					$filenameDepart = str_replace('./doc_signs/', '', $file_name);

					// Extraction des enregistrements du jeu de résultat dans un array associatif
					$row = mysql_fetch_assoc($resultSelDateArr);

					$dateHeureArrive = DateTime::createFromFormat('Y-m-d H:i:s', $row['date_heure_arrive']);

					if ($dateHeureArrive instanceof DateTime) {

						$nbHoursWork = $dateHeureArrive->diff($dateHeure)->format('%H');;

						// conversion en entier
						$nbHoursWork = (int)$nbHoursWork;
					}

					// Récupération de l'heure de départ
					$heureDepart = DateTime::createFromFormat('H:i:s', $heureComplete);

					if ($heureDepart instanceof DateTime) {

						// Calcul du temps supplémentaire en minutes
						// $nbHoursSupplementaire = $heureDepart->diff($heureFinWork)->format('%H');
						$nbHoursSupplementaire = $heureFinWork->diff($heureDepart)->format('%R%H');

						// conversion en entier du temps supplémentaire
						$nbHoursSupplementaire = (int)$nbHoursSupplementaire;
					}

					$query_3 = "UPDATE tbl_add_pointage SET 
					date_depart = '" . $dateStr . "', 
					heure_depart = '" . $heureComplete . "', 
					signa_depart = '" . $filenameDepart . "',
					nb_heure_work = '" . $nbHoursWork . "',
					nb_heure_sup = '" . $nbHoursSupplementaire . "'
					WHERE date_arrivee = '" . htmlentities($dateStr) . "' AND  
					num_tel =  '" . htmlentities($_POST['phone_number']) . "'";

					// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
					$result_3 = mysql_query($query_3, $link);

					if (!$result_3) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' .  $query_3;
						die($message);
					}

					$msg = "Au revoir " . $dataEmploye['per_name'];

					$html = '<div class="alert alert-success alert-dismissable" style="display:block">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4>' . $msg . '</h4>
				</div>';

					header('Content-Type: text/html');
					echo $html;

					// $response_array['msg'] = "Pointage départ éffectué, au revoir !";
					// echo json_encode($response_array);

				} else {
					// Si l'employé possédant ce numéro de téléphone n'a pas encore pointé aujourd'hui en date d'arrivée
					// c'est que son pointage courant concerne son arrivé
					// $rslt = array();
					$imagedata = base64_decode($_POST['img_data']);
					$filename = md5(date("dmYhisA"));
					//Location to where you want to created sign image
					$file_name = './doc_signs/' . $filename . '.png';
					file_put_contents($file_name, $imagedata);
					$response_array['status'] = 1;
					$response_array['file_name'] = $file_name;

					// Définition du nom de l'image de la signature d'arrivée
					$filenameArrive = str_replace('./doc_signs/', '', $file_name);
					
					// Récupération de l'heure d'arrivée
					$heureArrive = DateTime::createFromFormat('H:i:s', $heureComplete);

					if ($heureArrive instanceof DateTime) {

						// Calcul du temps de retard en minutes
						$nbHoursRetard = $heureArrive->diff($heureDebutWork)->format('%H');;

						// conversion en entier du temps de retard
						$nbHoursRetard = (int)$nbHoursRetard;
					}

					$query_2 = "INSERT INTO tbl_add_pointage(date_arrivee, heure_arrivee, signa_arrivee, 
					date_depart, heure_depart, signa_depart, num_tel, nb_heure_work, date_heure_arrive, nb_heure_sup, nb_heure_retard) 
					VALUES ('$dateStr','$heureComplete','$filenameArrive',null,null,null,'$_POST[phone_number]',null,
					'$dateHeurStr',null,$nbHoursRetard)";

					$result_2 = mysql_query($query_2, $link);

					if (!$result_2) {
						$message  = 'Invalid query: ' . mysql_error() . "\n";
						$message .= 'Whole query: ' .  $query_2;
						die($message);
					}

					$msg = $gretting . " " . $dataEmploye['per_name'] . ", bienvenu et bon service";

					$html = '<div class="alert alert-success alert-dismissable" style="display:block">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4>' . $msg . '</h4>
				</div>';

					header('Content-Type: text/html');
					echo $html;
					die();

					// $response_array['msg'] = "Pointage arrivé éffectué, " . $gretting . " et bon service";
					// echo json_encode($response_array);
				}
			}
		} else {
			$msg = "Ce numéro de téléphone n'appartient à aucun employé";

			$html = '<div class="alert alert-warning alert-dismissable" style="display:block">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4>' . $msg . '</h4>
				</div>';

			header('Content-Type: text/html');
			echo $html;
			die();
		}
	}
}
