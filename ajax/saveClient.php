<?php
include("../config.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	include("../dbconfig.php");
	include("../helper/common.php");
	$wms = new wms_core();

	if (isset($_POST) && !empty($_POST)) {
		$_POST['txtCPassword'] = $_POST['princ_tel'];
		$_POST['tel_wa'] = $_POST['princ_tel'];

		// Salage du mot de passe du client
		$salt = "53fYcjF!Vq&bDw".$_POST['txtCPassword']."&MuURm@86BsUtD";

		// Hachage du mot de passe du client
		$hashed = hash('sha512',$salt);

		// Affectation de mot de passe hashé
		$_POST['txtCPassword'] = $hashed;

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

		function uploadPJ_1_client()
		{
			if ((!empty($_FILES["pj_1_client"])) && ($_FILES['pj_1_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_1_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_1_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_1_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_1_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_1_client"]["type"] == 'application/pdf') 
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_1_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_1_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_1_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		function uploadPJ_2_client()
		{
			if ((!empty($_FILES["pj_2_client"])) && ($_FILES['pj_2_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_2_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_2_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_2_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_2_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_2_client"]["type"] == 'application/pdf')
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_2_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_2_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_2_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		function uploadPJ_3_client()
		{
			if ((!empty($_FILES["pj_3_client"])) && ($_FILES['pj_3_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_3_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_3_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_3_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_3_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_3_client"]["type"] == 'application/pdf')
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_3_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_3_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_3_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		function uploadPJ_4_client()
		{
			if ((!empty($_FILES["pj_4_client"])) && ($_FILES['pj_4_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_4_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_4_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_4_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_4_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_4_client"]["type"] == 'application/pdf')
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_4_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_4_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_4_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		function uploadPJ_5_client()
		{
			if ((!empty($_FILES["pj_5_client"])) && ($_FILES['pj_5_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_5_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_5_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_5_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_5_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_5_client"]["type"] == 'application/pdf')
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_5_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_5_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_5_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		function uploadPJ_6_client()
		{
			if ((!empty($_FILES["pj_6_client"])) && ($_FILES['pj_6_client']['error'] == 0)) {
				$filename = basename($_FILES['pj_6_client']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if ((($ext == "jpg" || $ext == "JPG") && $_FILES["pj_6_client"]["type"] == 'image/jpeg') || (($ext == "png" || $ext == "PNG") && $_FILES["pj_6_client"]["type"] == 'image/png')
					|| (($ext == "gif" || $ext == "GIF") && $_FILES["pj_6_client"]["type"] == 'image/gif') || (($ext == "pdf" || $ext == "PDF") && $_FILES["pj_6_client"]["type"] == 'application/pdf')
					|| (($ext == "txt" || $ext == "TXT") && $_FILES["pj_6_client"]["type"] == 'text/plain')
					|| ($ext == "docx" || $ext == "DOCX")
				) {
					$temp = explode(".", $_FILES["pj_6_client"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_6_client"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		// Récupération des URL des pièces jointes
		if ((!empty($_FILES["pj_1_client"])) && ($_FILES['pj_1_client']['error'] == 0)) {
			$_POST['pj1_client_url'] = uploadPJ_1_client();
		}
		if ((!empty($_FILES["pj_2_client"])) && ($_FILES['pj_2_client']['error'] == 0)) {
			$_POST['pj2_client_url'] = uploadPJ_2_client();
		}
		if ((!empty($_FILES["pj_3_client"])) && ($_FILES['pj_3_client']['error'] == 0)) {
			$_POST['pj3_client_url'] = uploadPJ_3_client();
		}
		if ((!empty($_FILES["pj_4_client"])) && ($_FILES['pj_4_client']['error'] == 0)) {
			$_POST['pj4_client_url'] = uploadPJ_4_client();
		}
		if ((!empty($_FILES["pj_5_client"])) && ($_FILES['pj_5_client']['error'] == 0)) {
			$_POST['pj5_client_url'] = uploadPJ_5_client();
		}
		if ((!empty($_FILES["pj_6_client"])) && ($_FILES['pj_6_client']['error'] == 0)) {
			$_POST['pj6_client_url'] = uploadPJ_6_client();
		}

		// var_dump($_FILES);
		// var_dump($_POST);
		// die();
		
		$wms->saveUpdateCustomerInformation($link, $_POST, null);
	}
} else {
	$url = WEB_URL . 'index.php';
	header("Location: $url");
	die();
}
