<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();
$row = $wms->getRepairCarDiagnosticInfoByDiagId($link, $_GET['vehi_diag_id']);

$i = 1;

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fiche des pièces de rechange d'un véhicule</title>
        <link href="<?php echo WEB_URL; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono" rel="stylesheet">
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
                    margin: 0 250px;
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
                        <div class="col-sm-2" style="height:100px;">
                            <!-- <img class="editable-area" id="logo" src="../img/logo.png"> -->
                            <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg" height="100" width="100">
                        </div>
                        <div class="col-sm-10" style="font-size:15pt;">
                            <p>Mécanique générale - Climatisation - Clé d'origine - Scanner - Programmation - Electricité</p>
                            <p>Tel. 21 35 55 60 / 06 66 06 66</p>
                        </div>
                    </div>
                    <div class="row" id="content_1">
                        <div class="col-sm-12" style="text-align:center;">
                            <h4 style="text-decoration:underline;font-weight:bold">
                                FICHE DES PIECES DE RECHANGE
                                <!-- A ENVOYER AUX FOURNISSEURS -->
                            </h4>
                        </div>
                    </div>

                    <!-- <div class="row" id="content_2"> -->
                    <!-- <div class="col-sm-12"> -->

                    <div id="content_2">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Marque du véhicule :</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $row['make_name']; ?></p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Modèle du véhicule :</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $row['model_name']; ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <p>N° chassis du véhicule :</p>
                            </div>
                            <div class="col-sm-8">
                                <p><?php echo $row['num_chasis_vehicule']; ?></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <table class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th scope="col" align="justify">N°</th>
                                                <th scope="col" align="justify">Désignation</th>
                                                <th scope="col" align="justify">Quantité</th>
                                                <!-- <th scope="col" align="justify">Montant</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            // On délinéarise l'array
                                            // $estimate_data = unserialize($row['estimate_data']);
                                            $estimate_data = json_decode($row['estimate_data'], true);

                                            // var_dump($row['estimate_data']);

                                            foreach ($estimate_data as $estimate) { ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo str_replace('u0027', "'", $estimate['designation']); ?></td>
                                                    <td><?php echo $estimate['quantity']; ?></td>
                                                    <!-- <td><?php echo $estimate['total']; ?></td> -->
                                                </tr>
                                                <?php $i++;
                                            } ?>
                                        </tbody>
                                        <!-- <tfoot>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                                <td>TOTAL HT</td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot> -->
                                    </table>
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
            <a style="" href="<?php echo WEB_URL; ?>mech_panel/mech_dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a>
        </div>
        <?php if (isset($_GET['login_type']) && $_GET['login_type'] == 'admin') { ?>
            <div id="mobile-preview-close_2">
                <!-- <a style="" href="#"> Envoyer aux fournisseurs par e-mail</a> -->
                <!-- <a style="" href="<?php echo WEB_URL; ?>supplier/sendEmailToSuppliers.php"> Envoyer aux fournisseurs par e-mail</a>
                <a style="" href="<?php echo WEB_URL; ?>bon_cmde/addBonCmde.php"> Créer un bon de commande</a> -->
                <!-- <a style="" href="<?php echo WEB_URL; ?>convertToPdf.php"> Convertir en PDF </a> -->
            </div>
        <?php } ?>

    </body>

    </html>

<?php } ?>