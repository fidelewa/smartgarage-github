<?php

include_once('../header.php');

// Traitement sur les champs de la marque et du modèle de véhicule "ddlMake" et "ddlModel"
$modeleMarqueVehiDatas = explode(" ", $_POST['modeleMarqueVehi']);

// Récupération du nom du client et de la voiture
// $_POST['ddlMake_name'] = $modeleMarqueVehiDatas[0];
// $_POST['ddlModel_name'] = $modeleMarqueVehiDatas[1];
// $_POST['ddlImma_name'] = $modeleMarqueVehiDatas[2];
// $_POST['client_telephone'];
// $_POST['client_nom'];

// $_POST['add_car_id'] = $modeleMarqueVehiDatas[3];

// var_dump($_POST);
// die();

$_POST['ddlImma'] = $_POST['immat'];
$_POST['add_car_id'] = $_POST['car_id'];
$_POST['ddlCustomerList'] = $_POST['customer_id'];
$_POST['ddlMake'] = $_POST['car_make_id'];
$_POST['ddlModel'] = $_POST['car_model_id'];

// var_dump($modeleMarqueVehiDatas);
// die();

// Structure de contrôle sur les clés "nullable" de la variable superglobale $_POST
if (empty($_POST['cle_recep_vehi'])) {
	$_POST['cle_recep_vehi'] = "";
}
if (empty($_POST['carte_grise_recep_vehi'])) {
	$_POST['carte_grise_recep_vehi'] = "";
}
if (empty($_POST['assur_recep_vehi'])) {
	$_POST['assur_recep_vehi'] = "";
}
if (empty($_POST['visitetech_recep_vehi'])) {
	$_POST['visitetech_recep_vehi'] = "";
}
if (empty($_POST['cric_levage_recep_vehi'])) {
	$_POST['cric_levage_recep_vehi'] = "";
}
if (empty($_POST['rallonge_roue_recep_vehi'])) {
	$_POST['rallonge_roue_recep_vehi'] = "";
}
if (empty($_POST['anneau_remorquage_recep_vehi'])) {
	$_POST['anneau_remorquage_recep_vehi'] = "";
}
if (empty($_POST['scanner_recep_vehi'])) {
	$_POST['scanner_recep_vehi'] = "";
}
if (empty($_POST['elec_recep_vehi'])) {
	$_POST['elec_recep_vehi'] = "";
}
if (empty($_POST['meca_recep_vehi'])) {
	$_POST['meca_recep_vehi'] = "";
}
if (empty($_POST['pb_meca_recep_vehi'])) {
	$_POST['pb_meca_recep_vehi'] = "";
}
if (empty($_POST['pb_electro_recep_vehi'])) {
	$_POST['pb_electro_recep_vehi'] = "";
}
if (empty($_POST['pb_demar_recep_vehi'])) {
	$_POST['pb_demar_recep_vehi'] = "";
}
if (empty($_POST['conf_cle_recep_vehi'])) {
	$_POST['conf_cle_recep_vehi'] = "";
}
if (empty($_POST['sup_adblue_recep_vehi'])) {
	$_POST['sup_adblue_recep_vehi'] = "";
}
if (empty($_POST['sup_fil_parti_recep_vehi'])) {
	$_POST['sup_fil_parti_recep_vehi'] = "";
}
if (empty($_POST['sup_vanne_egr_recep_vehi'])) {
	$_POST['sup_vanne_egr_recep_vehi'] = "";
}
if (empty($_POST['voy_alum_recep_vehi'])) {
	$_POST['voy_alum_recep_vehi'] = "";
}
if (empty($_POST['arriv_remarq_recep_vehi'])) {
	$_POST['arriv_remarq_recep_vehi'] = "";
}
if (empty($_POST['acc_recep_veh'])) {
	$_POST['acc_recep_veh'] = "";
}
if (empty($_POST['repare'])) {
	$_POST['repare'] = "";
}
if (empty($_POST['non_repare'])) {
	$_POST['non_repare'] = "";
}
if (empty($_POST['propre_sortie'])) {
	$_POST['propre_sortie'] = "";
}
if (empty($_POST['poussiereuse_sortie'])) {
	$_POST['poussiereuse_sortie'] = "";
}
if (empty($_POST['sortie_remarq_recep_vehi'])) {
	$_POST['sortie_remarq_recep_vehi'] = "";
}
// $image_url = $_POST['img_exist'];

