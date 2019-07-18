<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();
$row = $wms->getRecepRepairCarByCarId($link, $_GET['car_id']);

// var_dump($row );
// die();

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fiche de reception d'un véhicule</title>
        <link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
        <style>
            /* Echaffaudage #2 */
            /* [class*="col-"] {
                border: 1px dotted rgb(0, 0, 0);
                border-radius: 1px;
            } */
        </style>
        <script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    </head>

    <body cz-shortcut-listen="true">
        <div id="editor" class="edit-mode-wrap" style="margin-top: 20px">
            <style type="text/css">
                * {
                    margin: 0;
                    padding: 0;
                }

                body {
                    background: #fff;
                    font-family: Arial, Helvetica, sans-serif;
                    font-size: 12px;
                    line-height: 20px;
                }

                .invoice-wrap {
                    width: 800px;
                    margin: 0 auto;
                    background: #FFF;
                    color: #000
                }

                .invoice-inner {
                    margin: 0 15px;
                    padding: 20px 0
                }

                #info_gene {
                    border-radius: 20px;
                    width: 400px;
                    height: 175px;
                    border: solid 2px #000;
                    padding: 15px;
                    margin-bottom: 20pt;
                }

                #info_gene p {
                    font-size: 15pt;
                }

                #content_2 p {
                    font-size: 13pt;
                    font-weight: bold;
                    font-style: italic;
                }

                h1,
                h2,
                h3 {
                    font-size: 12px;
                }

                .signature {
                    font-size: 13pt;
                    font-weight: bold;
                    font-style: italic;
                    text-decoration: underline;
                    text-align: center;
                }

                .souligne {
                    text-decoration: underline;
                }

                .gras {
                    font-weight: bold;
                }

                #nb p {
                    font-style: italic;
                    font-weight: bold;
                }

                #header p {
                    text-align: center;
                }
            </style>
            <div class="invoice-wrap">
                <div class="invoice-inner">

                    <div class="row">
                        <div class="col-sm-12">
                            <p>
                                ENTRE : Société LUXURY GARAGE Représentée par monsieur Mohamed Kassem
                                D'une part ET . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
                                Monsieur, Madame. . . . . . . . . . . . . . . . . . . . Tel : . . . . . . . . . . . . . . . . . . . .Propriétaire du véhicule immatriculé. . . . . . . . D'autre part Les parties conviennent de ce qui suit conformément à l'article 1134 du code civil.
                            </p>
                            <p>
                                <span class="souligne">Article 1</span>:
                                objet : Le présent contrat a pour objet la réparation des véhicules confiés à LUXURY GARAGE par le client avec l'acceptation des clauses figurantes dans le présent contrat.
                            </p>
                            <p>
                                <span class="souligne">DEPOT ET REPARATION DE VEHICULE</span><br>
                                <span class="souligne">Article 2 : DEPOT DE VEHICULE</span>

                                <ul>
                                    <li style="margin-left:40px;">
                                        <span class="gras">Obligation du propriétaire du véhicule ci-dessus visé:</span>
                                    </li>
                                    <p>
                                        Le propriétaire du véhicule doit déclarer toutes les pannes à sa connaissance.
                                        Ces pannes sont consignées dans un registre par la société LUXURY GARAGE.
                                        Au dépôt du véhicule un contrôle au scanner est effectué en vue de détecter les éventuelles pannes non décelées par le propriétaire.
                                        En effet, le caractère obligatoire du scanner est imposé pour détecter toutes pannes invisibles à I ‘œil nu le prix du scanner est de 100.000 Francs CFA payable dès réception du véhicule et non remboursable.<br>
                                        - Après toutes ces diligences la société LUXURY GARAGE délivre un devis au propriétaire
                                        du véhicule.
                                    </p>
                                    <li style="margin-left:40px;">
                                        <span class="gras">Obligation de la société:</span>
                                    </li>
                                    <p>
                                        Au dépôt du véhicule, le représentant de la société LUXURY GARAGE procède à la vérification des accessoires du véhicule et note les objets manquants, les pièces défectueuses, ou même inexistantes, les objets de valeur etc. et consigne cela dans un registre. Avant toute réparation la société présente un devis aux clients suivis d'une facture. Cette facture comprend :
                                        <br>La date approximative de retrait du véhicule une fois remise en état ;<br>
                                        Le montant de la main d'œuvre.
                                    </p>
                                </ul>
                            </p>
                            <h1 class="souligne">Article 3: REPARATION</h1>
                            <h2 class="souligne gras">La réparation proprement dite du véhicule</h2>
                            <p>
                                La réparation consiste en la remise en état de la partie défaillante du véhicule définit dans le motif de dépôt par le
                                Propriétaire du véhicule lors de l'enregistrement. Le temps à mettre pour la réparation est apprécié par la société,
                                le propriétaire en est informé.

                            </p>
                            <h3 class="souligne">Le cout de la réparation</h3>
                            <p>
                                Le prix de la réparation est défini par le premier responsable du centre, s'agissant du prix des pièces, il est établi en
                                fonction du prix sur le marché.
                                Il tient à préciser au client que pour éviter tout mal entendu : LES PIECES ELECTRONIQUES NE PRESENTENT AUCUNE GARANTIE.
                            </p>
                            <h1 class="souligne">Article 4: AUTORISATION D’ESSAI</h1>
                            <p>
                                Les techniciens de Luxury Garage ont l’autorisation permanente de procéder à des essais du véhicule en réparation pendant la durée et après les travaux de réparation.
                                Ils pourront effectuer ces essais sur des sites et des pistes appropriés pour un test satisfaisant.
                                Cependant la prise en charge des travaux de réparation de tout cas d’accident qui surviendrait lors des essais sera sous la responsabilité de l’assurance du client et non de Luxury Garage.
                            </p>
                            <h1 class="souligne">Article 5: LE COUT DES PRESTATIONS</h1>
                            <p>
                                Le coût des prestations est à distinguer de la valeur des pièces de rechange.
                                Le propriétaire peut être amené à acheter des pièces de rechange pour la remise en état du véhicule. Le prix des
                                pièces est établi en fonction de celui du marché.
                                La société LUXURY GARAGE ne donne pas de garanti pour les pièces de rechange.
                                Le coût des prestations est fixé par la société en fonction du temps à mettre pour le travail et la complexité de
                                celui-ci.
                            </p>
                            <h1 class="souligne">Article 6: LE RETRAIT DU VEHICULE</h1>
                            <p>
                                Le retrait du véhicule est subordonné au règlement intégral par le client de la facture qui lui avait adressé par la
                                société. Le client après vérification des réparations fait et le règlement de la facture peut prendre possession de sa voiture.
                                Le client peut donner mandat écrit à un tiers pour le retrait du véhicule, après avoir donné un coup de fil
                                téléphonique au représentant de la société.
                            </p>
                            <h1 class="souligne">Article 7: LE PAIEMENT</h1>
                            <p>
                                Le client est le seul tenu du paiement des prestations, même au cas où elles seraient couvertes par l'assurance. Toutes les réparations seront payées au comptant avant le retrait de tout véhicule.
                                En cas de retard de paiement, une pénalité de 10% sera appliquée sur la facture initiale chaque semaine à compter de la date prévue pour le paiement.
                            </p>
                            <h1 class="souligne">Article 8: LES RECLAMATIONS</h1>
                            <p>
                                Toute réclamation relative à la réparation effectuée sur un véhicule doit ce faire auprès du responsable de LUXURY GARAGE. Il appartient au client de vérifier la conformité des prestations réalisées par LUXURY GARAGE avant la reprise de son véhicule du garage. Passé un délai de quarante huit heures (48h) à compter de la date indiquée pour le retrait, tout véhicule non retiré pour cause de non paiement de la facture fera l'objet d'une taxe journalière de 10% de la facture.
                            </p>
                            <h1 class="souligne">Article 9: LES RECLAMATIONS</h1>
                            <p>
                                En cas de litige, les parties conviennent de procéder à un règlement amiable.<br>
                                En cas d'échec, le Tribunal de Première Instance d'Abidjan-Plateau est compétent
                            </p>
                        </div>
                    </div>

                    <div class="row" id="signature">
                        <div class="col-sm-4" style="height:150px;">
                            <p class="signature">Signature du client</p>
                            <p style="font-family:'Roboto Mono',monospace,serif;font-weight:bold;font-style:italic;text-align:center">Lu et approuvé</p>
                            <button id="signature_client_verso"><a href="<?php echo WEB_URL ?>signature/my_sign_verso.php?etat=verso&sign=client&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>">Signer</a></button>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div style="border:solid #000 1px; height:45px; width:100px;" id="sign_client_verso">
                                        <?php
                                        // Si le fichier image de la signature au verso vient du client et n'existe pas encore en base de données

                                        if (isset($_GET['image']) && $_GET['sign'] == 'client') {

                                            // On extrait le nom de l'image du chemin vers l'image
                                            $name_image_sign_client_verso = str_replace('../img/signature/', '', $_GET['image']);

                                            // Enregistrement du nom du fichier image de la signature au dépot du client en base de données
                                            $query = "UPDATE tbl_recep_vehi_repar SET sign_cli_verso='" . $name_image_sign_client_verso . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                                            // Exécution de la requête
                                            $result = mysql_query($query, $link);

                                            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
                                            if (!$result) {
                                                $message  = 'Invalid query: ' . mysql_error() . "\n";
                                                $message .= 'Whole query: ' . $query;
                                                die($message);
                                            }
                                            ?>

                                            <!-- On place l'image de la signature du client à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                de la signature du client -->
                                            <!-- <img src="<?php echo WEB_URL ?>signature/doc_signs/<?php echo ltrim($name_image_sign_client_verso) ?>" alt="" height="40" width="80"> -->
                                            <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_client_verso) ?>" alt="" height="40" width="80">
                                        <?php } else {

                                            // Sinon on récupère la signature enregistrer en base de données
                                            $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepCarId($link, $_GET['car_id']);

                                            if ($rowsRecepVehiSignatureByRecepId['sign_cli_verso'] != null) {
                                                ?>
                                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_cli_verso']) ?>" alt="" height="40" width="80">

                                            <?php }
                                        } ?>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <?php echo $row['date_sign_cli_verso']; ?>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-4 col-md-offset-4" style="height:150px;">
                            <p class="signature">Signature du technicien</p>
                            <div style="margin-top:40px;">
                                <button id="signature_receptionniste_depot"><a href="<?php echo WEB_URL ?>signature/my_sign_verso.php?etat=verso&sign=tech&car_id=<?php echo $row['car_id'] ?>&contact=<?php echo $row['princ_tel'] ?>&immavehi=<?php echo $row['num_matricule'] ?>&add_car_id=<?php echo $row['add_car_id'] ?>">Signer</a></button>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div style="border:solid #000 1px; height:45px; width:100px;" id="sign_tech_verso">
                                            <?php
                                            // Si le fichier image de la signature au verso vient du technicien et n'existe pas encore en base de données

                                            if (isset($_GET['image']) && $_GET['sign'] == 'tech') {

                                                // On extrait le nom de l'image du chemin vers l'image

                                                $name_image_sign_tech_verso = str_replace('../img/signature/', '', $_GET['image']);

                                                // Enregistrement du nom du fichier image de la signature au dépot du technicien en base de données
                                                $query = "UPDATE tbl_recep_vehi_repar SET sign_tech_verso='" . $name_image_sign_tech_verso . "' WHERE car_id='" . (int) $row['car_id'] . "'";

                                                // Exécution de la requête
                                                $result = mysql_query($query, $link);

                                                // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
                                                if (!$result) {
                                                    $message  = 'Invalid query: ' . mysql_error() . "\n";
                                                    $message .= 'Whole query: ' . $query;
                                                    die($message);
                                                }
                                                ?>

                                                <!-- On place l'image de la signature du technicien à l'emplacement prévu à cet effet en prenant soin d'éliminer les espaces au debut du nom du fichier image
                                                                                                                                        de la signature du client -->
                                                <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($name_image_sign_tech_verso) ?>" alt="" height="40" width="80">
                                            <?php } else {

                                                // Sinon on récupère la signature enregistrer en base de données
                                                $rowsRecepVehiSignatureByRecepId = $wms->getRecepVehiSignatureByRecepCarId($link, $_GET['car_id']);

                                                if ($rowsRecepVehiSignatureByRecepId['sign_tech_verso'] != null) {
                                                    ?>
                                                    <img src="<?php echo WEB_URL ?>img/signature/<?php echo ltrim($rowsRecepVehiSignatureByRecepId['sign_tech_verso']) ?>" alt="" height="40" width="80">

                                                <?php }
                                            } ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <?php echo $row['date_sign_tech_verso']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <style>
            body {
                background: #EBEBEB;
            }

            .invoice-wrap {
                box-shadow: 0 0 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            #mobile-preview-close_2 a {
                position: fixed;
                /* left: 20px; */
                bottom: 30px;
                right: 0px;
                background-color: #f5f5f5;
                font-weight: 600;
                outline: 0 !important;
                line-height: 1.5;
                border-radius: 3px;
                font-size: 14px;
                padding: 7px 10px;
                margin: 7px 10px;
                border: 1px solid #000;
                color: #000;
                text-decoration: none;
            }

            #mobile-preview-close a {
                position: fixed;
                left: 20px;
                bottom: 30px;
                background-color: #f5f5f5;
                font-weight: 600;
                outline: 0 !important;
                line-height: 1.5;
                border-radius: 3px;
                font-size: 14px;
                padding: 7px 10px;
                border: 1px solid #000;
                color: #000;
                text-decoration: none;
            }

            #mobile-preview-close img,
            #mobile-preview-close_2 img {
                width: 20px;
                height: auto;
            }

            #mobile-preview-close a:nth-child(2),
            #mobile-preview-close_2 a:nth-child(2) {
                background: #f5f5f5;
                margin-bottom: 50px;
            }

            #mobile-preview-close a:nth-child(2) img,
            #mobile-preview-close_2 a:nth-child(2) img {
                height: auto;
                position: relative;
                top: 2px;
            }

            .invoice-wrap {
                padding: 20px;
            }

            @media screen and projection {
                a {
                    display: inline;
                }
            }

            @media print {
                a {
                    display: none;
                }
            }

            @page {
                margin: 0 -6cm
            }

            /* html {
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        margin: 0 6cm
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    } */

            @media print {

                #mobile-preview-close a,
                #mobile-preview-close_2 a {
                    display: none
                }

                .invoice-wrap {
                    0
                }

                body {
                    background: none;
                }

                .invoice-wrap {
                    box-shadow: none;
                    margin-bottom: 0px;
                }

            }
        </style>
        <div id="mobile-preview-close">
            <a style="" href="javascript:window.print();"><img src="<?php echo WEB_URL; ?>img/print.png" style="float:left; margin:0 10px 0 0;"> Imprimer </a>
            <a style="" href="<?php echo WEB_URL; ?>dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a>
        </div>
        <div id="mobile-preview-close_2">
            <a style="" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $_GET['car_id']; ?>"> Afficher le recto</a>
        </div>

    </body>

    </html>

<?php } ?>