<?php
	include("../config.php");
	if( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' ) ){
		include("../dbconfig.php");
		include("../helper/common.php");
        $wms = new wms_core();
        
        $html = ''; 
        // if (isset($_POST) && !empty($_POST)) {
            $wms->get_all_make_list($link);
        // }

		header('Content-Type: text/html');
		echo $html;
		die();
	} else {
		$url = WEB_URL.'index.php';
		header("Location: $url");
		die();
	}
?>
