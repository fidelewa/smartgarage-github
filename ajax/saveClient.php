<?php
include("../config.php");
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
	include("../dbconfig.php");
	include("../helper/common.php");
	$wms = new wms_core();

	$html = '';
	if (isset($_POST) && !empty($_POST)) {
		$_POST['txtCPassword'] = $_POST['princ_tel'];
		$_POST['tel_wa'] = $_POST['princ_tel'];

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

		function uploadPJ_1()
		{
			if ((!empty($_FILES["pj_1"])) && ($_FILES['pj_1']['error'] == 0)) {
				$filename = basename($_FILES['pj_1']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				if (($ext == "jpg" && $_FILES["pj_1"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_1"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_1"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_1"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_1"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_1"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
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
				if (($ext == "jpg" && $_FILES["pj_2"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_2"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_2"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_2"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_2"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_2"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
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
				if (($ext == "jpg" && $_FILES["pj_3"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_3"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_3"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_3"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_3"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_3"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
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
				if (($ext == "jpg" && $_FILES["pj_4"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_4"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_4"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_4"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_4"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_4"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
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
				if (($ext == "jpg" && $_FILES["pj_5"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_5"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_5"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_5"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_5"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_5"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
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
				if (($ext == "jpg" && $_FILES["pj_6"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_6"]["type"] == 'image/png')
					|| ($ext == "gif" && $_FILES["pj_6"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_6"]["type"] == 'application/pdf') || ($ext == "docx")
				) {
					$temp = explode(".", $_FILES["pj_6"]["name"]);
					$newfilename = NewGuid() . '.' . end($temp);
					move_uploaded_file($_FILES["pj_6"]["tmp_name"], ROOT_PATH . '/img/upload/docs/' . $newfilename);
					return $newfilename;
				} else {
					return '';
				}
			}
			return '';
		}

		// Récupération des URL des pièces jointes
		// if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
		// 	$_POST['pj1_url'] = uploadPJ_1();
		// }
		// if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
		// 	$_POST['pj2_url'] = uploadPJ_2();
		// }
		// if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
		// 	$_POST['pj3_url'] = uploadPJ_3();
		// }
		// if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
		// 	$_POST['pj4_url'] = uploadPJ_4();
		// }
		// if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
		// 	$_POST['pj5_url'] = uploadPJ_5();
		// }
		// if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
		// 	$_POST['pj6_url'] = uploadPJ_6();
		// }

		// var_dump($_POST);
		// var_dump($_FILES);
		// die();
		$wms->saveUpdateCustomerInformation($link, $_POST, null);
	}

	header('Content-Type: text/html');
	// var_dump($html);
	echo $html;
	die();
} else {
	$url = WEB_URL . 'index.php';
	header("Location: $url");
	die();
}