// Echappement des caractères spéciaux

// Remarque sur la voiture à son arrivée
if (!empty($_POST['arriv_remarq_recep_vehi_text'])) {
	$_POST['arriv_remarq_recep_vehi_text'] = mysql_real_escape_string($_POST['arriv_remarq_recep_vehi_text']);
}

// Nom du client
if (!empty($_POST['ddlCustomerList'])) {
	$_POST['ddlCustomerList'] = mysql_real_escape_string($_POST['ddlCustomerList']);
}

// Nom du véhicule
if (!empty($_POST['car_names'])) {
	$_POST['car_names'] = mysql_real_escape_string($_POST['car_names']);
}

// Clé du véhicule
if (!empty($_POST['cle_recep_vehi_text'])) {
	$_POST['cle_recep_vehi_text'] = mysql_real_escape_string($_POST['cle_recep_vehi_text']);
}

// Travaux à effectuer
if (!empty($_POST['travo_effec'])) {
	$_POST['travo_effec'] = mysql_real_escape_string($_POST['travo_effec']);
}

// Autres observations
if (!empty($_POST['autres_obs'])) {
	$_POST['autres_obs'] = mysql_real_escape_string($_POST['autres_obs']);
}

// Remarque sur la voiture à sa sortie
if (!empty($_POST['sortie_remarq_recep_vehi_text'])) {
	$_POST['sortie_remarq_recep_vehi_text'] = mysql_real_escape_string($_POST['sortie_remarq_recep_vehi_text']);
}

// Récupération des URL des pièces jointes
if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
	$_POST['pj1_url'] = uploadPJ_1();
}
if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
	$_POST['pj2_url'] = uploadPJ_2();
}
if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
	$_POST['pj3_url'] = uploadPJ_3();
}
if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
	$_POST['pj4_url'] = uploadPJ_4();
}
if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
	$_POST['pj5_url'] = uploadPJ_5();
}
if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
	$_POST['pj6_url'] = uploadPJ_6();
}
if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
	$_POST['pj7_url'] = uploadPJ_7();
}
if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
	$_POST['pj8_url'] = uploadPJ_8();
}
if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
	$_POST['pj9_url'] = uploadPJ_9();
}
if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
	$_POST['pj10_url'] = uploadPJ_10();
}
if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
	$_POST['pj11_url'] = uploadPJ_11();
}
if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
	$_POST['pj12_url'] = uploadPJ_12();
}

