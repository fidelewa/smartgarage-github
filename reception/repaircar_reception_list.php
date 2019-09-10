<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$failedinfo = 'none';
$failedinfo_2 = 'none';
$addinfo_2 = 'none';
$addinfo_3 = 'none';
$addinfo_4 = 'none';
$addinfo_5 = 'none';
$failedinfo_2 = 'none';
$addinfo_att = 'none';
$msg = "";
$msg_2 = "";
$msg_3 = "";
$msg_att = "";
$msg_4 = "";
$msg_5 = "";
$msg_sms_failed = "";
$mech_msg_failedinfo = "";

if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "La voiture a été supprimée de la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo_2 = 'block';
    $msg_2 = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'etat_vehi_sortie') {
    $addinfo = 'block';
    $msg = "L'état du véhicule à la sortie à été défini avec succès !";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "La voiture receptionnée a été modifiée";
}
if (isset($_GET['att']) && $_GET['att'] == 'attribution') {

    if (isset($_GET['car_id']) && isset($_GET['mecanicien_id'])) {

        $addinfo_att = 'block';
        // $msg = "La fiche de réception du véhicule d'identifiant " . $_GET['car_id'] . " à été attribuée au mécanicien d'identifiant " . $_GET['mecanicien_id'];
        $msg_att = "La fiche de réception du véhicule " . $_GET['marque'] . ' ' . $_GET['modele'] . ' ' . $_GET['imma'] . " à été attribuée à " . $_GET['mecanicien_id'];
    }
}

if (isset($_GET['att']) && $_GET['att'] == 'attribution_done') {

    if (isset($_GET['car_id']) && isset($_GET['mecanicien_id'])) {

        $addinfo = 'block';
        // $msg = "La fiche de réception du véhicule d'identifiant " . $_GET['car_id'] . " à été attribuée au mécanicien d'identifiant " . $_GET['mecanicien_id'];
        $msg = "La fiche de réception du véhicule " . $_GET['marque'] . ' ' . $_GET['modele'] . ' ' . $_GET['imma'] . " à été attribuée à " . $_GET['mecanicien_id'];
    }
}

if (isset($_GET['sms']) && $_GET['sms'] == 'send_client_sms_succes') {
    $addinfo_2 = 'block';
    $msg_2 = "SMS envoyé au client avec succès";
}

if (isset($_GET['sms']) && $_GET['sms'] == 'send_client_sms_failed') {
    $failedinfo = 'block';
    $msg = "L'envoi du SMS au client à échoué";
}

// NOTIFICATION MECANICIEN SEUL

if (isset($_GET['sms']) && $_GET['sms'] == 'send_mech_sms_failed') {
    $failedinfo = 'block';
    $msg = "L'envoi du SMS au chef mécanicien à échoué";
}

if (isset($_GET['sms']) && $_GET['sms'] == 'send_mech_sms_succes') {
    $addinfo_4 = 'block';
    $msg_4 = "Un SMS a été envoyé au chef mécanicien";
}

// NOTIFICATION ELECTRICIEN SEUL

if (isset($_GET['sms']) && $_GET['sms'] == 'send_electro_sms_failed') {
    $failedinfo_2 = 'block';
    $msg_sms_failed = "L'envoi du SMS au chef électricien à échoué";
}

if (isset($_GET['sms']) && $_GET['sms'] == 'send_electro_sms_succes') {
    $addinfo_5 = 'block';
    $msg_5 = "Un SMS a été envoyé au chef électricien";
}

// NOTIFICATION ELECTRICIEN ET MECANICIEN

if (isset($_GET['sms_mech_elec']) && $_GET['sms_mech_elec'] == 'send_mech_elec_sms_succes') {
    $addinfo_3 = 'block';
    $msg_3 = "SMS envoyé avec succès aux chefs mécaniciens et électriciens";
}

if (isset($_GET['sms_mech_elec']) && $_GET['sms_mech_elec'] == 'send_mech_elec_sms_failed') {
    $failedinfo_2 = 'block';
    $mech_msg_failedinfo = "L'envoi des SMS aux chefs mécaniciens et électriciens à échoué";
}

