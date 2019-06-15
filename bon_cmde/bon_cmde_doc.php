<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();

$row = $wms->getBoncmdeInfo($link, $_GET['boncmde_id']);

// var_dump($row);
// die();

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Bon de commande</title>
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
                                BON DE COMMANDE N° <?php echo $row['boncmde_id']; ?>
                            </h4>
                        </div>
                    </div>
                    <div class="row" id="content_1">
                        <div class="col-sm-6" style="text-align:center;">
                            <p style="font-size:10pt;">
                                Date : <?php echo $row['boncmde_date_creation']; ?>
                            </p>
                        </div>
                        <div class="col-sm-6" style="text-align:center;">
                            <p style="font-size:10pt;">
                                Fournisseur : <?php echo $row['s_name']; ?>
                            </p>
                        </div>
                    </div>

                    <!-- <div class="row" id="content_2"> -->
                    <!-- <div class="col-md-12"> -->

                    <div id="content_2">

                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <table border="1" class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th style="text-align:center">N° bon de commande</th>
                                                <th style="text-align:center">Code/désignation</th>
                                                <th style="text-align:center">Quantité</th>
                                                <!-- <th style="text-align:center">Prix unitaire HT</th>
                                                <th style="text-align:center">Total HT</th> -->
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <!-- <td><?php echo $row['boncmde_id']; ?></td> -->
                                                <td><?php echo $row['boncmde_num']; ?></td>
                                                <td><?php echo $row['boncmde_designation']; ?></td>
                                                <td><?php echo $row['boncmde_qte']; ?></td>
                                                <!-- <td><?php echo $row['boncmde_pu_ht']; ?></td>
                                                <td><?php echo $row['boncmde_total_ht']; ?></td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!-- <div class="form-group row">
                                                        <label class="control-label col-sm-2" for="email">Code/désignation:</label>
                                                        <div class="col-sm-10" id="email_supplier">
                                                            <input type="text" class="form-control" id="email" name="email" value="<?php echo $row['boncmde_designation']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-2" for="lname">Quantité:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="attachFile" name="attachFile" value="<?php echo $row['boncmde_qte']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-2" for="lname">Prix unitaire HT :</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="attachFile" name="attachFile" value="<?php echo $row['boncmde_pu_ht']; ?>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="control-label col-sm-2" for="lname">Total HT:</label>
                                                        <div class="col-sm-10">
                                                            <input type="text" class="form-control" id="attachFile" name="attachFile" value="<?php echo $row['boncmde_total_ht']; ?>">
                                                        </div>
                                                    </div> -->
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
            <!-- <a style="" href="<?php echo WEB_URL; ?>estimate/devis_prix_piece_rechange.php?vehi_diag_id=<?php echo $_GET['vehi_diag_id']; ?>"> Créer un devis </a> -->
            <a style="" href="<?php echo WEB_URL; ?>bon_cmde/sendBonCmde.php?boncmde_id=<?php echo $_GET['boncmde_id']; ?>&supplier_id=<?php echo $row['supplier_id']; ?>"> Envoyer le bon de commande </a>
        </div>
    </body>

    </html>

<?php } ?>