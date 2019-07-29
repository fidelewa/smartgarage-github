<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();

// $row = $wms->getBoncmdeInfo($link, $_GET['boncmde_id']);
$row = $wms->getCarScanningById($link, $_GET['vehicule_scanning_id']);

// var_dump($row);
// die();

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reçu de paiement du scanner</title>
        <link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
        <script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <style>
            /* Echaffaudage #2 */
            /* [class*="col-"] {
                                    border: 1px dotted rgb(0, 0, 0);
                                    border-radius: 1px;
                                } */
        </style>
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
                }

                #content_3 label {
                    font-size: 11pt;
                }

                th {
                    font-size: 11pt;
                }

                .cadre {
                    border-radius: 20px;
                    /* width: 400px;
                                                                                                                                                    height: 175px; */
                    border: solid 2px #000;
                    padding: 5px;
                    margin-bottom: 5pt;
                }


                h3 {
                    text-align: center
                }

                .signature {
                    font-size: 13pt;
                    font-weight: bold;
                    font-style: italic;
                    text-decoration: underline;
                    text-align: center;
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
                    <div class="row" id="header">
                        <div class="col-sm-4" style="height:100px;">
                            <!-- <img class="editable-area" id="logo" src="../img/logo.png"> -->
                            <div class="row">
                                <div class="col-sm-12" align="center">
                                    <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg" height="100" width="100">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12" style="font-size:7pt">
                                    <p style="line-height: normal"><?php
                                                                    $slogan = "Mécanique générale - Climatisation - Clé d'origine - Scanner - Programmation - Electricité";
                                                                    echo mb_strtoupper(nl2br($slogan . "\n")); ?>
                                        Abidjan, Marcory Zone 4 Rue Flash intervention près du collège Descartes<br />
                                        18 BP 2917 Abidjan 18<br />
                                        Cel: +225 06 66 06 66 / Tel: +225 21 35 55 60<br />
                                        info@luxurygarage.net / www.luxurygarage.net</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-7 col-sm-offset-1" style="font-size:14pt">

                            <div class="row" id="content_1" style="margin-bottom:25px;">
                                <div class="col-sm-12" style="text-align:center;">
                                    <h4 style="text-decoration:underline;font-weight:bold">
                                        RECU DE PAIEMENT N° <?php echo $row['id']; ?>
                                    </h4>
                                </div>
                            </div>
                            <div class="row" id="content_3" style="margin-bottom:50px;">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="date_bcmd" class="col-md-5 col-form-label">Immatriculation:</label>
                                            <div class="col-md-7">
                                                <input readonly type="text" id="imma" name="imma" value="<?php echo $row['imma_vehi_client'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="date_livraison_bcmd" class="col-md-5 col-form-label">Marque :</label>
                                            <div class="col-md-7">
                                                <input readonly type="text" id="marque_vehi" name="marque_vehi" value="<?php echo $row['marque_vehi_client'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="date_livraison_bcmd" class="col-md-5 col-form-label">Modèle :</label>
                                            <div class="col-md-7">
                                                <input readonly type="text" id="modele_vehi" name="modele_vehi" value="<?php echo $row['model_vehi_client'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="date_livraison_bcmd" class="col-md-5 col-form-label">Nom client :</label>
                                            <div class="col-md-7">
                                                <input readonly type="text" id="client_vehi" name="client_vehi" value="<?php echo $row['c_name'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="date_livraison_bcmd" class="col-md-5 col-form-label">Téléphone client :</label>
                                            <div class="col-md-7">
                                                <input readonly type="text" id="tel_vehi" name="tel_vehi" value="<?php echo $row['princ_tel'] ?>" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="content_2">
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="table-responsive">
                                    <table id="labour_table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">Type de scanner</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if ($row['scanner_mecanique'] == "OUI") { ?>
                                                <tr>
                                                    <td><?php echo "Scanner mécanique" ?></td>
                                                    <!-- <td><?php echo $boncmde_data_row['qte']; ?></td> -->
                                                </tr>
                                            <?php }
                                            if ($row['scanner_electrique'] == "OUI") { ?>
                                                <tr>
                                                    <td><?php echo "Scanner électrique" ?></td>
                                                    <!-- <td><?php echo $boncmde_data_row['qte']; ?></td> -->
                                                </tr>
                                            <?php }  ?>
                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>

                                    <div class="col-xs-3 col-xs-offset-6 cadre" style="width:300px;">
                                        <div class="row">
                                            <div class="col-xs-6">Montant total payé</div>
                                            <div class="col-xs-6" id="total_ht"><?php echo $row['frais_scanner'] ?></div>
                                        </div>
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
            <!-- <a style="" href="<?php echo WEB_URL; ?>dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a> -->
        </div>
        <div id="mobile-preview-close_2">
            <!-- <a style="" href="<?php echo WEB_URL; ?>estimate/devis_prix_piece_rechange.php?vehi_diag_id=<?php echo $_GET['vehi_diag_id']; ?>"> Créer un devis </a> -->
            <!-- <a style="" href="<?php echo WEB_URL; ?>bon_cmde/sendBonCmde.php?boncmde_id=<?php echo $_GET['boncmde_id']; ?>&supplier_id=<?php echo $row['supplier_id']; ?>"> Envoyer le bon de commande </a> -->
        </div>

        <script type="text/javascript">
            var total_ht = "<?php echo $row['frais_scanner']; ?>";

            // Définition de la locale en français
            numeral.register('locale', 'fr', {
                delimiters: {
                    thousands: ' ',
                    decimal: ','
                },
                abbreviations: {
                    thousand: 'k',
                    million: 'm',
                    billion: 'b',
                    trillion: 't'
                },
                currency: {
                    symbol: 'FCFA'
                }
            });

            // Sélection de la locale en français
            numeral.locale('fr');

            // Conversion des variables en flottant
            total_ht = parseFloat(total_ht);

            $("#total_ht").html(numeral(total_ht).format('0,0 $'));

        </script>
    </body>

    </html>

<?php } ?>