// var_dump($_SESSION);

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1><i class="fa fa-list"></i> Réception de véhicule - Liste des véhicules réceptionnés</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des voitures réceptionnées</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you_2" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_4; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg_4; ?>
            </div>
            <div id="you_3" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_5; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg_5; ?>
            </div>
            <div id="youyou" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_att; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg_att; ?>
            </div>
            <!-- <div id="us" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_2; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg_2; ?>
            </div> -->
            <div id="usus" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo_3; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg_3; ?>
            </div>
            <div id="his" class="alert alert-danger alert-dismissable" style="display:<?php echo $failedinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
                <?php echo $msg; ?>
            </div>
            <div id="his_2" class="alert alert-danger alert-dismissable" style="display:<?php echo $failedinfo_2; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
                <?php echo $msg_sms_failed; ?>
            </div>
            <div id="hishis" class="alert alert-danger alert-dismissable" style="display:<?php echo $failedinfo_2; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <!-- <h4><i class="icon fa fa-ban"></i></h4> -->
                <?php echo $mech_msg_failedinfo; ?>
            </div>
            <div align="right" style="margin-bottom:1%;"><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div>
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste des voitures réceptionnées</h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>ID Reception</th>
                                <th>Immatriculation du véhicule</th>
                                <th>Receptionné par</th>
                                <!-- <th>Statut attribution</th> -->
                                <!-- <th>Attribué à</th> -->
                                <th>Statut diagnostic mécanique</th>
                                <th>Statut diagnostic électrique</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $result = $wms->getAllRecepRepairCarList($link);

                            // var_dump($result);

                            // die();

                            foreach ($result as $row) {
                                // $image = WEB_URL . 'img/no_image.jpg';
                                // $image_customer = WEB_URL . 'img/no_image.jpg';

                                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['image_vehi']) && $row['image_vehi'] != '') {
                                //     $image = WEB_URL . 'img/upload/' . $row['image_vehi']; //car image
                                // }
                                // if (file_exists(ROOT_PATH . '/img/upload/' . $row['customer_image']) && $row['customer_image'] != '') {
                                //     $image_customer = WEB_URL . 'img/upload/' . $row['customer_image']; //customer iamge
                                // }

                                ?>
                                <tr>
                                    <td><?php echo $row['car_id']; ?></td>
                                    <td><?php echo $row['num_matricule']; ?></td>
                                    <td><?php echo $row['recep_name']; ?></td>
                                    <!-- <td><?php if ($row['mech_name'] == '') {
                                                    if (isset($row['attribution_mecanicien'])) {
                                                        echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_mecanicien'] . "</span> <br/>";
                                                    }
                                                    if (isset($row['attribution_electricien'])) {
                                                        echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_electricien'] . "</span> <br/>";
                                                    }
                                                } else {
                                                    echo $row['mech_name'];
                                                }
                                                ?></td> -->
                                    <!-- <td>
                                                            <?php if ($row['statut_diagnostic_mecanique'] == 1 && isset($row['attribution_mecanicien'])) {
                                                                echo $row['mecano_name'] . ' : ' . $row['attribution_mecanicien'];
                                                            } else {
                                                                echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_mecanicien'] . "</span> <br/>";
                                                            } ?>
                                                            <?php if ($row['statut_diagnostic_electrique'] == 1 && isset($row['attribution_electricien'])) {
                                                                echo $row['electro_name'] . ' : ' . $row['attribution_electricien'];
                                                            } else {
                                                                echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_electricien'] . "</span> <br/>";
                                                            } ?>
                                                        </td> -->
                                    <!-- <td> -->
                                        <?php
                                        /* Si le véhicule réceptionné en question à été attribué seulement au chef mécanicien 
                                        et n'a pas encore fait l'objet de diagnostic mécanique */
                                        // if (isset($row['attribution_mecanicien']) && !isset($row['attribution_electricien'])) {
                                        //     if (!isset($row['statut_diagnostic_mecanique'])) {
                                        //         echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_mecanicien'] . "</span> <br/>";
                                        //     }
                                        // }
                                        /* Si le véhicule réceptionné en question à été attribué seulement au chef électricien 
                                         et n'a pas encore fait l'objet de diagnostic électrique*/
                                        // if (isset($row['attribution_electricien']) && !isset($row['attribution_mecanicien'])) {
                                        //     if (!isset($row['statut_diagnostic_electrique'])) {
                                        //         echo "<span class='label label-default'>En cours d'attribution au " . $row['attribution_electricien'] . "</span> <br/>";
                                        //     }
                                        // }

                                        /* Si le véhicule réceptionné en question à été attribué seulement au chef mécanicien 
                                        et a déja fait l'objet de diagnostic mécanique */
                                        // if (isset($row['attribution_mecanicien']) && !isset($row['attribution_electricien'])) {
                                        //     if ($row['statut_diagnostic_mecanique'] == 1) {
                                        //         echo $row['mecano_name'] . ' : ' . $row['attribution_mecanicien'];
                                        //     }
                                        // }
                                        /* Si le véhicule réceptionné en question à été attribué seulement au chef électricien 
                                         et a déja fait l'objet de diagnostic électrique */
                                        // if (isset($row['attribution_electricien']) && !isset($row['attribution_mecanicien'])) {
                                        //     if ($row['statut_diagnostic_electrique'] == 1) {
                                        //         echo $row['electro_name'] . ' : ' . $row['attribution_electricien'];
                                        //     }
                                        // }

                                        /* Si le véhicule réceptionné en question à été attribué à la fois aux chef électricien et
                                        mécanicien et n'a pas encore fait l'objet de diagnostic électrique, ni mécanique
                                        */
                                        // if (isset($row['attribution_electricien']) && isset($row['attribution_mecanicien'])) {

                                        //     if (!isset($row['statut_diagnostic_electrique']) && !isset($row['statut_diagnostic_mecanique'])) {
                                        //         echo "<span class='label label-default'>En cours d'attribution aux chefs mécaniciens et électriciens</span> <br/>";
                                        //     }
                                        // }

                                        /* Si le véhicule réceptionné en question à été attribué à la fois aux chef électricien et
                                        mécanicien et a déja fait l'objet de diagnostic électrique
                                        */
                                        // if (isset($row['attribution_electricien']) && isset($row['attribution_electricien'])) {

                                        //     if ($row['statut_diagnostic_electrique'] == 1) {
                                        //         echo $row['electro_name'] . ' : ' . $row['attribution_electricien'];
                                        //     }
                                        // }

                                        /* Si le véhicule réceptionné en question à été attribué à la fois aux chef électricien et
                                        mécanicien et a déja fait l'objet de diagnostic mécanique
                                        */
                                        // if (isset($row['attribution_electricien']) && isset($row['attribution_electricien'])) {

                                        //     if ($row['statut_diagnostic_mecanique'] == 1) {
                                        //         echo $row['mecano_name'] . ' : ' . $row['attribution_mecanicien'];
                                        //     }
                                        // }

                                        /* Si le véhicule réceptionné en question à été attribué à la fois aux chef électricien et
                                        mécanicien et a déja fait l'objet de diagnostic mécanique
                                        */
                                        // if (isset($row['attribution_electricien']) && isset($row['attribution_electricien'])) {

                                        //     if ($row['statut_diagnostic_mecanique'] == 1 && $row['statut_diagnostic_electrique'] == 1) {
                                        //         echo $row['mecano_name'] . ' : ' . $row['attribution_mecanicien']."\n";
                                        //         echo $row['electro_name'] . ' : ' . $row['attribution_electricien'];
                                        //     }
                                        // }

                                        ?>
                                    <!-- </td> -->
                                    <td><?php

                                        if (!isset($row['statut_diagnostic_mecanique'])) {
                                            echo "";
                                        } else if ($row['statut_diagnostic_mecanique'] == null) {
                                            echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                                        } else if ($row['statut_diagnostic_mecanique'] == 1) {
                                            echo "<span class='label label-success'>Diagnostic éffectué</span> <br/>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php

                                        if (!isset($row['statut_diagnostic_electrique'])) {
                                            echo "";
                                        } else if ($row['statut_diagnostic_electrique'] == null) {
                                            echo "<span class='label label-default'>En attente de diagnostic</span> <br/>";
                                        } else if ($row['statut_diagnostic_electrique'] == 1) {
                                            echo "<span class='label label-success'>Diagnostic éffectué</span> <br/>";
                                        }
                                        ?>
                                    </td>
                                    <td>

                                        <a class="btn btn-primary" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/pj_car_recep_list.php?car_recep_id=<?php echo $row['car_id']; ?>" data-original-title="Afficher la liste des pièces jointes à la réception du véhicule"><i class="fa fa-paperclip"></i></a>
                                        <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                                        <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc_gene.php?car_id=<?php echo $row['car_id']; ?>&login_type=<?php echo $_SESSION['login_type']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
                                        <?php

                                        // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                                        $rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $row['vehi_diag_id']);

                                        // S'il y a des enregistrements correspondant à cet id existant déja en BDD
                                        // On affiche l'icone de la fiche
                                        if (!empty($rows)) { ?>
                                            <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule"><i class="fa fa-file-text-o"></i></a>
                                        <?php }

                                        // Si le client et le receptionniste ont signé au dépot la fiche de reception du véhicule
                                        if (isset($row['sign_cli_depot']) && isset($row['sign_recep_depot'])) { ?>

                                            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attribuer le véhicule réceptionné à un mécanicien ou un électricien pour diagnostic"><i class="fa fa-user"></i></a>

                                        <?php }

                                        // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                                        $rowsGetStatutEtatVehiSortie = $wms->getStatutEtatVehiSortie($link, $row['car_id']);

                                        if (!empty($rowsGetStatutEtatVehiSortie)) { ?>
                                            <a class="btn btn-primary" style="background-color:#021254;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/etat_vehicule_sortie.php?cid=<?php echo $row['car_id']; ?>" data-original-title="Définir l'état du véhicule à la sortie"><i class="fa fa-car"></i></a>
                                        <?php } ?>

                                        <a class="btn btn-success" style="background-color:#16a085;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/photo_car_avant_work.php?car_recep_id=<?php echo $row['car_id']; ?>&car_id=<?php echo $row['add_car_id']; ?>" data-original-title="Voir les photos du véhicule avant réparation"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-success" style="background-color:#2e86c1;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/photo_car_apres_work.php?car_recep_id=<?php echo $row['car_id']; ?>&car_id=<?php echo $row['add_car_id']; ?>" data-original-title="Voir les photos du véhicule après réparation"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-success" style="background-color:#48c9b0;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/photo_car_piece_change.php?car_recep_id=<?php echo $row['car_id']; ?>&car_id=<?php echo $row['add_car_id']; ?>" data-original-title="Voir les photos des pièces changées"><i class="fa fa-eye"></i></a>
                                        <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->

                                        <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attibuer à un mécanicien"><i class="fa fa-eye"></i></a> -->
                                        <!-- <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> -->
                                        <!-- <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> -->
                                    </td>
                                </tr>
                                <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <a class="close" data-dismiss="modal">×</a>
                                                <h3>Formulaire d'attribution du véhicule réceptionné</h3>
                                            </div>

                                            <form id="avanceSalForm" name="avance_sal" role="form" enctype="multipart/form-data" method="POST" action="<?php echo WEB_URL; ?>diagnostic/attribution_mecanicien_traitement.php">

                                                <div class="modal-body">

                                                    <div class="form-group">
                                                        <label for="txtCName"> Sélectionner un mécanicien ou un électricien :</label>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <select required class='form-control' id="mecanicienList" name="mecanicienList">
                                                                    <option selected value="">--Veuillez saisir ou sélectionner un mécanicien ou un électricien--</option>
                                                                    <!-- <option value="chef mecanicien">Chef mécanicien</option>
                                                                    <option value="chef electricien">Chef électricien</option> -->
                                                                    <option value="chef mecanicien et electricien">Chef mécanicien et électricien</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <input type="hidden" value="<?php echo $row['mech_id'] ?>" name="mech_id" />
                                                    <input type="hidden" value="<?php echo $row['add_car_id'] ?>" name="car_id" />
                                                    <input type="hidden" value="<?php echo $row['car_id'] ?>" name="reception_id" />
                                                    <input type="hidden" value="<?php echo $row['num_matricule'] ?>" name="imma_vehi" />
                                                    <!-- <input type="hidden" value="<?php echo $_SESSION['objLogin']['email'] ?>" name="admin_ges_tel" /> -->
                                                    <input type="hidden" value="<?php echo $_SESSION['objLogin']['telephone'] ?>" name="admin_ges_tel" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                                    <button type="submit" class="btn btn-success" id="submit">Valider</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            <?php }
                            mysql_close($link); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script type="text/javascript">
        function deleteCustomer(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette voiture ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>repaircar/carlist.php?id=' + Id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(8000);
                $("#you").hide(8000);
                $("#youyou").hide(8000);
                $("#his").hide(8000);
                $("#us").hide(8000);
                $("#usus").hide(8000);
                $("#hishis").hide(8000);
                $("#his_2").hide(8000);
                $("#you_2").hide(8000);
                $("#you_3").hide(8000);
            }, 8000);
        });
    </script>
    <?php include('../footer.php'); ?>