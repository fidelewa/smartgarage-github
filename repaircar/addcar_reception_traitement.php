<?php

include_once('../header.php');


function uploadPJ_carte_grise()
{
	if ((!empty($_FILES["pj_carte_grise"])) && ($_FILES['pj_carte_grise']['error'] == 0)) {
		$filename = basename($_FILES['pj_carte_grise']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_carte_grise"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_carte_grise"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_carte_grise"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_carte_grise"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_carte_grise"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_carte_grise"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_assurance_cedeao()
{
	if ((!empty($_FILES["pj_assurance_cedeao"])) && ($_FILES['pj_assurance_cedeao']['error'] == 0)) {
		$filename = basename($_FILES['pj_assurance_cedeao']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_assurance_cedeao"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_assurance_cedeao"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_assurance_cedeao"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_assurance_cedeao"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_assurance_cedeao"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_assurance_cedeao"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_assurance()
{
	if ((!empty($_FILES["pj_assurance"])) && ($_FILES['pj_assurance']['error'] == 0)) {
		$filename = basename($_FILES['pj_assurance']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_assurance"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_assurance"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_assurance"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_assurance"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_assurance"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_assurance"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_visite_tech()
{
	if ((!empty($_FILES["pj_visite_tech"])) && ($_FILES['pj_visite_tech']['error'] == 0)) {
		$filename = basename($_FILES['pj_visite_tech']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_visite_tech"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_visite_tech"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_visite_tech"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_visite_tech"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_visite_tech"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_visite_tech"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_otre_piece()
{
	if ((!empty($_FILES["pj_otre_piece"])) && ($_FILES['pj_otre_piece']['error'] == 0)) {
		$filename = basename($_FILES['pj_otre_piece']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_otre_piece"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_otre_piece"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_otre_piece"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_otre_piece"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_otre_piece"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_otre_piece"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_contrat_assurance()
{
	if ((!empty($_FILES["pj_contrat_assurance"])) && ($_FILES['pj_contrat_assurance']['error'] == 0)) {
		$filename = basename($_FILES['pj_contrat_assurance']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_contrat_assurance"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_contrat_assurance"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_contrat_assurance"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_contrat_assurance"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_contrat_assurance"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_contrat_assurance"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_1()
{
	if ((!empty($_FILES["pj_access_1"])) && ($_FILES['pj_access_1']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_1']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_1"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_1"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_1"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_1"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_1"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_1"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_2()
{
	if ((!empty($_FILES["pj_access_2"])) && ($_FILES['pj_access_2']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_2']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_2"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_2"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_2"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_2"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_2"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_2"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_3()
{
	if ((!empty($_FILES["pj_access_3"])) && ($_FILES['pj_access_3']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_3']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_3"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_3"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_3"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_3"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_3"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_3"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_4()
{
	if ((!empty($_FILES["pj_access_4"])) && ($_FILES['pj_access_4']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_4']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_4"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_4"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_4"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_4"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_4"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_4"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_5()
{
	if ((!empty($_FILES["pj_access_5"])) && ($_FILES['pj_access_5']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_5']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_5"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_5"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_5"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_5"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_5"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_5"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_access_6()
{
	if ((!empty($_FILES["pj_access_6"])) && ($_FILES['pj_access_6']['error'] == 0)) {
		$filename = basename($_FILES['pj_access_6']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_access_6"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_access_6"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_access_6"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_access_6"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_access_6"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_access_6"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_voyants_1()
{
	if ((!empty($_FILES["pj_voyants_1"])) && ($_FILES['pj_voyants_1']['error'] == 0)) {
		$filename = basename($_FILES['pj_voyants_1']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_voyants_1"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_voyants_1"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_voyants_1"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_voyants_1"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_voyants_1"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_3_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_voyants_1"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_voyants_2()
{
	if ((!empty($_FILES["pj_voyants_2"])) && ($_FILES['pj_voyants_2']['error'] == 0)) {
		$filename = basename($_FILES['pj_voyants_2']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_voyants_2"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_voyants_2"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_voyants_2"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_voyants_2"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_voyants_2"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_3_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_voyants_2"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_scanner_fr()
{
	if ((!empty($_FILES["pj_scanner_fr"])) && ($_FILES['pj_scanner_fr']['error'] == 0)) {
		$filename = basename($_FILES['pj_scanner_fr']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_scanner_fr"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_scanner_fr"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_scanner_fr"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_scanner_fr"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_scanner_fr"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_3_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_scanner_fr"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

if (isset($_FILES["pj_carte_grise"]) && !empty($_FILES["pj_carte_grise"])) {
	$_POST['pj_carte_grise'] = uploadPJ_carte_grise();
}
if (isset($_FILES["pj_assurance_cedeao"]) && !empty($_FILES["pj_assurance_cedeao"])) {
	$_POST['pj_assurance_cedeao'] = uploadPJ_assurance_cedeao();
}
if (isset($_FILES["pj_assurance"]) && !empty($_FILES["pj_assurance"])) {
	$_POST['pj_assurance'] = uploadPJ_assurance();
}
if (isset($_FILES["pj_visite_tech"]) && !empty($_FILES["pj_visite_tech"])) {
	$_POST['pj_visite_tech'] = uploadPJ_visite_tech();
}
if (isset($_FILES["pj_otre_piece"]) && !empty($_FILES["pj_otre_piece"])) {
	$_POST['pj_otre_piece'] = uploadPJ_otre_piece();
}
if (isset($_FILES["pj_contrat_assurance"]) && !empty($_FILES["pj_contrat_assurance"])) {
	$_POST['pj_contrat_assurance'] = uploadPJ_contrat_assurance();
}
if (isset($_FILES["pj_access_1"]) && !empty($_FILES["pj_access_1"])) {
	$_POST['pj_access_1'] = uploadPJ_access_1();
}
if (isset($_FILES["pj_access_2"]) && !empty($_FILES["pj_access_2"])) {
	$_POST['pj_access_2'] = uploadPJ_access_2();
}
if (isset($_FILES["pj_access_3"]) && !empty($_FILES["pj_access_3"])) {
	$_POST['pj_access_3'] = uploadPJ_access_3();
}
if (isset($_FILES["pj_access_4"]) && !empty($_FILES["pj_access_4"])) {
	$_POST['pj_access_4'] = uploadPJ_access_4();
}
if (isset($_FILES["pj_access_5"]) && !empty($_FILES["pj_access_5"])) {
	$_POST['pj_access_5'] = uploadPJ_access_5();
}
if (isset($_FILES["pj_access_6"]) && !empty($_FILES["pj_access_6"])) {
	$_POST['pj_access_6'] = uploadPJ_access_6();
}

if (isset($_FILES["pj_voyants_1"]) && !empty($_FILES["pj_voyants_1"])) {
	$_POST['pj_voyants_1'] = uploadPJ_voyants_1();
}
if (isset($_FILES["pj_voyants_2"]) && !empty($_FILES["pj_voyants_2"])) {
	$_POST['pj_voyants_2'] = uploadPJ_voyants_2();
}

if (isset($_FILES["pj_scanner_fr"]) && !empty($_FILES["pj_scanner_fr"])) {
	$_POST['pj_scanner_fr'] = uploadPJ_scanner_fr();
}

// var_dump($_POST['carte_grise_numero']);
// var_dump($_POST['pj_carte_grise']);
// var_dump($_POST['visite_tech_numero']);
// var_dump($_POST['pj_visite_tech']);
// var_dump($_POST['assurance_numero']);
// var_dump($_POST['pj_assurance']);
// var_dump($_POST['assurance_cedeao_recep_vehi']);
// var_dump($_POST['pj_assurance_cedeao']);
// var_dump($_POST['contrat_assurance_recep_vehi']);
// var_dump($_POST['pj_contrat_assurance']);
// var_dump($_POST['otre_piece_numero']);
// var_dump($_POST['otre_piece_recep_vehi']);
// var_dump($_POST['date_otre_piece_recep_vehi']);
// var_dump($_POST['pj_otre_piece']);

// var_dump($_POST['pj_access_1']);
// var_dump($_POST['pj_access_2']);
// var_dump($_POST['pj_access_3']);
// var_dump($_POST['pj_access_4']);
// var_dump($_POST['pj_access_5']);
// var_dump($_POST['pj_access_6']);

// var_dump($_POST['pj_voyants_1']);
// var_dump($_POST['pj_voyants_2']);

// var_dump($_POST['pj_scanner_fr']);

// die();

// Fonction d'upload des pièces jointes
function uploadPJ_1_car()
{
	if ((!empty($_FILES["pj_1_car"])) && ($_FILES['pj_1_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_1_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_1_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_1_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_1_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_1_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_1_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_1_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

// Fonction d'upload des pièces jointes
function uploadPJ_2_car()
{
	if ((!empty($_FILES["pj_2_car"])) && ($_FILES['pj_2_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_2_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_2_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_2_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_2_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_2_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_2_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_2_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_2_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

// Fonction d'upload des pièces jointes
function uploadPJ_3_car()
{
	if ((!empty($_FILES["pj_3_car"])) && ($_FILES['pj_3_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_3_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_3_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_3_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_3_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_3_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_3_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_3_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_3_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

// Fonction d'upload des pièces jointes
function uploadPJ_4_car()
{
	if ((!empty($_FILES["pj_4_car"])) && ($_FILES['pj_4_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_4_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_4_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_4_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_4_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_4_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_4_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_4_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_4_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

// Fonction d'upload des pièces jointes
function uploadPJ_5_car()
{
	if ((!empty($_FILES["pj_5_car"])) && ($_FILES['pj_5_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_5_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_5_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_5_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_5_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_5_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_5_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_5_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_5_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_6_car()
{
	if ((!empty($_FILES["pj_6_car"])) && ($_FILES['pj_6_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_6_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_6_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_6_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_6_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_6_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_6_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_6_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_6_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_7_car()
{
	if ((!empty($_FILES["pj_7_car"])) && ($_FILES['pj_7_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_7_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_7_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_7_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_7_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_7_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_7_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_7_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_8_car()
{
	if ((!empty($_FILES["pj_8_car"])) && ($_FILES['pj_8_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_8_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_8_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_8_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_8_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_8_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_8_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_8_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_9_car()
{
	if ((!empty($_FILES["pj_9_car"])) && ($_FILES['pj_9_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_9_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_9_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_9_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_9_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_9_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_9_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_9_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_10_car()
{
	if ((!empty($_FILES["pj_10_car"])) && ($_FILES['pj_10_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_10_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_10_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_10_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_10_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_10_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_10_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_10_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_11_car()
{
	if ((!empty($_FILES["pj_11_car"])) && ($_FILES['pj_11_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_11_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_11_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_11_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_11_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_11_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_11_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_11_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_12_car()
{
	if ((!empty($_FILES["pj_12_car"])) && ($_FILES['pj_12_car']['error'] == 0)) {
		$filename = basename($_FILES['pj_12_car']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_12_car"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_12_car"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_12_car"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_12_car"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_12_car"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1_car"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_12_car"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

// Enregistrement des informations du véhicule
if (isset($_POST['car_names'])) {

	// TRAITEMENT DES PIECES JOINTES

	// Récupération des URL des pièces jointes
	if (isset($_FILES["pj_1_car"]) && !empty($_FILES["pj_1_car"])) {
		$_POST['pj1_url_car'] = uploadPJ_1_car();
	}
	if (isset($_FILES["pj_2_car"]) && !empty($_FILES["pj_2_car"])) {
		$_POST['pj2_url_car'] = uploadPJ_2_car();
	}
	if (isset($_FILES["pj_3_car"]) && !empty($_FILES["pj_3_car"])) {
		$_POST['pj3_url_car'] = uploadPJ_3_car();
	}
	if (isset($_FILES["pj_4_car"]) && !empty($_FILES["pj_4_car"])) {
		$_POST['pj4_url_car'] = uploadPJ_4_car();
	}
	if (isset($_FILES["pj_5_car"]) && !empty($_FILES["pj_5_car"])) {
		$_POST['pj5_url_car'] = uploadPJ_5_car();
	}
	if (isset($_FILES["pj_6_car"]) && !empty($_FILES["pj_6_car"])) {
		$_POST['pj6_url_car'] = uploadPJ_6_car();
	}
	if (isset($_FILES["pj_7_car"]) && !empty($_FILES["pj_7_car"])) {
		$_POST['pj7_url_car'] = uploadPJ_7_car();
	}
	if (isset($_FILES["pj_8_car"]) && !empty($_FILES["pj_8_car"])) {
		$_POST['pj8_url_car'] = uploadPJ_8_car();
	}
	if (isset($_FILES["pj_9_car"]) && !empty($_FILES["pj_9_car"])) {
		$_POST['pj9_url_car'] = uploadPJ_9_car();
	}
	if (isset($_FILES["pj_10_car"]) && !empty($_FILES["pj_10_car"])) {
		$_POST['pj10_url_car'] = uploadPJ_10_car();
	}
	if (isset($_FILES["pj_11_car"]) && !empty($_FILES["pj_11_car"])) {
		$_POST['pj11_url_car'] = uploadPJ_11_car();
	}
	if (isset($_FILES["pj_12_car"]) && !empty($_FILES["pj_12_car"])) {
		$_POST['pj12_url_car'] = uploadPJ_12_car();
	}

	$image_url = uploadImage();
	if (empty($image_url)) {
		$image_url = $_POST['img_exist'];
	}

	// var_dump($_POST);
	// die();

	// Initialisation des variables

	// ETAPE 1
	$marque_name_form = $_POST['ddlMake'];
	$modele_name_form = $_POST['ddlModel'];
	$client_name_form = $_POST['ddlCustomerList'];
	$assurance_form = $_POST['assurance_vehi_recep'];
	$make_id = null;
	$modele_id = null;
	$client_id = null;
	$modeleMakeId  = null;
	$listeMarques = array();
	$listeModeles = array();
	$listeClient = array();
	$listeChefMechElec = array();
	$listeAssurance = array();
	$cptOccur = 0;

	// Marque
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_marque_name_form = str_split($marque_name_form);
	$arr_marque_name_form_str = $arr_marque_name_form[0];

	// Client
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_client_name_form = str_split($client_name_form);
	$arr_client_name_form_str = $arr_client_name_form[0];

	// Assurance
	// On converti la chaine de caractère de la marque en array et on récupère le premier caractère de cette valeur
	$arr_assurance_form = str_split($assurance_form);
	$arr_assurance_form_str = $arr_assurance_form[0];

	// print($arr_client_name_form_str);
	// die();

	// ETAPE 2

	// Chef mécanicien et électricien
	$queryChefMechElec = "SELECT * FROM tbl_add_mech WHERE usr_type IN ('chef mecanicien','chef electricien')";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$resultChefMechElec = mysql_query($queryChefMechElec, $link);

	// if (!$resultChefMechElec) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' .  $$queryChefMechElec;
	// 	die($message);
	// }

	// On récupère la liste des chefs mécaniciens et électriciens
	while ($row = mysql_fetch_assoc($resultChefMechElec)) {
		$listeChefMechElec[] = $row;
	}

	// Assurance
	$queryAssur = "SELECT * FROM tbl_assurance_vehicule WHERE assur_vehi_libelle LIKE '" . $arr_assurance_form_str . "%'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$resultAssur = mysql_query($queryAssur, $link);

	// if (!$resultAssur) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' .  $queryAssur;
	// 	die($message);
	// }

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultAssur)) {
		$listeAssurance[] = $row;
	}

	// var_dump($assurance_form);
	// var_dump($listeAssurance);

	// S'il y a en BDD des noms d'assurances correspondant à la valeur de l'assurance fournie via le formulaire
	foreach ($listeAssurance as $assurance) {
		if ($assurance_form == $assurance['assur_vehi_libelle']) {
			$cptOccur += 1; // On incrémente un compteur d'occurence
		}
	}

	// var_dump($cptOccur);
	// die();

	// Si le compteur d'occurences est égale à 0, on fait une insertion
	if ($cptOccur == 0) {
		// Insertion du nom de la marque dans la table des marques
		$queryInsertAssur = "INSERT INTO tbl_assurance_vehicule (assur_vehi_libelle) VALUES('$assurance_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertAssur = mysql_query($queryInsertAssur, $link);

		// if (!$resultInsertAssur) {
		// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
		// 	$message .= 'Whole query: ' . $queryInsertAssur;
		// 	die($message);
		// }
	}

	// Client
	$queryClient = "SELECT customer_id, c_name, princ_tel FROM tbl_add_customer WHERE c_name LIKE '" . $arr_client_name_form_str . "%'";

	// On exécute la requête
	$resultListeClient = mysql_query($queryClient, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	// if (!$resultListeClient) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' . $queryClient;
	// 	die($message);
	// }

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultListeClient)) {
		$listeClient[] = $row;
	}

	// var_dump($client_name_form);
	// var_dump($listeClient);
	// die();

	// Marque
	$queryMarque = "SELECT * FROM tbl_make WHERE make_name LIKE '" . $arr_marque_name_form_str . "%'";

	// On exécute la requête
	$resultListeMarques = mysql_query($queryMarque, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	// if (!$resultListeMarques) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' . $queryMarque;
	// 	die($message);
	// }

	// On récupère la liste des marques commençant par le même caractère que la valeur de la marque soumise via le formulaire
	while ($row = mysql_fetch_assoc($resultListeMarques)) {
		$listeMarques[] = $row;
	}

	// var_dump($marque_name_form);
	// var_dump($listeMarques);
	// die();

	// Modèle

	// On converti la chaine de caractère du modèle en array et on récupère le premier caractère de cette valeur
	$arr_modele_name_form = str_split($modele_name_form);
	$arr_modele_name_form_str = $arr_modele_name_form[0];

	// Récupération du nom de la marque qui a pour id la valeur retourné par la variable $_POST['ddlMake']
	$queryModele = "SELECT * FROM tbl_model WHERE model_name LIKE '" . $arr_modele_name_form_str . "%'";

	// On exécute la requête
	$resultListeModeles = mysql_query($queryModele, $link);

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	// if (!$resultListeModeles) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' . $queryModele;
	// 	die($message);
	// }

	// On récupère la liste des modèles commençant par le même caractère que la valeur du modèle soumis via le formulaire
	while ($row = mysql_fetch_assoc($resultListeModeles)) {
		$listeModeles[] = $row;
	}

	// var_dump($listeModeles);

	// ETAPE 3
	// Parcours des marques
	foreach ($listeMarques as $marque) {
		if ($marque_name_form == $marque['make_name']) {
			$make_id = $marque['make_id'];
			$make_name = $marque['make_name'];
		}
	}

	// Parcours des modèles
	foreach ($listeModeles as $modele) {
		if ($modele_name_form == $modele['model_name']) {
			$modele_id = $modele['model_id'];
			$model_name = $modele['model_name'];
		}
	}

	// Parcours des clients
	foreach ($listeClient as $client) {
		if ($client_name_form == $client['c_name']) {
			$client_id = $client['customer_id'];
			// récupération du numéro de téléphone du client
			$client_telephone = $client['princ_tel'];
			$client_nom = $client['c_name'];
		}
	}

	// var_dump($make_id);
	// var_dump($modele_id);
	// var_dump($client_id);
	// die();

	// ETAPE 4

	// CLIENT
	// Si le nom du client soumis via le formulaire correspond à un nom de client existant en BDD
	// on récupère l'id de cet client en BDD que l'on affecte à la variable $_POST['ddlCustomerList']
	if ($client_id != null) {
		(int) $_POST['ddlCustomerList'] = (int) $client_id;
	}

	if ($client_telephone != null) {
		$_POST['client_telephone'] = $client_telephone;
	}

	// MARQUE
	if ($make_id == null) {

		// Insertion du nom de la marque dans la table des marques
		$queryInsertMake = "INSERT INTO tbl_make (make_name) VALUES('$marque_name_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertMake = mysql_query($queryInsertMake, $link);

		// if (!$resultInsertMake) {
		// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
		// 	$message .= 'Whole query: ' . $queryInsertMake;
		// 	die($message);
		// }

		// Récupération de l'id de la nouvelle marque pour faire l'insertion du modèle en BDD
		$queryGetMakeId = "SELECT make_id FROM tbl_make WHERE make_name='" . $marque_name_form . "'";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultMakeId = mysql_query($queryGetMakeId, $link);

		// if (!$resultMakeId) {
		// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
		// 	$message .= 'Whole query: ' . $queryGetMakeId;
		// 	die($message);
		// }

		// On retourne les données de la marque référencée dans un tableau associatif
		$rowMakeId = mysql_fetch_assoc($resultMakeId);

		// affectation de la valeur de l'identifiant de la marque
		$modeleMakeId = (int) $rowMakeId['make_id'];
		// On rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
		$_POST['ddlMake'] = (int) $modeleMakeId;

		// var_dump($rowMakeId);
		// die();

	} else {
		// Si une marque exitant en BDD correspond à la valeur de la marque soumise via le formulaire de saisie
		//  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant de la marque qui sera persistée dans la table tbl_add_car
		$modeleMakeId = (int) $make_id;
		$_POST['ddlMake'] = (int) $make_id;
		// var_dump($make_id);
	}

	// MODELE
	if ($modele_id == null) {

		// Insertion du nom du modele et de l'id de la marque dans la table des modèles
		$queryInsertModel = "INSERT INTO tbl_model (make_id, model_name) VALUES('$modeleMakeId','$modele_name_form')";

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		$resultInsertModel = mysql_query($queryInsertModel, $link);

		// if (!$resultInsertModel) {
		// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
		// 	$message .= 'Whole query: ' . $queryInsertModel;
		// 	die($message);
		// }

		// Récupération de l'id du nouveau modèle de voiture ajouté
		$queryGetModeleId = "SELECT model_id FROM tbl_model WHERE model_name='" . $modele_name_form . "'";

		// On exécute la requête
		$resultModeleId = mysql_query($queryGetModeleId, $link);

		// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
		// if (!$resultModeleId) {
		// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
		// 	$message .= 'Whole query: ' . $queryGetModeleId;
		// 	die($message);
		// }

		// On retourne les données du modèle référencé dans un tableau associatif
		$rowModeleId = mysql_fetch_assoc($resultModeleId);

		// On rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
		$_POST['ddlModel'] = (int) $rowModeleId['model_id'];

		// var_dump($rowModeleId);
		// die();

	} else {
		// Si un modèle exitant en BDD correspond à la valeur du modèle soumis via le formulaire de saisie
		//  On récupère la valeur de son id et on rédéfini la valeur de l'identifiant du modèle qui sera persistée dans la table tbl_add_car
		$modele_id = (int) $modele_id;
		$_POST['ddlModel'] = (int) $modele_id;
		// var_dump($modele_id);
		// die();
	}

	// Récupération du nom de la marque qui a pour id la valeur retourné par le component $_POST['ddlMake']
	$query = "SELECT make_name FROM tbl_make WHERE make_id='" . (int) $_POST['ddlMake'] . "'";

	// On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
	$result = mysql_query($query, $link);

	// if (!$result) {
	// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
	// 	$message .= 'Whole query: ' . $query;
	// 	die($message);
	// }

	// On retourne le nom de la marque dans un tableau associatif
	$row = mysql_fetch_array($result);

	// On affecte le nom de la marque à la variable $_POST['car_names']
	$_POST['car_names'] = $row['make_name'];

	$_POST['add_date_visitetech'] = $_POST['add_date_visitetech_car'];
	$_POST['add_date_assurance'] = $_POST['add_date_assurance_car'];

	// var_dump($_POST);
	// die();

	// var_dump($_SESSION);
	// die();

	// TRAITEMENT DE LA VISITE TECHNIQUE
	if (isset($_POST['add_date_visitetech'])) { // Si la date de la visite technique existe

		// On crée un objet Datetime à partir du format chaine de caractère de la date de la visite technique
		$dateprochvistech = DateTime::createFromFormat('d/m/Y', $_POST['add_date_visitetech']);

		if ($dateprochvistech instanceof DateTime) {

			// Définition du statut de la visite technique
			$diffTodayDateprochvistech = $dateprochvistech->diff(new \DateTime())->format('%R%a');

			$diffTodayDateprochvistechStr = $dateprochvistech->diff(new \DateTime())->format(' %a jours');

			// conversion en entier
			$diffTodayDateprochvistech = (int) $diffTodayDateprochvistech;
		}

		if ($diffTodayDateprochvistech < -14) {
			$_POST['statut_vistech'] = "valide";
		}
	}

	// TRAITEMENT DE L'ASSURANCE
	if (isset($_POST['add_date_assurance']) && isset($_POST['add_date_assurance_fin'])) {

		$dateFinAssur = DateTime::createFromFormat('d/m/Y', $_POST['add_date_assurance_fin']);

		if ($dateFinAssur instanceof DateTime) {

			$diffDateDebutFinAssur = $dateFinAssur->diff(new \DateTime())->format('%R%a');
			$diffDateDebutFinAssurStr = $dateFinAssur->diff(new \DateTime())->format(' %a jours');

			// conversion en entier
			$diffDateDebutFinAssur = (int) $diffDateDebutFinAssur;
		}

		if ($diffDateDebutFinAssur < -14) {
			$_POST['statut_assurance'] = "valide";
		}
	}

	// var_dump($_POST['statut_assurance']);
	// var_dump($_POST['statut_vistech']);
	// die();

	// var_dump($_FILES);
	// die();

	// var_dump($_POST);
	// die();

	// On insère la nouvelle valeur de la colonne car_name en BDD
	$wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);
}

$result_car_model = $wms->getMarkModelListByImmaVehi($link, $_POST['vin']);

// $result_car_model['customer_id'];
// $result_car_model['make_id'];
// $result_car_model['model_id'];
$_POST['ddlImma'] = $_POST['vin'];
$imma_vehi = $_POST['vin'];
$_POST['add_car_id'] = $result_car_model['car_id'];
// $_POST['ddlCustomerList'] = $_POST['customer_id'];
// $_POST['ddlMake'] = $_POST['car_make_id'];
// $_POST['ddlModel'] = $_POST['car_model_id'];

// var_dump($result_car_model);
// var_dump($_POST);
// die();

// Affectation des dates de l'assurance et de la visite technique du formulaire de création d'un véhicule
// aux variables $_POST des dates de l'assurance et de la visite technique du formulaire de réception d'un véhicule

// Structure de contrôle sur les clés "nullable" de la variable superglobale $_POST

if (empty($_POST['otre_piece_recep_vehi'])) {
	$_POST['otre_piece_recep_vehi'] = "";
}

if (empty($_POST['contrat_assurance_recep_vehi'])) {
	$_POST['contrat_assurance_recep_vehi'] = "";
}
if (empty($_POST['cle_recep_vehi'])) {
	$_POST['cle_recep_vehi'] = "";
}
if (empty($_POST['carte_grise_recep_vehi'])) {
	$_POST['carte_grise_recep_vehi'] = "";
} 
if (empty($_POST['assur_recep_vehi'])) {
	$_POST['assur_recep_vehi'] = "";
}
if (empty($_POST['assurance_cedeao_recep_vehi'])) {
	$_POST['assurance_cedeao_recep_vehi'] = "";
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

if (!empty($_POST['dim_pneu'])) {
	$_POST['dim_pneu'] = mysql_real_escape_string($_POST['dim_pneu']);
}

if (!empty($_POST['remarque_access_vehi'])) {
	$_POST['remarque_access_vehi'] = mysql_real_escape_string($_POST['remarque_access_vehi']);
}

if (!empty($_POST['remarque_motif_depot'])) {
	$_POST['remarque_motif_depot'] = mysql_real_escape_string($_POST['remarque_motif_depot']);
}

if (!empty($_POST['remarque_etat_vehi_arrive'])) {
	$_POST['remarque_etat_vehi_arrive'] = mysql_real_escape_string($_POST['remarque_etat_vehi_arrive']);
}

if (!empty($_POST['remarque_aspect_ext'])) {
	$_POST['remarque_aspect_ext'] = mysql_real_escape_string($_POST['remarque_aspect_ext']);
}

if (!empty($_POST['remarque_aspect_int'])) {
	$_POST['remarque_aspect_int'] = mysql_real_escape_string($_POST['remarque_aspect_int']);
}

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


// Récupération des fichiers joints de la réception
// Récupération des URL des pièces jointes
if (isset($_FILES["pj_1_recep"]) && !empty($_FILES["pj_1_recep"])) {
	$_POST['pj1_url'] = uploadPJ_1_recep();
}
if (isset($_FILES["pj_2_recep"]) && !empty($_FILES["pj_2_recep"])) {
	$_POST['pj2_url'] = uploadPJ_2_recep();
}
if (isset($_FILES["pj_3_recep"]) && !empty($_FILES["pj_3_recep"])) {
	$_POST['pj3_url'] = uploadPJ_3_recep();
}
if (isset($_FILES["pj_4_recep"]) && !empty($_FILES["pj_4_recep"])) {
	$_POST['pj4_url'] = uploadPJ_4_recep();
}
if (isset($_FILES["pj_5_recep"]) && !empty($_FILES["pj_5_recep"])) {
	$_POST['pj5_url'] = uploadPJ_5_recep();
}
if (isset($_FILES["pj_6_recep"]) && !empty($_FILES["pj_6_recep"])) {
	$_POST['pj6_url'] = uploadPJ_6_recep();
}
if (isset($_FILES["pj_7_recep"]) && !empty($_FILES["pj_7_recep"])) {
	$_POST['pj7_url'] = uploadPJ_7_recep();
}
if (isset($_FILES["pj_8_recep"]) && !empty($_FILES["pj_8_recep"])) {
	$_POST['pj8_url'] = uploadPJ_8_recep();
}
if (isset($_FILES["pj_9_recep"]) && !empty($_FILES["pj_9_recep"])) {
	$_POST['pj9_url'] = uploadPJ_9_recep();
}
if (isset($_FILES["pj_10_recep"]) && !empty($_FILES["pj_10_recep"])) {
	$_POST['pj10_url'] = uploadPJ_10_recep();
}
if (isset($_FILES["pj_11_recep"]) && !empty($_FILES["pj_11_recep"])) {
	$_POST['pj11_url'] = uploadPJ_11_recep();
}
if (isset($_FILES["pj_12_recep"]) && !empty($_FILES["pj_12_recep"])) {
	$_POST['pj12_url'] = uploadPJ_12_recep();
}

function uploadPJ_1_recep()
{
	if ((!empty($_FILES["pj_1_recep"])) && ($_FILES['pj_1_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_1_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_1_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_1_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_1_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_1_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_1_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_1_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_2_recep()
{
	if ((!empty($_FILES["pj_2_recep"])) && ($_FILES['pj_2_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_2_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_2_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_2_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_2_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_2_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_2_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_2_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_3_recep()
{
	if ((!empty($_FILES["pj_3_recep"])) && ($_FILES['pj_3_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_3_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_3_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_3_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_3_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_3_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_3_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_3_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_4_recep()
{
	if ((!empty($_FILES["pj_4_recep"])) && ($_FILES['pj_4_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_4_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_4_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_4_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_4_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_4_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_4_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_4_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_5_recep()
{
	if ((!empty($_FILES["pj_5_recep"])) && ($_FILES['pj_5_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_5_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_5_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_5_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_5_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_5_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_5_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_5_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_6_recep()
{
	if ((!empty($_FILES["pj_6_recep"])) && ($_FILES['pj_6_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_6_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_6_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_6_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_6_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_6_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_6_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_6_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_7_recep()
{
	if ((!empty($_FILES["pj_7_recep"])) && ($_FILES['pj_7_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_7_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_7_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_7_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_7_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_7_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_7_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_7_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_8_recep()
{
	if ((!empty($_FILES["pj_8_recep"])) && ($_FILES['pj_8_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_8_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_8_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_8_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_8_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_8_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_8_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_8_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_9_recep()
{
	if ((!empty($_FILES["pj_9_recep"])) && ($_FILES['pj_9_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_9_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_9_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_9_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_9_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_9_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_9_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_9_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_10_recep()
{
	if ((!empty($_FILES["pj_10_recep"])) && ($_FILES['pj_10_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_10_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_10_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_10_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_10_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_10_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_10_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_10_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_11_recep()
{
	if ((!empty($_FILES["pj_11_recep"])) && ($_FILES['pj_11_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_11_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_11_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_11_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_11_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_11_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_11_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_11_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
		} else {
			return '';
		}
	}
	return '';
}

function uploadPJ_12_recep()
{
	if ((!empty($_FILES["pj_12_recep"])) && ($_FILES['pj_12_recep']['error'] == 0)) {
		$filename = basename($_FILES['pj_12_recep']['name']);
		$ext = substr($filename, strrpos($filename, '.') + 1);
		if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_12_recep"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_12_recep"]["type"] == 'image/png')
			|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_12_recep"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_12_recep"]["type"] == 'application/pdf')
			|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_12_recep"]["type"] == 'text/plain')
			|| ($ext == "docx" || $ext == "DOCX")
		) {
			// $temp = explode(".", $_FILES["pj_1"]["name"]);
			// $newfilename = NewGuid() . '.' . end($temp);
			move_uploaded_file($_FILES["pj_12_recep"]["tmp_name"], ROOT_PATH . '/img/upload/docs/reception_vehicule/' . $filename);
			return $filename;
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
if (isset($_POST['recep_id'])) {
	$_POST['recep_id'] = (int) $_POST['recep_id'];
}

// Conversion d'ajustement en entier de l'identifiant de la voiture
$_POST['add_car_id'] = (int) $_POST['add_car_id'];

// var_dump($client_nom);
// var_dump($make_name);
// var_dump($model_name);
// var_dump($_POST['ddlImma']);
// die();

// On défini le statut de réception du véhicule
$query = "UPDATE tbl_vehicule_scanning SET statut_reception=1 WHERE id='" . (int) $_POST['vehicule_scanner_id'] . "'";

// Exécution de la requête
mysql_query($query, $link);

// Vérification du résultat de la requête et affichage d'un message en cas d'erreur
// if (!$result) {
// 	$message  = 'Invalid query: ' . mysql_error() . "\n";
// 	$message .= 'Whole query: ' . $query;
// 	die($message);
// }

// Exécution de la réquête et redirection vers la liste des voitures à faire réparer
$wms->saveRecepRepairCarInformation($link, $_POST, $image_url);

// On récupère l'identifiant du dernier véhicule réceptionné
$_POST['reception_id'] = mysql_insert_id();

// On récupère les informations d'un véhicule à faire scanner à partir de l'identifiant
// de son scanning
$row = $wms->getCarScanningById($link, (int) $_POST['vehicule_scanner_id']);

// Si un véhicule doit subir uniquement un scanner mécanique alors
// le chef mécanicien reçoit directement ce véhicule au niveau de son dashboard
if ($row['scanner_mecanique'] == 'OUI' && $row['scanner_electrique'] == '') {

	$queryMech = "UPDATE tbl_recep_vehi_repar 
        SET attribution_mecanicien= 'chef mecanicien'
		WHERE car_id='" . (int) $_POST['reception_id'] . "'";

	// var_dump($_POST['reception_id']);
	// var_dump($queryMech);
	// die();

	// Exécution de la requête
	mysql_query($queryMech, $link);
}

// Si un véhicule doit subir uniquement un scanner électrique alors
// le chef électricien reçoit directement ce véhicule au niveau de son dashboard
if ($row['scanner_mecanique'] == '' && $row['scanner_electrique'] == 'OUI') {

	$queryElec = "UPDATE tbl_recep_vehi_repar 
        SET attribution_electricien= 'chef electricien'
		WHERE car_id='" . (int) $_POST['reception_id'] . "'";

	// var_dump($_POST['reception_id']);
	// var_dump($queryElec);
	// die();

	// Exécution de la requête
	mysql_query($queryElec, $link);
}

// Si un véhicule doit subir à la fois un scanner électrique et un scanner mécanique alors
// les chefs électriciens et mécaniciens reçoivent directement ce véhicule au niveau de leur dashboard
if ($row['scanner_mecanique'] == 'OUI' && $row['scanner_electrique'] == 'OUI') {

	$queryElec = "UPDATE tbl_recep_vehi_repar 
        SET attribution_electricien= 'chef electricien',
		attribution_mecanicien= 'chef mecanicien'
		WHERE car_id='" . (int) $_POST['reception_id'] . "'";

	// var_dump($_POST['reception_id']);
	// var_dump($queryElec);
	// die();

	// Exécution de la requête
	mysql_query($queryElec, $link);
}

// Envoi de SMS aux clients, chef mécanicien et chef électricien
include(ROOT_PATH . '/sendSmsToChefMechElec_2.php');
include(ROOT_PATH . '/sendSmsToClient_2.php');

// if (isset($_SESSION['objRecep']) && $_SESSION['login_type'] == "reception") {

// 	if ((int) $_POST['repair_car'] > 0) {
// 		$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=up';
// 		header("Location: $url");
// 	} else {

// 		$url = WEB_URL . 'recep_panel/recep_dashboard.php?m=add';
// 		header("Location: $url");
// 	}
// } else {

// 	if ((int) $_POST['repair_car'] > 0) {
// 		$url = WEB_URL . 'reception/repaircar_reception_list.php?m=up';
// 		header("Location: $url");
// 	} else {

// 		$url = WEB_URL . 'reception/repaircar_reception_list.php?m=add';
// 		header("Location: $url");
// 	}
// }
