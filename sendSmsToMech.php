<?php
// importation du fichier de l'API SMS
        require_once(ROOT_PATH . '/SmsApi.php');

        // instanciation de la classe de l'API SMS
        $smsApi = new SmsApi();

        $mobile_mech = $row['usr_email'];
        // $mobile_mech  = "02280768";

        // Message d'alerte
        $content_msg = $row['usr_name'] . ', vous avez la charge de faire le diagnostic de la voiture ' . $voiture['make_name'] . ' ' . $voiture['model_name'] . ' ' . $voiture['VIN'];
        // $content_msg = "Le véhicule d'identifiant " . $_POST['car_id'] . "vous a été attribué pour effectuer un diagnostic";

        // Exécution de la méthode d'envoi 
        $resultSmsSent = $smsApi->isSmsapi($mobile_mech, $content_msg);

        // On fait une redirection si le sms a été envoyé avec succès
        if ($resultSmsSent == "ok") {
            // Faire une rédirection vers la liste des véhicules réceptionnés avec un paramètre d'attribution
            header("Location: " . WEB_URL . "reception/repaircar_reception_list.php?m=attribution&car_id=" . $_POST['car_id'] . "&mecanicien_id=" . $_POST['mecanicienList'] . "&marque=" . $voiture['make_name'] . "&modele=" . $voiture['model_name'] . "&imma=" . $voiture['VIN'] . "&mech_name=" . $row['usr_name']);
        } else {
            echo "<script type='text/javascript'> document.location.href='". WEB_URL ."reception/repaircar_reception_list.php?m=attribution&car_id=". $_POST['car_id'] ."&mecanicien_id=". $_POST['mecanicienList'] ."&marque=". $voiture['make_name'] ."&modele=". $voiture['model_name'] ."&imma=". $voiture['VIN'] ."&mech_name=". $row['usr_name'] ."&sms=send_mech_sms_failed'</script>";
        }