// Fonction d'upload des pièces jointes
function uploadPJ_1()
{
	if ((!empty($_FILES["pj_1"])) && ($_FILES['pj_1']['error'] == 0)) {
		$filename = basename($_FILES['pj_1']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_1"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_1"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_1"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_1"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_1"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_1"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_2()
{
	if ((!empty($_FILES["pj_2"])) && ($_FILES['pj_2']['error'] == 0)) {
		$filename = basename($_FILES['pj_2']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_2"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_2"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_2"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_2"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_2"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_2"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_3()
{
	if ((!empty($_FILES["pj_3"])) && ($_FILES['pj_3']['error'] == 0)) {
		$filename = basename($_FILES['pj_3']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_3"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_3"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_3"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_3"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_3"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_3"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_4()
{
	if ((!empty($_FILES["pj_4"])) && ($_FILES['pj_4']['error'] == 0)) {
		$filename = basename($_FILES['pj_4']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_4"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_4"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_4"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_4"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_4"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_4"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_5()
{
	if ((!empty($_FILES["pj_5"])) && ($_FILES['pj_5']['error'] == 0)) {
		$filename = basename($_FILES['pj_5']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_5"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_5"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_5"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_5"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_5"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_5"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_6()
{
	if ((!empty($_FILES["pj_6"])) && ($_FILES['pj_6']['error'] == 0)) {
		$filename = basename($_FILES['pj_6']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_6"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_6"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_6"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_6"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_6"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_6"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_7()
{
	if ((!empty($_FILES["pj_7"])) && ($_FILES['pj_7']['error'] == 0)) {
		$filename = basename($_FILES['pj_7']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_7"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_7"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_7"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_7"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_7"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_7"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_8()
{
	if ((!empty($_FILES["pj_8"])) && ($_FILES['pj_8']['error'] == 0)) {
		$filename = basename($_FILES['pj_8']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_8"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_8"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_8"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_8"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_8"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_8"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_9()
{
	if ((!empty($_FILES["pj_9"])) && ($_FILES['pj_9']['error'] == 0)) {
		$filename = basename($_FILES['pj_9']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_9"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_9"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_9"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_9"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_9"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_9"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_10()
{
	if ((!empty($_FILES["pj_10"])) && ($_FILES['pj_10']['error'] == 0)) {
		$filename = basename($_FILES['pj_10']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_10"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_10"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_10"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_10"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_10"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_10"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_11()
{
	if ((!empty($_FILES["pj_11"])) && ($_FILES['pj_11']['error'] == 0)) {
		$filename = basename($_FILES['pj_11']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_11"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_11"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_11"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_11"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_11"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_11"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_12()
{
	if ((!empty($_FILES["pj_12"])) && ($_FILES['pj_12']['error'] == 0)) {
		$filename = basename($_FILES['pj_12']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_12"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_12"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_12"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_12"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_12"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			$newfilename = $filename;
			move_uploaded_file($_FILES["pj_12"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

// Traitement sur l'upload de l'image

function NewGuid()
{
	$s = strtoupper(md5(uniqid(rand(), true)));
	$guidText =
		substr($s, 0, 8) . '-' .
		substr($s, 8, 4) . '-' .
		substr($s, 12, 4) . '-' .
		substr($s, 16, 4) . '-' .
		substr($s, 20);
	return $guidText;
}

//for image upload
function uploadImage()
{
	if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
		$filename = basename($_FILES['uploaded_file']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if (($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')) {
			$temp = explode(".", $_FILES["uploaded_file"]["name"]);
			$newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
			return $newfilename;
		} else {
			return '';
		}
	}
	return '';
}

$image_url = uploadImage();
if (empty($image_url)) {
	$image_url = $_POST['img_exist'];
}

// var_dump($_POST);
// die();

// Exécution de la réquête et redirection vers la liste des voitures à faire réparer
$wms->saveRecepRepairCarInformation($link, $_POST, $image_url);

// importation du fichier de l'API SMS
require_once(ROOT_PATH . '/SmsApi.php');

// instanciation de la classe de l'API SMS
$smsApi = new SmsApi();

$make_name = $modeleMarqueVehiDatas[0];
$model_name = $modeleMarqueVehiDatas[1];
$immatri = $modeleMarqueVehiDatas[2];
$client_nom = $_POST['client_nom'];
$client_telephone = $_POST['client_telephone'];
// $client_telephone  = "02280768";

// Message d'alerte
$content_msg = $client_nom . ', votre véhicule ' . $make_name . ' ' . $model_name . ' ' . $immatri . ' a bien été réceptionné';

// $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

// Exécution de la méthode d'envoi 
$resultSmsSent = $smsApi->isSmsapi($client_telephone, $content_msg);

// On fait une redirection si le sms a été envoyé avec succès
if ($resultSmsSent) {

	if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add';
			header("Location: $url");
		}
	} else {

		if ((int) $_POST['repair_car'] > 0) {
			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up';
			header("Location: $url");
		} else {

			$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add';
			header("Location: $url");
		}
	}
} else {
	echo "L'envoi du SMS a échoué !";
}
