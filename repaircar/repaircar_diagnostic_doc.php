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
                                FICHE DE DIAGNOSTIC
                                N° <?php echo $row['vehi_diag_id']; ?> du <?php echo $row['date_creation_fiche_diag']; ?>
                            </h4>
                        </div>
                    </div>

                    <!-- <div class="row" id="content_2"> -->
                    <!-- <div class="col-md-12"> -->

                    <div class="row" style="margin-top:10px;margin-bottom:10px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8" style="border:1px black solid;text-align:center;font-size:13pt;font-weight:bolder">NOM CLIENT</div>
                                <div class="col-md-4" style="border:1px black solid;text-align:center;font-size:13pt;font-weight:bolder">CONTACT (whatsapp)</div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8" style="border:1px black solid;">
                                    <?php echo $row['c_name']; ?>
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    <?php echo $row['tel_wa_client']; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-8" style="border:1px black solid;">
                                    <div class="row">
                                        <div class="col-md-8" style="border:1px black solid;">
                                            <div class="row">
                                                <div class="col-md-6" style="font-weight:bolder; border:1px black solid;">VEHICULE TYPE</div>
                                                <div class="col-md-6" style="border:1px black solid;"><?php echo $row['type_voiture']; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6" style="font-weight:bolder;border:1px black solid;">IMMATRICULATION</div>
                                                <div class="col-md-6" style="border:1px black solid;"><?php echo $row['imma_vehicule']; ?></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="font-weight:bolder">N° CHASSIS</div>
                                    </div>
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    <?php echo $row['num_chasis_vehicule']; ?>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row" style="border:1px black solid;margin-top:10px;margin-bottom:10px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- <div class="row">
                                            <div class="col-md-12" style="height:20px;"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12" style="height:20px;"></div>
                                        </div> -->
                                    <div class="row">
                                        <div class="col-md-12" style="border:1px black solid;height:110px;display: flex;
        align-items: center;
        flex-direction: column;
        justify-content: space-around;">
                                            <div style="text-align:center;font-weight:bolder;font-size:10pt">
                                                DISFONCTIONNEMENTS ET PANNES ENREGISTREES
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-8">
                                    <div class="row" style="border:1px black solid;">
                                        <div class="col-md-12" style="height:20px;"></div>
                                    </div>
                                    <div class="row" style="border:1px black solid;">
                                        <div class="col-md-12" style="height:20px;"></div>
                                    </div>
                                    <div class="row" style="border:1px black solid;">
                                        <div class="col-md-12" style="height:20px;"></div>
                                    </div>
                                    <div class="row" style="border:1px black solid;">
                                        <div class="col-md-12" style="height:20px;"></div>
                                    </div>
                                    <div class="row" style="border:1px black solid;">
                                        <div class="col-md-12" style="height:20px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row" style="border:1px black solid;">
                                <div class="col-md-12" style="border:1px black solid;text-align:center;font-weight:bolder;font-size:10pt">
                                    RAPPORT DE DIAGNOSTIC
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="height:100px;">
                                    <?php echo $row['rapport_diagnostic']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="border:1px black solid;margin-top:10px;margin-bottom:10px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="text-align:center;font-weight:bolder;font-size:10pt;border:1px black solid">
                                    PIECES DE RECHANGE
                                </div>
                            </div>
                            <div class="row">
                                <table border="1" class="table dt-responsive">
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
                                        $estimate_data = unserialize($row['estimate_data']);

                                        // var_dump($estimate_data);

                                        foreach ($estimate_data as $estimate) { ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $estimate['designation']; ?></td>
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

                    <div class="row" style="border:1px black solid;margin-top:10px;margin-bottom:10px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12" style="text-align:center;font-weight:bolder;border:1px black solid;font-size:10pt">
                                    A PRECISER AU CLIENT
                                </div>
                            </div>
                            <!-- <div class="row" style="border:1px black solid;">
                                <div class="col-md-3" >
                                    Durée de la commande
                                </div>
                                <div class="col-md-9">
                                    <?php echo $row['duree_commande']; ?>
                                </div>
                            </div> -->
                            <div class="row" style="border:1px black solid;">
                                <div class="col-md-3">
                                    Durée des travaux
                                </div>
                                <div class="col-md-9">
                                    <?php echo $row['duree_travaux']; ?>
                                </div>
                            </div>
                            <div class="row" style="border:1px black solid;">
                                <div class="col-md-3">
                                    Travaux à prévoir
                                </div>
                                <div class="col-md-9">
                                    <?php echo $row['travaux_prevoir']; ?>
                                </div>
                            </div>
                            <!-- <div class="row">
                                                                                                    <div class="col-md-12">
                                                                                                        <?php echo $row['rapport_diagnostic']; ?>
                                                                                                    </div>
                                                                                                </div> -->
                        </div>
                    </div>

                    <h5 style="font-weight:bold;text-decoration:underline">VISA DE VALIDATION DES DIFFERENTS SERVICES</h5>

                    <div class="row" style="border:1px black solid;margin-top:10px;margin-bottom:10px;">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4" style="border:1px black solid;">
                                    1- SERVICE CLIENT
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    2- COMPTABILITE
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    3- RECEPTIONNISTE
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

                                </div>
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

                                </div>
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="border:1px black solid;">
                                    4- DIAGNOSTIC FRANCAIS
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    5- TECHNICIEN
                                </div>
                                <div class="col-md-4" style="border:1px black solid;">
                                    6- PUB FACEBOOK
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

                                </div>
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

                                </div>
                                <div class="col-md-4" style="height:25px;border:1px black solid;">

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

            #mobile-preview-close img {
                width: 20px;
                height: auto;
            }

            #mobile-preview-close a:nth-child(2) {
                background: #f5f5f5;
                margin-bottom: 50px;
            }

            #mobile-preview-close a:nth-child(2) img {
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
                #mobile-preview-close a {
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
        <script>
            jQuery(document).ready(function() {
                location.reload(true);
                window.onload = timedRefresh(500);
            });
        </script>
    </body>

    </html>

<?php } ?>