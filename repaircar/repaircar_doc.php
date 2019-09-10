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
                            <img class="editable-area" id="logo" src="../img/luxury_garage_logo.jpg">
                        </div>
                        <div class="col-sm-8" style="font-size:15pt;">
                            <p>Mécanique générale - Climatisation - Clé d'origine - Scanner - Programmation - Electricité</p>
                            <p>Tel. 21 35 55 60 / 06 66 06 66</p>
                        </div>
                    </div>
                    <div class="row" id="content_1">
                        <div class="col-sm-9" id="info_gene">
                            <?php
                                if (isset($_GET['login_type']) && $_GET['login_type'] == "mechanics") { ?>
                            <?php } else { ?>
                                <p>Nom : <?php echo $row['c_name']; ?></p>
                            <?php } ?>
                            <!-- <p>Contact : <?php echo $row['contact_client']; ?></p> -->
                            <?php
                                if (isset($_GET['login_type']) && $_GET['login_type'] == "mechanics") { ?>
                            <?php } else { ?>
                                <p>Contact : <?php echo $row['princ_tel']; ?></p>
                            <?php } ?>
                            <p>Marque du véhicule : <?php echo $row['make_name']; ?></p>
                            <!-- <p>Marque du véhicule : <?php echo $row['car_make']; ?></p> -->
                            <p>Immatriculation : <?php echo $row['num_matricule']; ?></p>
                            <!-- <p>E-mail : <?php echo $row['email_client']; ?></p> -->
                            <?php
                                if (isset($_GET['login_type']) && $_GET['login_type'] == "mechanics") { ?>
                            <?php } else { ?>
                                <p>E-mail / tel.: <?php echo $row['c_email']; ?></p>
                            <?php } ?>
                        </div>
                        <div class="col-sm-4">
                            <div class="row">
                                <div class="col-sm-12" style="text-align:center;">
                                    <h4 style="text-decoration:underline;font-weight:bold">FICHE DE RECEPTION DU VEHICULE</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6" style="text-align:center;font-size:13pt;font-weight:bold">
                                    N° <?php echo $row['car_id']; ?> du <?php echo $row['add_date_recep_vehi']; ?>
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="row" id="content_2">
                        <div class="col-sm-4" style="padding:0">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">PRISE EN CHARGE</h3>
                                </div>
                                <div class="panel-body">
                                    <p>Heure : <?php echo $row['heure_reception']; ?></p>
                                    <?php if (isset($row['km_reception_vehi']) && $row['type_km'] == "km") {
                                            echo ("<p>Km : " . $row['km_reception_vehi'] . "</p>");
                                        }
                                        if (isset($row['km_reception_vehi']) && $row['type_km'] == "miles") {
                                            echo ("<p>Miles : " . $row['km_reception_vehi'] . "</p>");
                                        } ?>
                                    <p>Niveau de carburant : <?php echo $row['nivo_carbu_recep_vehi']; ?></p>
                                    <hr>

                                    <div class="row">
                                        <?php if (isset($row['cle_recep_vehi']) && !empty($row['cle_recep_vehi'])) {
                                                echo ("<div class='col-sm-6'><p>" . $row['cle_recep_vehi'] . "</p></div>");
                                            }
                                            if (isset($row['cle_recep_vehi']) && !empty($row['cle_recep_vehi'])) {
                                                echo ("<div class='col-sm-6'><p>" . $row['cle_recep_vehi_text'] . "</p></div>");
                                            } ?>
                                    </div>
                                    <div class="row">
                                        <?php if (isset($row['carte_grise_recep_vehi']) && !empty($row['carte_grise_recep_vehi'])) {
                                                echo ("<div class='col-sm-12'><p>" . $row['carte_grise_recep_vehi'] . "</p></div>");
                                            }
                                            ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['assur_recep_vehi']) && !empty($row['assur_recep_vehi'])) {
                                                        echo $row['assur_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['assur_recep_vehi']) && !empty($row['assur_recep_vehi'])) {
                                                        echo 'Exp.: ' . $row['add_date_assurance'];
                                                    } ?></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['visitetech_recep_vehi']) && !empty($row['visitetech_recep_vehi'])) {
                                                        echo $row['visitetech_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['visitetech_recep_vehi']) && !empty($row['visitetech_recep_vehi'])) {
                                                        echo 'Exp.: ' . $row['add_date_visitetech'];
                                                    } ?></p>
                                        </div>
                                    </div>

                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">ACCESSOIRES VEHICULE</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <p><?php if (isset($row['cric_levage_recep_vehi']) && !empty($row['cric_levage_recep_vehi'])) {
                                                        echo $row['cric_levage_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><?php if (isset($row['cle_roue']) && !empty($row['cle_roue'])) {
                                                        echo $row['cle_roue'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <p><?php if (isset($row['rallonge_roue_recep_vehi']) && !empty($row['rallonge_roue_recep_vehi'])) {
                                                        echo $row['rallonge_roue_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><?php if (isset($row['triangle']) && !empty($row['triangle'])) {
                                                        echo $row['triangle'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-7">
                                            <p><?php if (isset($row['pneu_secours']) && !empty($row['pneu_secours'])) {
                                                        echo $row['pneu_secours'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-5">
                                            <p><?php if (isset($row['extincteur']) && !empty($row['extincteur'])) {
                                                        echo $row['extincteur'];
                                                    } ?></p>

                                        </div>
                                    </div>
                                    <p><?php if (isset($row['anneau_remorquage_recep_vehi']) && !empty($row['anneau_remorquage_recep_vehi'])) {
                                                echo $row['anneau_remorquage_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['boite_pharma']) && !empty($row['boite_pharma'])) {
                                                echo $row['boite_pharma'];
                                            } ?></p>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">MOTIFS DE DEPOT</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['scanner_recep_vehi']) && !empty($row['scanner_recep_vehi'])) {
                                                        echo $row['scanner_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['elec_recep_vehi']) && !empty($row['elec_recep_vehi'])) {
                                                        echo $row['elec_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <p><?php if (isset($row['meca_recep_vehi']) && !empty($row['meca_recep_vehi'])) {
                                                echo $row['meca_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['pb_meca_recep_vehi']) && !empty($row['pb_meca_recep_vehi'])) {
                                                echo $row['pb_meca_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['pb_electro_recep_vehi']) && !empty($row['pb_electro_recep_vehi'])) {
                                                echo $row['pb_electro_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['pb_demar_recep_vehi']) && !empty($row['pb_demar_recep_vehi'])) {
                                                echo $row['pb_demar_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['conf_cle_recep_vehi']) && !empty($row['conf_cle_recep_vehi'])) {
                                                echo $row['conf_cle_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['sup_adblue_recep_vehi']) && !empty($row['sup_adblue_recep_vehi'])) {
                                                echo $row['sup_adblue_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['sup_fil_parti_recep_vehi']) && !empty($row['sup_fil_parti_recep_vehi'])) {
                                                echo $row['sup_fil_parti_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['sup_vanne_egr_recep_vehi']) && !empty($row['sup_vanne_egr_recep_vehi'])) {
                                                echo $row['sup_vanne_egr_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['voy_alum_recep_vehi']) && !empty($row['voy_alum_recep_vehi'])) {
                                                echo $row['voy_alum_recep_vehi'];
                                            } ?></p>

                                   
                                        <div class="row">
                                            <?php if (isset($row['voyant_1']) && !empty($row['voyant_1'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_1'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_2']) && !empty($row['voyant_2'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_2'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_3']) && !empty($row['voyant_3'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_3'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_4']) && !empty($row['voyant_4'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_4'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_5']) && !empty($row['voyant_5'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_5'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_6']) && !empty($row['voyant_6'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_6'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    ?>
                                        </div>

                                        <div class="row">
                                            <?php if (isset($row['voyant_7']) && !empty($row['voyant_7'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_7'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_8']) && !empty($row['voyant_8'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_8'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_9']) && !empty($row['voyant_9'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_9'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_10']) && !empty($row['voyant_10'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_10'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_11']) && !empty($row['voyant_11'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_11'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_12']) && !empty($row['voyant_12'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_12'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    ?>
                                        </div>

                                        <div class="row">
                                            <?php if (isset($row['voyant_13']) && !empty($row['voyant_13'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_13'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_14']) && !empty($row['voyant_14'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_14'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_15']) && !empty($row['voyant_15'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_15'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_16']) && !empty($row['voyant_16'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_16'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_17']) && !empty($row['voyant_17'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_17'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_18']) && !empty($row['voyant_18'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_18'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    ?>
                                        </div>

                                        <div class="row">
                                            <?php if (isset($row['voyant_19']) && !empty($row['voyant_19'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_19'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_20']) && !empty($row['voyant_20'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_20'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_21']) && !empty($row['voyant_21'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_21'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_22']) && !empty($row['voyant_22'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_22'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_23']) && !empty($row['voyant_23'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_23'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    if (isset($row['voyant_24']) && !empty($row['voyant_24'])) {
                                                        echo ("<div class='col-xs-2' style='padding-left:0px;'><img src='" . WEB_URL . $row['voyant_24'] . "'
                                            alt='' height='44' width='46'></div>");
                                                    }
                                                    ?>
                                        </div>
                                   
                                </div>

                                <div class="panel-heading">
                                    <h3 class="panel-title">ETAT DU VEHICULE A L'ARRIVE</h3>
                                </div>
                                <div class="panel-body">

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['etat_vehi_arrive']) && !empty($row['etat_vehi_arrive'])) {
                                                        echo $row['etat_vehi_arrive'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['etat_vehi_arrive']) && !empty($row['etat_vehi_arrive'])) {
                                                        echo $row['arriv_remarq_recep_vehi_text'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <p><?php if (isset($row['accident_recep_vehi']) && !empty($row['accident_recep_vehi'])) {
                                                echo $row['accident_recep_vehi'];
                                            } ?></p>
                                    <p><?php if (isset($row['etat_proprete_arrivee']) && !empty($row['etat_proprete_arrivee'])) {
                                                echo $row['etat_proprete_arrivee'];
                                            } ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding:0">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">PLAINTES DU CLIENT</h3>
                                </div>
                                <div class="panel-body">
                                    <p><?php echo $row['travo_effec']; ?></p>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">AUTRES OBSERVATIONS</h3>
                                </div>
                                <div class="panel-body">
                                    <p><?php echo $row['autres_obs']; ?></p>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">ASPECT INTERIEUR</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">COMPOSANTS</th>
                                                    <th scope="col">ETAT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Poste auto</th>
                                                    <td><?php echo $row['poste_auto']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Tableau de bord</th>
                                                    <td><?php echo $row['tableau_bord']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Coffre à gant</th>
                                                    <td><?php echo $row['coffre_gant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Tapis de sol</th>
                                                    <td><?php echo $row['tapis_sol']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Tapis plafond</th>
                                                    <td><?php echo $row['tapis_plafond']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Commutateur central</th>
                                                    <td><?php echo $row['commutateur_central']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Ecran de bord</th>
                                                    <td><?php echo $row['ecran_bord']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Ampoule intérieure</th>
                                                    <td><?php echo $row['ampoule_interieure']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Rétroviseur interne</th>
                                                    <td><?php echo $row['retroviseur_interne']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Bouton de vitre avant</th>
                                                    <td><?php echo $row['bouton_vitre_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Bouton de vitre arrière</th>
                                                    <td><?php echo $row['bouton_vitre_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Bouton de siège</th>
                                                    <td><?php echo $row['bouton_siege']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="panel-heading">
                                    <h3 class="panel-title">ETAT DU VEHICULE A LA SORTIE</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><?php if (isset($row['etat_reparation_sortie']) && !empty($row['etat_reparation_sortie'])) {
                                                        echo $row['etat_reparation_sortie'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p><?php if (isset($row['etat_proprete_sortie']) && !empty($row['etat_proprete_sortie'])) {
                                                        echo $row['etat_proprete_sortie'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['sortie_remarq_recep_vehi']) && !empty($row['sortie_remarq_recep_vehi'])) {
                                                        echo $row['sortie_remarq_recep_vehi'];
                                                    } ?></p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p><?php if (isset($row['sortie_remarq_recep_vehi']) && !empty($row['sortie_remarq_recep_vehi'])) {
                                                        echo $row['sortie_remarq_recep_vehi_text'];
                                                    } ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding:0">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">ASPECT EXTERIEUR</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="table-responsive-sm">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">COMPOSANTS</th>
                                                    <th scope="col">ETAT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">Pare brise avant</th>
                                                    <td><?php echo $row['pare_brise_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Pare brise arrière</th>
                                                    <td><?php echo $row['pare_brise_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Phare gauche</th>
                                                    <td><?php echo $row['phare_gauche']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Phare droit</th>
                                                    <td><?php echo $row['phare_droit']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Clignotant droit</th>
                                                    <td><?php echo $row['clignotant_droit']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Clignotant gauche</th>
                                                    <td><?php echo $row['clignotant_gauche']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Pare choc avant</th>
                                                    <td><?php echo $row['pare_choc_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Pare choc arrière</th>
                                                    <td><?php echo $row['pare_choc_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Feu avant</th>
                                                    <td><?php echo $row['feu_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Feu arrière</th>
                                                    <td><?php echo $row['feu_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Feu de brouillard</th>
                                                    <td><?php echo $row['feu_brouillard']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Vitres avant</th>
                                                    <td><?php echo $row['vitre_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Vitres arrière</th>
                                                    <td><?php echo $row['vitre_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Poignets avant</th>
                                                    <td><?php echo $row['poignet_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Poignets arrière</th>
                                                    <td><?php echo $row['poignet_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Plaque avant</th>
                                                    <td><?php echo $row['plaque_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Plaque arrière</th>
                                                    <td><?php echo $row['plaque_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Contrôle pneu</th>
                                                    <td><?php echo $row['controle_pneu']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Balai essuie glace</th>
                                                    <td><?php echo $row['balai_essuie_glace']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Batterie</th>
                                                    <td><?php echo $row['batterie']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Rétroviseur gauche</th>
                                                    <td><?php echo $row['retroviseur_gauche']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Rétroviseur droit</th>
                                                    <td><?php echo $row['retroviseur_gauche']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Symbole avant</th>
                                                    <td><?php echo $row['symbole_avant']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Symbole arrière</th>
                                                    <td><?php echo $row['symbole_arriere']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Poignet de capot</th>
                                                    <td><?php echo $row['poignet_capot']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Cache moteur</th>
                                                    <td><?php echo $row['cache_moteur']; ?></td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">Alternateur</th>
                                                    <td><?php echo $row['alternateur']; ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" id="nb" style="margin-bottom:10px;">
                        <div class="col-sm-12" style="border:solid 2px #000">
                            <p>
                                <b>N.B:</b> Passé un délai de 48h après réception du devis par le client ou la réparation de tout véhicule signifiée au client
                                et non retiré de nos ateliers, fera l'objet d'une facturation complémentaire de 10.000 FCFA par jour pour frais de gardiennage.
                                Nous déclinons toute responsabilité pour tout objet y compris les documents de bord se trouvant dans le véhicule. Vous êtes priez
                                de vérifier votre véhicule à la livraison. Aucune réclamation ne sera acceptée après la sortie de nos installations. En cas de non
                                retrait de votre véhicule dans un délai d'un (1) mois, un constat sera fait par un huissier et le véhicule remis aux autorités
                                compétentes. Les contrôles réalisés portent uniquement sur les éléments visibles du véhicule et n'implique aucun démontage.
                                En conséquence LUXURY GARARGE ne saurai être tenu pour responsable en cas.
                            </p>
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
            <!-- <a style="" href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php"><img src="<?php echo WEB_URL; ?>img/back.png" style="float:left; margin:0 10px 0 0;"> Retour </a> -->
        </div>
        <div id="mobile-preview-close_2">
            <!-- <a onclick="reloadPage();" href=""> Rafraichir la page </a> -->
            <!-- <a style="" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_verso.php?car_id=<?php echo $_GET['car_id']; ?>&login_type=<?php echo $_GET['login_type']; ?>"> Afficher le verso</a> -->
        </div>
    </body>

    </html>

<?php } ?>