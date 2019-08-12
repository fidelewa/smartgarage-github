<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();

$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
    $site_name = $result_settings['site_name'];
    $currency = $result_settings['currency'];
    $email = $result_settings['email'];
    $address = $result_settings['address'];
}

$row = $wms->getRepairCarDiagnosticDevisInfoByDiagId($link, $_GET['vehi_diag_id'], $_GET['devis_id']);

// $dateProchCtrTech = ctrTechCalculate($row['add_date_ctr_tech'], $row['delai_ctr_tech']);

// var_dump($dateProchCtrTech);
// var_dump($row);

$i = 1;

if (!empty($row) && count($row) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>devis de réparation d'un véhicule</title>
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
                    font-size: 10px;
                    line-height: 20px;
                    padding-top:0px;
                }

                .invoice-wrap {
                    width: 600px;
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
                    width: 150px;
                    height: 63px;
                    border: solid 2px #000;
                    padding: 5px;
                    /* margin-bottom: 5px; */
                }

                .cadre {
                    border-radius: 20px;
                    /* width: 400px;
                                                                                                                                                height: 175px; */
                    border: solid 2px #000;
                    padding: 5px;
                    margin-bottom: 5pt;
                }

                #info_gene p {
                    font-size: 8pt;
                }

                table th{
                    font-size: 9pt;
                }

                table tr td{
                    font-size: 8pt;
                }

                #content_2 p {
                    font-size: 9pt;
                }

                #content_3 p {
                    font-size: 10pt;
                }

                h3 {
                    text-align: center
                }

                .signature {
                    font-size: 10pt;
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
                <div class="invoice-inner content_resize">
                    <div class="row" id="header">
                        <div class="col-xs-3" style="height:100px;">
                            <!-- <img class="editable-area" id="logo" src="<?php echo WEB_URL; ?>img/luxury_garage_logo.jpg" height="100" width="100"> -->
                            <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg" height="100" width="100">
                        </div>
                        <div class="col-xs-3 col-xs-offset-6">
                            <p><?php echo date_format(date_create($row['date_devis']), 'd/m/Y'); ?></p>
                        </div>
                    </div>
                    <div class="row" id="content_1">
                        <div class="col-xs-8">
                            <p style="font-size:9pt;font-weight:600;">LUXURY GARAGE</p>
                        </div>
                        <div class="col-xs-4" id="info_gene" >
                            <p><?php if (isset($row['c_name'])) {
                                    echo $row['c_name'];
                                } else {
                                    echo $row['nom_client'];
                                } ?></p>
                            <!-- <p><?php echo $row['c_address']; ?></p> -->
                            <p>Tel: <?php if (isset($row['princ_tel'])) {
                                        echo $row['princ_tel'];
                                    } else {
                                        echo $row['numero_tel_client'];
                                    } ?></p>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom:5px;">
                        <div class="col-xs-5 col-xs-onset-7" style="border-radius: 20px; border: solid 2px #000;margin-left:20px;height: 30px;">
                            <p>Devis N° : <?php echo $row['devis_id']; ?></p>
                        </div>
                    </div>

                    <div id="content_2">
                        <div class="cadre">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p>Numéro de serie</p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php echo $row['chasis_no']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p>Immatriculation</p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php if (isset($row['VIN'])) {
                                                    echo $row['VIN'];
                                                } else {
                                                    echo $row['imma_vehi_client'];
                                                } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p>Marque</p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php if (isset($row['make_name'])) {
                                                    echo $row['make_name'];
                                                } else {
                                                    echo $row['marque_vehi_client'];
                                                } ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            <p>Modèle</p>
                                        </div>
                                        <div class="col-xs-6">
                                            <p><?php if (isset($row['model_name'])) {
                                                    echo $row['model_name'];
                                                } else {
                                                    echo $row['model_vehi_client'];
                                                } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                                                                                    <div class="col-xs-6">
                                                                                                        <div class="row">
                                                                                                            <div class="col-xs-6">
                                                                                                                <p>Première mise en circulation</p>
                                                                                                            </div>
                                                                                                            <div class="col-xs-6">
                                                                                                                <p><?php echo $row['add_date_mise_circu']; ?></p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xs-6">
                                                                                                        <div class="row">
                                                                                                            <div class="col-xs-6">
                                                                                                                <p>Prochain controle technique</p>
                                                                                                            </div>
                                                                                                            <div class="col-xs-6">
                                                                                                                <p><?php echo $row['add_date_visitetech']; ?></p>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div> -->
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="row">
                                    <table border="1" class="table dt-responsive fixed">
                                        <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th width="50px">Désignation</th>
                                                <!-- <th>Marque</th> -->
                                                <th>Quantité</th>
                                                <th>Tarif HT</th>
                                                <!-- <th>Remise</th> -->
                                                <th>Total HT</th>
                                                <th>Total TTC</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            // On délinéarise l'array
                                            // $devis_data = unserialize($row['devis_data']);
                                            $devis_data = json_decode($row['devis_data'], true);

                                            // var_dump($devis_data);
                                            // die();

                                            foreach ($devis_data as $devis) { 
                                               
                                                ?>
                                                <tr>
                                                    <td><?php echo $devis['code_piece_rechange_devis']; ?></td>
                                                    <td><?php echo str_replace('u0027', "'", $devis['designation_piece_rechange_devis']); ?></td>
                                                    <!-- <td><?php echo $devis['marque']; ?></td> -->
                                                    <td><?php echo $devis['qte_piece_rechange_devis']; ?></td>
                                                    <td id="article_price_<?php echo $i; ?>"><?php echo $devis['prix_piece_rechange_min_devis']; ?></td>
                                                    <!-- <td><?php echo $devis['remise_piece_rechange_devis']; ?></td> -->
                                                    <td id="article_total_ht_<?php echo $i; ?>"><?php echo $devis['total_prix_piece_rechange_devis_ht']; ?></td>
                                                    <td id="article_total_ttc_<?php echo $i; ?>"><?php echo $devis['total_prix_piece_rechange_devis_ttc']; ?></td>
                                                </tr>
                                                <?php $i++;
                                            }

                                            // On retourne la représentation JSON du tableau
                                            $devis_data_json = json_encode($devis_data);
                                            ?>
                                            <tr>
                                                <td colspan="5" class="text-right">Montant main d'oeuvre (<?php echo $currency; ?>):</td>
                                                <td id="mont_labour"><?php echo $row['main_oeuvre_piece_rechange_devis']; ?></td>
                                            </tr>
                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                    <!-- <div class="row"> -->

                                    <div class="col-xs-7">
                                        <div class="row">
                                            <div class="col-xs-12" id="content_3">
                                                <p style="display:inline-block;font-size:7pt">AVANCE 75% = <span id="avance"></span></p>
                                                <p style="display:inline-block;font-size:7pt">ET RESTE 25% = <span id="reste_a_payer"></span></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-5 cadre" style="width:220px;">
                                        <div class="row">
                                            <div class="col-xs-5">Total HT</div>
                                            <div class="col-xs-7" id="total_ht"><?php echo $row['total_ht_gene_piece_rechange_devis'] . ' ' . $currency; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">Remise (%)</div>
                                            <div class="col-xs-7" id="devis_remise"><?php echo $row['devis_remise'] ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">Total TVA</div>
                                            <div class="col-xs-7" id="total_tva"><?php echo $row['total_tva'] . ' ' . $currency; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <p style="font-size:9pt;font-weight:bold">Total TTC</p>
                                            </div>
                                            <div class="col-xs-7">
                                                <p style="font-size:9pt;font-weight:bold" id="total_ttc">
                                                    <?php echo $row['total_ttc_gene_piece_rechange_devis'] . ' ' . $currency; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- </div> -->
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
            <!-- <a style="" href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_list.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a> -->
        </div>
        <div id="mobile-preview-close_2">
            <!-- <a href="edition.php?devis_id=<?php echo $_GET['devis_id']; ?>" onClick="edition();return false;">Imprimer</a> -->
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerDevisEmail.php?vehi_diag_id=<?php echo $_GET['vehi_diag_id']; ?>&devis_id=<?php echo $_GET['devis_id']; ?>&email_customer=<?php echo $row['c_email']; ?>"> Envoyer au client par e-mail</a>
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerDevisSms.php?vehi_diag_id=<?php echo $_GET['vehi_diag_id']; ?>&devis_id=<?php echo $_GET['devis_id']; ?>&mobile_customer=<?php echo $row['princ_tel']; ?>"> Envoyer au client par SMS</a>
        </div>
        <script type="text/javascript">
            var devis_id = "<?php echo $_GET['devis_id']; ?>";

            function edition() {
                options = "Width=700,Height=700";
                window.open("edition.php?devis_id=" + devis_id, "edition", options);
            }

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

            // Initialisation des variables
            var total_ttc = "<?php echo $row['total_ttc_gene_piece_rechange_devis']; ?>";
            var total_ht = "<?php echo $row['total_ht_gene_piece_rechange_devis']; ?>";
            var total_tva = "<?php echo $row['total_tva']; ?>";
            var montant_labour = "<?php echo $row['main_oeuvre_piece_rechange_devis']; ?>";
            var avance = 0;
            var reste_a_payer = 0;

            // var row = <?php echo $i; ?>;

            // analyse de la chaîne de caractères JSON et 
            // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
            var devis_data_obj = JSON.parse('<?= $devis_data_json; ?>');

            // Déclaration et initialisation de l'objet itérateur
            var iterateur = devis_data_obj.keys();

            // Déclaration et initialisation de l'indice ou compteur
            var row = iterateur.next().value + 1;

            // Parcours du tableau d'objet
            for (const key of devis_data_obj) {

                // Conversion en flottant
                key.prix_piece_rechange_min_devis = parseFloat(key.prix_piece_rechange_min_devis);
                key.total_prix_piece_rechange_devis_ht = parseFloat(key.total_prix_piece_rechange_devis_ht);
                key.total_prix_piece_rechange_devis_ttc = parseFloat(key.total_prix_piece_rechange_devis_ttc);

                // Affectation des nouvelles valeurs
                $("#article_price_" + row).html(numeral(key.prix_piece_rechange_min_devis).format('0,0 $'));
                $("#article_total_ht_" + row).html(numeral(key.total_prix_piece_rechange_devis_ht).format('0,0 $'));
                $("#article_total_ttc_" + row).html(numeral(key.total_prix_piece_rechange_devis_ttc).format('0,0 $'));

                // incrémentation du compteur
                row++;

            }

            // Conversion des variables en flottant
            total_ttc = parseFloat(total_ttc);
            total_ht = parseFloat(total_ht);
            total_tva = parseFloat(total_tva);
            montant_labour = parseFloat(montant_labour);

            // calcul de l'avance et du reste à payer
            avance = 0.75 * total_ttc;
            reste_a_payer = 0.25 * total_ttc;

            // Conversion de l'avance et du reste à payer en flottant
            avance = parseFloat(avance);
            reste_a_payer = parseFloat(reste_a_payer);

            // Formatage de l'avance et du reste à payer
            avance = numeral(avance).format('0,0 $');
            reste_a_payer = numeral(reste_a_payer).format('0,0 $');

            console.log(avance);
            console.log(reste_a_payer);

            $("#total_ttc").html(numeral(total_ttc).format('0,0 $'));
            $("#total_ht").html(numeral(total_ht).format('0,0 $'));
            $("#total_tva").html(numeral(total_tva).format('0,0 $'));
            $("#mont_labour").html(numeral(montant_labour).format('0,0 $'));
            $("#avance").html(avance);
            $("#reste_a_payer").html(reste_a_payer);
        </script>
    </body>

    </html>

<?php } ?>