<?php
include('../helper/common.php');
include_once('../config.php');

$wms = new wms_core();

$rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $_GET['vehi_diag_id']);

// var_dump($rows);

// die();

$i = 0;

if (!empty($rows) && count($rows) > 0) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Fiche de comparaison des prix des pièces de rechange par fournisseurs</title>
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
                                FICHE DE COMPARAISON DES PRIX DES PIECES DE RECHANGE PAR FOURNISSEURS
                            </h4>
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
                                                <th style="text-align:center">Désignations</th>
                                                <th style="text-align:center">Marque</th>
                                                <th style="text-align:center">Quantités</th>
                                                <th style="text-align:center">Prix unitaire</th>
                                                <th style="text-align:center">Fournisseurs</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            foreach ($rows as $row) { ?>
                                                <tr>
                                                    <td><?php echo $row['designation_piece_rechange']; ?></td>
                                                    <td><?php echo $row['marque_piece_rechange']; ?></td>
                                                    <td><?php echo $row['qte_piece_rechange']; ?></td>
                                                    <td id="piece_price_<?php echo $i; ?>"><?php echo $row['prix_piece_rechange']; ?></td>
                                                    <td><?php echo $row['s_name']; ?></td>
                                                </tr>
                                                <?php
                                                $i++;
                                            } 

                                            // var_dump($rows);
                                            
                                            // On retourne la représentation JSON du tableau
                                            $piece_rechange_compar_list_json = json_encode($rows);
                                            ?>
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

            #mobile-preview-close img, #mobile-preview-close_2 img {
                width: 20px;
                height: auto;
            }

            #mobile-preview-close a:nth-child(2), #mobile-preview-close_2 a:nth-child(2) {
                background: #f5f5f5;
                margin-bottom: 50px;
            }

            #mobile-preview-close a:nth-child(2) img, #mobile-preview-close_2 a:nth-child(2) img {
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
                #mobile-preview-close a, #mobile-preview-close_2 a {
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
            <a style="" href="<?php echo WEB_URL; ?>estimate/devis_prix_piece_rechange.php?vehi_diag_id=<?php echo $_GET['vehi_diag_id']; ?>"> Créer un devis </a>
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

            // analyse de la chaîne de caractères JSON et 
            // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
            var piece_rechange_compar_list_obj = JSON.parse('<?= $piece_rechange_compar_list_json; ?>');

            // Déclaration et initialisation de l'objet itérateur
            var iterateur = piece_rechange_compar_list_obj.keys();

            // Déclaration et initialisation de l'indice ou compteur
            var row = iterateur.next().value;

            // Parcours du tableau d'objet
            for (const key of piece_rechange_compar_list_obj) {

                // Conversion en flottant
                key.prix_piece_rechange = parseFloat(key.prix_piece_rechange);

                console.log(numeral(key.prix_piece_rechange).format('0,0 $'));

                // Affectation des nouvelles valeurs
                $("#piece_price_" + row).html(numeral(key.prix_piece_rechange).format('0,0 $'));

                // incrémentation du compteur
                row++;

            }

        </script>
    </body>

    </html>

<?php } ?>