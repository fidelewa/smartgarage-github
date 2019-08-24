<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div class="row" id="signature">
        <div class="col-sm-3" style="height:150px;">
            <p class="signature">Nom et signature du client</p>
            <p style="font-family:'Roboto Mono',monospace,serif;font-weight:bold;font-style:italic;text-align:center">Contrat au verso lu et approuvé</p>
            <?php if (isset($_GET['login_type']) && $_GET['login_type'] != "mechanics") { ?>

                <button id="signature_client_depot"><a href="<?php echo WEB_URL ?>signature/my_sign.php?etat=depot&sign=client&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>&login_type=<?php echo $_GET['login_type'] ?>">Signer au dépot</a></button>
                <button id="signature_client_sortie"><a href="<?php echo WEB_URL ?>signature/my_sign.php?etat=sortie&sign=client&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>&login_type=<?php echo $_GET['login_type'] ?>">Signer à la sortie</a></button>

            <?php } ?>

        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm-2" style="font-weight:bold;font-style:italic">
                    (Dépôt)
                </div>

                <div class="col-sm-5">
                    <div style="border:solid #000 1px; height:45px; width:100px;" id="sign_client_depot">
                        <?php
                        // Si le fichier image de la signature au depot vient du client et n'existe pas encore en base de données

                        if (isset($_GET['image']) && $_GET['sign'] == 'client' && $_GET['etat'] == 'depot') {

                            // On extrait le nom de l'image du chemin vers l'image
                            // $name_image_sign_client_depot = str_replace('./doc_signs/', '', $_GET['image']);
                            $name_image_sign_client_depot = str_replace('../img/signature/', '', $_GET['image']);

                            // Enregistrement du nom du fichier image de la signature au dépot du client en base de données
                            $query = "UPDATE tbl_recep_vehi_repar SET sign_cli_depot='" . $name_image_sign_client_depot . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                            // Exécution de la requête
                            $result = mysql_query($query, $link);

                            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
                            // if (!$result) {
                            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                            //     $message .= 'Whole query: ' . $query;
                            //     die($message);
                            // }
                            ?>

                            <!-- On place l'image de la signature du client à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                de la signature du client -->
                            <!-- <img src="<?php echo WEB_URL ?>signature/doc_signs/<?php echo ltrim($name_image_sign_client_depot) ?>" alt="" height="40" width="80"> -->
                            <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_client_depot) ?>" alt="" height="40" width="80">
                        <?php } else {

                            // Sinon on récupère la signature enregistrer en base de données
                            $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepId($link, $_GET['car_id']);
                            if ($rowsRecepVehiSignatureByRecepId['sign_cli_depot'] != null) {

                                ?>
                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_cli_depot']) ?>" alt="" height="40" width="80">

                            <?php }
                        } ?>

                    </div>
                    <div class="col-md-12">
                        <?php echo $row['date_sign_cli_depot']; ?>
                    </div>
                </div>
                <div class="col-md-offset-1 col-sm-4" style="padding-right:0px;">
                    <div style="border:solid #000 1px; height:45px; width:100px" id="sign_recep_depot">
                        <?php
                        // Si la signature au dépot vient du réceptionniste et n'existe pas encore en base de données


                        if (isset($_GET['image']) && $_GET['sign'] == 'recep' && $_GET['etat'] == 'depot') {

                            // On extrait le nom de l'image du chemin vers l'image
                            // $name_image_sign_recep_depot = str_replace('./doc_signs/', '', $_GET['image']);
                            $name_image_sign_recep_depot = str_replace('../img/signature/', '', $_GET['image']);

                            // Enregistrement du nom du fichier image de la signature du client en base de données
                            $query = "UPDATE tbl_recep_vehi_repar SET sign_recep_depot='" . $name_image_sign_recep_depot . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                            // On teste le résultat de la requête
                            $result = mysql_query($query, $link);

                            // if (!$result) {
                            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                            //     $message .= 'Whole query: ' . $query;
                            //     die($message);
                            // }

                            ?>

                            <!-- On place l'image de la signature du réceptionniste à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                de la signature du réceptionniste -->
                            <!-- <img src="<?php echo WEB_URL ?>signature/doc_signs/<?php echo ltrim($name_image_sign_recep_depot) ?>" alt="" height="40" width="80"> -->
                            <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_recep_depot) ?>" alt="" height="40" width="80">
                        <?php } else {

                            // Sinon on récupère la signature enregistrer en base de données
                            $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepId($link, $_GET['car_id']);

                            if ($rowsRecepVehiSignatureByRecepId['sign_recep_depot'] != null) {
                                ?>
                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_recep_depot']) ?>" alt="" height="40" width="80">

                            <?php }
                        }
                        ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo $row['date_sign_recep_depot']; ?>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                                <div class="col-md-offset-2 col-md-6">
                                    <?php echo $row['date_sign_cli_depot']; ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $row['date_sign_recep_depot']; ?>
                                </div>
                            </div> -->
            <div class="row">
                <div class="col-sm-2" style="font-weight:bold;font-style:italic">
                    (Sortie)
                </div>
                <div class="col-sm-5">
                    <div style="border:solid #000 1px; height:45px; width:100px;" id="sign_client_sortie">
                        <?php
                        // Si le fichier image de la signature à la sortie vient du client et n'existe pas encore en base de données

                        if (isset($_GET['image']) && $_GET['sign'] == 'client' && $_GET['etat'] == 'sortie') {

                            // On extrait le nom de l'image du chemin vers l'image
                            // $name_image_sign_client_sortie = str_replace('./doc_signs/', '', $_GET['image']);
                            $name_image_sign_client_sortie = str_replace('../img/signature/', '', $_GET['image']);

                            // Enregistrement du nom du fichier image de la signature au dépot du client en base de données
                            $query = "UPDATE tbl_recep_vehi_repar SET sign_cli_sortie='" . $name_image_sign_client_sortie . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                            // Exécution de la requête
                            $result = mysql_query($query, $link);

                            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
                            // if (!$result) {
                            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                            //     $message .= 'Whole query: ' . $query;
                            //     die($message);
                            // }
                            ?>

                            <!-- On place l'image de la signature du client à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                de la signature du client -->
                            <!-- <img src="<?php echo WEB_URL ?>signature/doc_signs/<?php echo ltrim($name_image_sign_client_sortie) ?>" alt="" height="40" width="80"> -->
                            <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_client_sortie) ?>" alt="" height="40" width="80">
                        <?php } else {

                            // Sinon on récupère la signature enregistrer en base de données
                            $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepId($link, $_GET['car_id']);

                            if ($rowsRecepVehiSignatureByRecepId['sign_cli_sortie'] != null) {
                                ?>
                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_cli_sortie']) ?>" alt="" height="40" width="80">

                            <?php }
                        } ?>

                    </div>
                    <div class="col-md-12">
                        <?php echo $row['date_sign_cli_sortie']; ?>
                    </div>
                </div>
                <div class="col-md-offset-1 col-sm-4" style="padding-right:0px;">
                    <div style="border:solid #000 1px; height:45px; width:100px" id="sign_recep_sortie">
                        <?php

                        if (isset($_GET['image']) && $_GET['sign'] == 'recep' && $_GET['etat'] == 'sortie') {

                            // On extrait le nom de l'image du chemin vers l'image
                            // $name_image_sign_recep_sortie = str_replace('./doc_signs/', '', $_GET['image']);
                            $name_image_sign_recep_sortie = str_replace('../img/signature/', '', $_GET['image']);

                            // Enregistrement du nom du fichier image de la signature du client en base de données
                            $query = "UPDATE tbl_recep_vehi_repar SET sign_recep_sortie='" . $name_image_sign_recep_sortie . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                            // On teste le résultat de la requête
                            $result = mysql_query($query, $link);

                            // if (!$result) {
                            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
                            //     $message .= 'Whole query: ' . $query;
                            //     die($message);
                            // }

                            ?>

                            <!-- On place l'image de la signature du réceptionniste à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            de la signature du réceptionniste -->
                            <!-- <img src="<?php echo WEB_URL ?>signature/doc_signs/<?php echo ltrim($name_image_sign_recep_sortie) ?>" alt="" height="40" width="80"> -->
                            <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_recep_sortie) ?>" alt="" height="40" width="80">
                        <?php } else {

                            // Sinon on récupère la signature enregistrer en base de données
                            $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepId($link, $_GET['car_id']);

                            if ($rowsRecepVehiSignatureByRecepId['sign_recep_sortie'] != null) {
                                ?>
                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_recep_sortie']) ?>" alt="" height="40" width="80">

                            <?php }
                        } ?>
                    </div>
                    <div class="col-md-12">
                        <?php echo $row['date_sign_recep_sortie']; ?>
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                                <div class="col-md-offset-2 col-md-6">
                                    <?php echo $row['date_sign_cli_sortie']; ?>
                                </div>
                                <div class="col-md-4">
                                    <?php echo $row['date_sign_recep_sortie']; ?>
                                </div>
                            </div> -->
        </div>
        <div class="col-sm-3" style="height:150px;">
            <p class="signature">Nom et signature du réceptionniste</p>
            <?php if (isset($_GET['login_type']) && $_GET['login_type'] != "mechanics") { ?>

                <div style="margin-top:40px;">
                    <button id="signature_receptionniste_depot"><a href="<?php echo WEB_URL ?>signature/my_sign.php?etat=depot&sign=recep&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>&login_type=<?php echo $_GET['login_type'] ?>">Signer au dépot</a></button>
                    <button id="signature_receptionniste_sortie"><a href="<?php echo WEB_URL ?>signature/my_sign.php?etat=sortie&sign=recep&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>&login_type=<?php echo $_GET['login_type'] ?>">Signer à la sortie</a></button>
                </div>

            <?php } ?>

        </div>
    </div>
</body>

</html>