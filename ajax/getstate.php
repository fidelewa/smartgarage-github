<?php
include("../config.php");
// Récupératon de l'objet XHR
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {

	include("../dbconfig.php");
	include("../helper/common.php");

	$wms = new wms_core();

	if (isset($_POST['token']) && $_POST['token'] == 'getallassur') {
		$html = "<option value=''>--Sélectionner l'assurance du véhicule--</option>";
		// if (isset($_POST['cid']) && (int)$_POST['cid'] > 0) {
		$result = $wms->get_all_assurance_vehicule_list($link);
		foreach ($result as $rows) {
			$html .= '<option value="' . $rows['assur_vehi_libelle'] . '">' . $rows['assur_vehi_libelle'] . '</option>';
		}
		// }
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getallmarque') {
		$html = "";
		// if (isset($_POST['cid']) && (int)$_POST['cid'] > 0) {
		$result = $wms->get_all_make_list($link);
		foreach ($result as $rows) {
			$html .= '<option value="' . $rows['make_name'] . '">' . $rows['make_name'] . '</option>';
		}
		// }
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getallmodel') {
		$html = "";
		// if (isset($_POST['cid']) && (int)$_POST['cid'] > 0) {
		$result = $wms->get_all_model_list($link);
		foreach ($result as $rows) {
			$html .= '<option value="' . $rows['model_name'] . '">' . $rows['model_name'] . '</option>';
		}
		// }
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getallclient') {
		// $html = "";
		// if (isset($_POST['cid']) && (int)$_POST['cid'] > 0) {
		$result = $wms->getAllCustomerList($link);
		// foreach ($result as $rows) {
		// 	$html .= '<option value="' . $rows['c_name'] . '">' . $rows['c_name'] . '</option>';
		// }
		// }
		// echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getstate') {
		$html = '<option value="">--Selectionnez une ville--</option>';
		if (isset($_POST['cid']) && (int) $_POST['cid'] > 0) {
			$result = $wms->getAllStateData($link, $_POST['cid']);
			foreach ($result as $rows) {
				$html .= '<option value="' . $rows['id'] . '">' . $rows['name'] . '</option>';
			}
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getmodel') {
		$html = '<option value="">--Veuillez sélectionner le modèle du véhicule--</option>';
		if (isset($_POST['mid']) && (int) $_POST['mid'] > 0) {
			$result_model = $wms->getModelListByMakeId($link, $_POST['mid']);

			foreach ($result_model as $rows) {
				$html .= '<option value="' . $rows['model_id'] . '">' . $rows['model_name'] . '</option>';
			}
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getvehidata') {
		if (isset($_POST['vehidata'])) {
			$result_car_date = $wms->getDateAssurVistechByImmaVehi_2($link, $_POST['vehidata']);

			// var_dump($result_car_date);
			// die();

			$html = '<div class="form-group row">
                            <div class="col-md-3">
                                <input type="checkbox" id="assur_recep_vehi" name="assur_recep_vehi" value="Assurance" class="form-check-input" checked>
                                <label for="assurance"><span style="color:red;">*</span> Assurance</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;" id="date_assurance">
                                <input readonly type="text" name="add_date_assurance" value="' . $result_car_date['add_date_assurance'] . '" id="add_date_assurance" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="checkbox" id="visitetech_recep_vehi" name="visitetech_recep_vehi" value="Visite technique" checked>
                                <label for="visite technique"><span style="color:red;">*</span> Visite technique</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;" id="date_visitetech">
                                <input readonly type="text" name="add_date_visitetech" value="' . $result_car_date['add_date_visitetech'] . '" id="add_date_visitetech" class="form-control" />
                            </div>
                        </div>';
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getmarquemodelevoiture') {
		// $html = '<option value="">--Veuillez sélectionner le véhicule correspondant à cette immatriculation--</option>';
		if (isset($_POST['immavehi'])) {
			$result_car_model = $wms->getMarkModelListByImmaVehi($link, $_POST['immavehi']);

			// var_dump($result_car_model);
			// die();

			// $html .= "<option value='" . $result_car_model['make_id']." ". $result_car_model['model_id']." ". $result_car_model['make_name']." ".$result_car_model['model_name']." ".$result_car_model['VIN'] . "'>" . $result_car_model['make_name']." ".$result_car_model['model_name']." ".$result_car_model['VIN'] . "</option>";
			//$html .= "<input readonly name='modeleMarqueVehi' id='marque_modele_vehi' class='form-control' value='". $result_car_model['make_id']." ". $result_car_model['model_id']." ". $result_car_model['make_name']." ".$result_car_model['model_name']." ".$result_car_model['VIN']."'>";
			$html = "<input readonly onfocus='loadVehiData();' name='modeleMarqueVehi' id='marque_modele_vehi' class='form-control' value='" . $result_car_model['make_name'] . " " . $result_car_model['model_name'] . " " . $result_car_model['VIN'] . "'>
				<input type='hidden' name='car_id' value='" . $result_car_model['car_id'] . "' />
				<input type='hidden' name='customer_id' value='" . $result_car_model['customer_id'] . "' />
				<input type='hidden' name='car_make_id' value='" . $result_car_model['make_id'] . "' />
				<input type='hidden' name='car_model_id' value='" . $result_car_model['model_id'] . "' />
				<input type='hidden' name='client_telephone' value='" . $result_car_model['princ_tel'] . "' />
				<input type='hidden' name='client_nom' value='" . $result_car_model['c_name'] . "' />
				";
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getsupplier') {
		if (isset($_POST['sid'])) {
			$result = $wms->getSupplierInfoBySupplierId($link, $_POST['sid']);

			// var_dump($result);
			// die();

			$html = "<input type='email' class='form-control' id='email' name='email' value='" . $result['s_email'] . "'>
				";
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getsuppliername') {
		if (isset($_POST['sid'])) {
			$result = $wms->getSupplierInfoBySupplierId($link, $_POST['sid']);

			// var_dump($result);
			// die();

			$html = "<input type='type' class='form-control' id='supplier' name='supplier' value='" . $result['s_name'] . "'>
				";
		}
		echo $html;
		die();
	}

	// if (isset($_POST['token']) && $_POST['token'] == 'getmarquemodelevoiture') {
	// 	$html = '<option value="">--Veuillez sélectionner le véhicule à enregistrer correspondant à ce client--</option>';
	// 	if (isset($_POST['clientid'])) {
	// 		$result_car_model = $wms->getMarkModelListByCustomerId($link, $_POST['clientid']);

	// 		foreach ($result_car_model as $rows) {
	// 			$html .= "<option value='" . $rows['make_id'] . " " . $rows['model_id'] . " " . $rows['make_name'] . " " . $rows['model_name'] . " " . $rows['VIN'] . "'>" .
	// 			$rows['make_name'] . " " . $rows['model_name'] . " " . $rows['VIN'] . "</option>";
	// 		}
	// 	}
	// 	echo $html;
	// 	die();
	// }

	// if (isset($_POST['token']) && $_POST['token'] == 'getmarquemodelevoiture') {
	// 	$html = '<option value="">--Veuillez sélectionner le véhicule à enregistrer correspondant à ce client--</option>';
	// 	if (isset($_POST['clientid'])) {
	// 		$result_car_model = $wms->getMarkModelListByCustomerId($link, $_POST['clientid']);

	// 		foreach ($result_car_model as $rows) {
	// 			$html .= "<option value='" . $rows['make_id']." ". $rows['model_id']." ". $rows['VIN']." ". $rows['add_car_id'] ." ".$rows['make_name']." ".$rows['model_name']. "'>" . 
	// 			$rows['make_name']." ".$rows['model_name']." ".$rows['VIN'] . "</option>";
	// 		}
	// 	}
	// 	echo $html;
	// 	die();
	// }

	if (isset($_POST['token']) && $_POST['token'] == 'getimmavoiture') {
		$html = "<option value=''>--Veuillez sélectionner l'immatriculation du véhicule--</option>";
		if (isset($_POST['clientid']) && (int) $_POST['clientid'] > 0) {
			$result_car = $wms->getCarListByCustomerId($link, $_POST['clientid']);

			foreach ($result_car as $rows) {
				$html .= '<option value="' . $rows['VIN'] . '">' . $rows['VIN'] . '</option>';
			}
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getdevis_pwd') {
		// $html = "<option value=''>--Veuillez sélectionner l'immatriculation du véhicule--</option>";

		$html = '';

		if (isset($_POST['devis_pwd'])) {
			$result = $wms->checkAdminPwd($link, $_POST['devis_pwd']);

			$html = "";

			if(count($result) > 0){
				$html = '<div class="alert alert-success alert-dismissable" style="display:block">
				<button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
				<h4> mot de passe valide </h4>
				</div>';
			}
			
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'getyear') {
		$html = '<option value="">--Sélectionnez année--</option>';
		if (isset($_POST['mid']) && (int) $_POST['mid'] > 0 && isset($_POST['moid']) && (int) $_POST['moid'] > 0) {
			$result_year = $wms->getYearlListByMakeIdAndModelId($link, $_POST['mid'], $_POST['moid']);
			foreach ($result_year as $rows) {
				$html .= '<option value="' . $rows['year_id'] . '">' . $rows['year_name'] . '</option>';
			}
		}
		echo $html;
		die();
	}

	if (isset($_POST['token']) && $_POST['token'] == 'save_estimate_data') {
		if (isset($_POST['car_id']) && (int) $_POST['car_id'] > 0) {
			$wms->ajaxUpdateEstimateData($link, $_POST);
			echo 'Updated estimate data successfully';
			die();
		}
		echo 'opps error occured refresh your page';
		die();
	}
} else {
	$url = WEB_URL . 'index.php';
	header("Location: $url");
	die();
}
