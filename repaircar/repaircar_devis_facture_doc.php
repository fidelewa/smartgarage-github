<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();

$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
    $currency = $result_settings['currency'];
    $email = $result_settings['email'];
}

// function ctrTechCalculate($date_ctr_tech, $delai_ctr_tech)
// {

//     // On récupère la date en chaine de caratère que l'on converti en objet DateTime
//     $datectrtech = DateTime::createFromFormat('d/m/Y', $date_ctr_tech);

//     // Si l'objet récupéré est une instance de la classe DateTime
//     if ($datectrtech instanceof DateTime) {

//         // On calcul la date du prochain contrôle technique
//         $dateprochctrtech = $datectrtech->add(new \DateInterval($delai_ctr_tech));
//     }

//     // On retourne le format chaine de caractère de la date du prochain contrôle technique
//     return $dateprochctrtech->format('d/m/Y');
// }

$row = $wms->getRepairCarDevisFactureInfoByDiagId($link, $_GET['vehi_diag_id'], $_GET['devis_id']);

// $dateProchCtrTech = ctrTechCalculate($row['add_date_ctr_tech'], $row['delai_ctr_tech']);

// var_dump($row);
// die();

$i = 1;

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Facture du devis de réparation d'un véhicule</title>
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
                    /* width: 400px;
                                                                                                height: 175px; */
                    border: solid 2px #000;
                    padding: 15px;
                    margin-bottom: 20pt;
                }

                .cadre {
                    border-radius: 20px;
                    /* width: 400px;
                                                                                                height: 175px; */
                    border: solid 2px #000;
                    padding: 15px;
                    margin-bottom: 20pt;
                }

                #info_gene p {
                    font-size: 13pt;
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
                            <!-- <img class="editable-area" id="logo" src="<?php echo WEB_URL; ?>img/luxury_garage_logo.jpg" height="100" width="100"> -->
                            <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg" height="100" width="100">
                        </div>
                        <div class="col-sm-3 col-sm-offset-7">
                            <p><?php echo $row['date_facture']; ?></p>
                        </div>
                    </div>
                    <div class="row" id="content_1">
                        <div class="col-sm-9">
                            <p style="font-size:13pt;font-weight:600;">LUXURY GARAGE</p>
                        </div>
                        <div class="col-sm-3" id="info_gene">
                            <p><?php echo $row['c_name']; ?></p>
                            <p><?php echo $row['c_address']; ?></p>
                            <p>Tel: <?php echo $row['princ_tel']; ?></p>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-sm-5 col-sm-onset-7" style="border-radius: 20px; border: solid 2px #000;">
                            <p>Facture N° : <?php echo $row['facture_id']; ?></p>
                        </div>
                    </div>

                    <!-- <div class="row" id="content_2"> -->
                    <!-- <div class="col-sm-12"> -->

                    <div id="content_2">
                        <div class="cadre">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Numéro de serie</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['chasis_no']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Immatriculation</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['VIN']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Marque</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['make_name']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Modèle</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['model_name']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Première mise en circulation</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['add_date_mise_circu']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p>Prochain controle technique</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php echo $row['add_date_visitetech']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="row">
                                    <table border="1" class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Désignation</th>
                                                <!-- <th>Marque</th> -->
                                                <th>Quantité</th>
                                                <th>Tarif HT</th>
                                                <th>Remise(%)</th>
                                                <th>Total HT</th>
                                                <th>Total TTC</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            // On délinéarise l'array
                                            $facture_data = unserialize($row['facture_data']);

                                            // var_dump($facture_data);
                                            // die();

                                            foreach ($facture_data as $facture) { ?>
                                                <tr>
                                                    <td><?php echo $facture['code_piece_rechange_facture']; ?></td>
                                                    <td><?php echo $facture['designation_piece_rechange_facture']; ?></td>
                                                    <!-- <td><?php echo $facture['marque_piece_rechange_facture']; ?></td> -->
                                                    <td><?php echo $facture['qte_piece_rechange_facture']; ?></td>
                                                    <td><?php echo $facture['prix_piece_rechange_min_facture']; ?></td>
                                                    <td><?php echo $facture['remise_piece_rechange_facture']; ?></td>
                                                    <td><?php echo $facture['total_prix_piece_rechange_facture_ht']; ?></td>
                                                    <td><?php echo $facture['total_prix_piece_rechange_facture_ttc']; ?></td>
                                                </tr>
                                                <?php $i++;
                                            } ?>
                                            <tr>
                                                <td colspan="7" class="text-right">Montant main d'oeuvre (<?php echo $currency; ?>):</td>
                                                <td><?php echo $row['montant_main_oeuvre_facture']; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <!-- <tr>
                                                        <td colspan="7" class="text-right">Total HT:</td>
                                                        <td><?php echo $row['total_ht_gene_piece_rechange_facture']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TVA (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['total_tva_facture']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Total TTC (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['total_ttc_gene_piece_rechange_facture']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Montant dû (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['montant_du_piece_rechange_facture']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" class="text-right">Montant payé (<?php echo $currency; ?>):</td>
                                                        <td><?php echo $row['montant_paye_piece_rechange_facture']; ?></td>
                                                    </tr> -->
                                        </tfoot>

                                    </table>
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-6 cadre">
                                            <div class="row">
                                                <div class="col-md-6">Total HT</div>
                                                <div class="col-md-6"><?php echo $row['total_ht_gene_piece_rechange_facture'] . ' ' . $currency; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">Total TVA</div>
                                                <div class="col-md-6"><?php echo $row['total_tva_facture'] . ' ' . $currency; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p style="font-size:11pt;font-weight:bold">Total TTC</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p style="font-size:11pt;font-weight:bold">
                                                        <?php echo $row['total_ttc_gene_piece_rechange_facture'] . ' ' . $currency; ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">Montant dû</div>
                                                <div class="col-md-6"><?php echo $row['montant_du_piece_rechange_facture'] . ' ' . $currency; ?></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">Montant payé</div>
                                                <div class="col-md-6"><?php echo $row['montant_paye_piece_rechange_facture'] . ' ' . $currency; ?></div>
                                            </div>
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
            <a style="" href="<?php echo WEB_URL; ?>dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a>
        </div>
        <div id="mobile-preview-close_2">
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerFactureEmail.php?devis_id=<?php echo $_GET['devis_id']; ?>&facture_id=<?php echo $row['facture_id']; ?>&date_facture=<?php echo $row['date_facture']; ?>&email_customer=<?php echo $row['c_email']; ?>"> Envoyer au client par e-mail</a>
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerFactureSms.php?devis_id=<?php echo $_GET['devis_id']; ?>&facture_id=<?php echo $row['facture_id']; ?>&date_facture=<?php echo $row['date_facture']; ?>&mobile_customer=<?php echo $row['princ_tel']; ?>"> Envoyer au client par SMS</a>
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