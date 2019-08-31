<?php
include('../helper/common.php');
include_once('../config.php');
include_once('../session.php');

$wms = new wms_core();

$result_settings = $wms->getWebsiteSettingsInformation($link);
if (!empty($result_settings)) {
    $currency = $result_settings['currency'];
    $email = $result_settings['email'];
}

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
                padding-top: 0px;
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
                height: 93px;
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

            table th {
                font-size: 9pt;
            }

            table tr td {
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
            <div class="invoice-inner">
                <div class="row" id="header">
                    <div class="col-xs-3" style="height:100px;">
                        <!-- <img class="editable-area" id="logo" src="<?php echo WEB_URL; ?>img/luxury_garage_logo.jpg" height="100" width="100"> -->
                        <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg" height="100" width="100">
                    </div>
                    <div class="col-xs-3 col-xs-offset-6">
                        <p><?php echo date_format(date_create($row['date_facture']), 'd/m/Y'); ?></p>
                    </div>
                </div>
                <div class="row" id="content_1">
                    <div class="col-xs-8">
                        <p style="font-size:9pt;font-weight:600;">LUXURY GARAGE</p>
                    </div>
                    <div class="col-xs-4" id="info_gene">
                        <p><?php echo $row['c_name']; ?></p>
                        <p><?php echo $row['c_address']; ?></p>
                        <p>Tel: <?php echo $row['princ_tel']; ?></p>
                    </div>
                </div>
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-xs-5 col-xs-onset-7" style="border-radius: 20px; border: solid 2px #000;margin-left:20px;height: 30px;">
                        <p>Facture N° : <?php echo $row['facture_id']; ?></p>
                    </div>
                </div>

                <!-- <div class="row" id="content_2"> -->
                <!-- <div class="col-xs-12"> -->

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
                                        <p><?php echo $row['VIN']; ?></p>
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
                                        <p><?php echo $row['make_name']; ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <p>Modèle</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p><?php echo $row['model_name']; ?></p>
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
                                            // $facture_data = unserialize($row['facture_data']);
                                            $facture_data = json_decode($row['facture_data'], true);

                                            // var_dump($facture_data);
                                            // die();

                                            foreach ($facture_data as $facture) { ?>
                                        <tr>
                                            <td><?php echo $facture['code_piece_rechange_facture']; ?></td>
                                            <td><?php echo str_replace('u0027', "'", $facture['designation_piece_rechange_facture']); ?></td>
                                            <td><?php echo $facture['qte_piece_rechange_facture']; ?></td>
                                            <td id="facture_article_price_<?php echo $i; ?>"><?php echo $facture['prix_piece_rechange_min_facture']; ?></td>
                                            <td><?php echo $facture['remise_piece_rechange_facture']; ?></td>
                                            <td id="facture_article_total_ht_<?php echo $i; ?>"><?php echo $facture['total_prix_piece_rechange_facture_ht']; ?></td>
                                            <td id="facture_article_total_ttc_<?php echo $i; ?>"><?php echo $facture['total_prix_piece_rechange_facture_ttc']; ?></td>
                                        </tr>
                                        <?php $i++;
                                            }

                                            // On retourne la représentation JSON du tableau
                                            $facture_data_json = json_encode($facture_data);
                                            ?>
                                        <tr>
                                            <td colspan="6" class="text-right">Montant main d'oeuvre (<?php echo $currency; ?>):</td>
                                            <td id="facture_montant_labour"><?php echo $row['montant_main_oeuvre_facture']; ?></td>
                                        </tr>
                                    </tbody>

                                </table>

                                <div class="col-xs-7">
                                    <div class="row">
                                        <div class="col-xs-12" id="content_3">
                                            <p style="display:inline-block;font-size:7pt">AVANCE 75% = <span id="avance"></span></p>
                                            <p style="display:inline-block;font-size:7pt">ET RESTE 25% = <span id="reste_a_payer"></span></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-5 cadre" style="width:220px;">
                                        <div class="row">
                                            <div class="col-xs-5">Total HT</div>
                                            <div class="col-xs-7" id="facture_total_ht"><?php echo $row['total_ht_gene_piece_rechange_facture'] . ' ' . $currency; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">Total TVA</div>
                                            <div class="col-xs-7" id="facture_total_tva"><?php echo $row['total_tva_facture'] . ' ' . $currency; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">
                                                <p style="font-size:9pt;font-weight:bold">Total TTC</p>
                                            </div>
                                            <div class="col-xs-7">
                                                <p style="font-size:9pt;font-weight:bold" id="facture_total_ttc">
                                                    <?php echo $row['total_ttc_gene_piece_rechange_facture'] . ' ' . $currency; ?>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">Montant dû</div>
                                            <div class="col-xs-7" id="facture_mont_du"><?php echo $row['montant_du_piece_rechange_facture'] . ' ' . $currency; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-5">Montant payé</div>
                                            <div class="col-xs-7" id="facture_mont_paye"><?php echo $row['montant_paye_piece_rechange_facture'] . ' ' . $currency; ?></div>
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
        <!-- <a style="" href="<?php echo WEB_URL; ?>dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a> -->

        <?php if ($_SESSION['login_type'] == 'customer') { ?>
        <a style="" href="<?php echo WEB_URL; ?>cust_panel/cust_dashboard.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a>
        <?php } ?>
    </div>
    <div id="mobile-preview-close_2">
        <?php if ($_SESSION['login_type'] != 'customer') { ?>
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerFactureEmail.php?devis_id=<?php echo $_GET['devis_id']; ?>&facture_id=<?php echo $row['facture_id']; ?>&date_facture=<?php echo $row['date_facture']; ?>&email_customer=<?php echo $row['c_email']; ?>"> Envoyer au client par e-mail</a>
            <a style="" href="<?php echo WEB_URL; ?>sendCustomerFactureSms.php?devis_id=<?php echo $_GET['devis_id']; ?>&facture_id=<?php echo $row['facture_id']; ?>&date_facture=<?php echo $row['date_facture']; ?>&mobile_customer=<?php echo $row['princ_tel']; ?>"> Envoyer au client par SMS</a>
        <?php } ?>
    </div>
    <script>
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
        var total_ttc = "<?php echo $row['total_ttc_gene_piece_rechange_facture']; ?>";
        var total_ht = "<?php echo $row['total_ht_gene_piece_rechange_facture']; ?>";
        var total_tva = "<?php echo $row['total_tva_facture']; ?>";
        var montant_labour = "<?php echo $row['montant_main_oeuvre_facture']; ?>";
        var avance = 0;
        var reste_a_payer = 0;
        var montant_du = "<?php echo $row['montant_du_piece_rechange_facture']; ?>";
        var montant_paye = "<?php echo $row['montant_paye_piece_rechange_facture']; ?>";

        // analyse de la chaîne de caractères JSON et 
        // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
        var facture_data_obj = JSON.parse('<?= $facture_data_json; ?>');

        // Déclaration et initialisation de l'objet itérateur
        var iterateur = facture_data_obj.keys();

        // Déclaration et initialisation de l'indice ou compteur
        var row = iterateur.next().value + 1;

        // Parcours du tableau d'objet
        for (const key of facture_data_obj) {

            console.log(key);

            // Conversion en flottant
            key.prix_piece_rechange_min_facture = parseFloat(key.prix_piece_rechange_min_facture);
            key.total_prix_piece_rechange_facture_ht = parseFloat(key.total_prix_piece_rechange_facture_ht);
            key.total_prix_piece_rechange_facture_ttc = parseFloat(key.total_prix_piece_rechange_facture_ttc);

            // Affectation des nouvelles valeurs
            $("#facture_article_price_" + row).html(numeral(key.prix_piece_rechange_min_facture).format('0,0 $'));
            $("#facture_article_total_ht_" + row).html(numeral(key.total_prix_piece_rechange_facture_ht).format('0,0 $'));
            $("#facture_article_total_ttc_" + row).html(numeral(key.total_prix_piece_rechange_facture_ttc).format('0,0 $'));

            // incrémentation du compteur
            row++;
        }

        // Conversion des variables en flottant
        total_ttc = parseFloat(total_ttc);
        total_ht = parseFloat(total_ht);
        total_tva = parseFloat(total_tva);
        montant_labour = parseFloat(montant_labour);
        montant_du = parseFloat(montant_du);
        montant_paye = parseFloat(montant_paye);

        // calcul de l'avance et du reste à payer
        avance = 0.75 * total_ttc;
        reste_a_payer = 0.25 * total_ttc;

        // Conversion de l'avance et du reste à payer en flottant
        avance = parseFloat(avance);
        reste_a_payer = parseFloat(reste_a_payer);

        // Formatage de l'avance et du reste à payer
        avance = numeral(avance).format('0,0 $');
        reste_a_payer = numeral(reste_a_payer).format('0,0 $');

        // console.log(avance);
        // console.log(reste_a_payer);

        $("#facture_total_ttc").html(numeral(total_ttc).format('0,0 $'));
        $("#facture_total_ht").html(numeral(total_ht).format('0,0 $'));
        $("#facture_total_tva").html(numeral(total_tva).format('0,0 $'));
        $("#facture_montant_labour").html(numeral(montant_labour).format('0,0 $'));
        $("#avance").html(avance);
        $("#reste_a_payer").html(reste_a_payer);
        $("#facture_mont_paye").html(numeral(montant_paye).format('0,0 $'));
        $("#facture_mont_du").html(numeral(montant_du).format('0,0 $'));
    </script>
</body>

</html>

<?php } ?>