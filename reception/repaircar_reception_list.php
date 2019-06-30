<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "La voiture a été supprimée de la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'etat_vehi_sortie') {
    $addinfo = 'block';
    $msg = "L'état du véhicule à la sortie à été défini avec succès !";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "La voiture receptionnée a été modifiée";
}
if (isset($_GET['m']) && $_GET['m'] == 'attribution') {

    if (isset($_GET['car_id']) && isset($_GET['mecanicien_id'])) {

        $addinfo = 'block';
        // $msg = "La fiche de réception du véhicule d'identifiant " . $_GET['car_id'] . " à été attribuée au mécanicien d'identifiant " . $_GET['mecanicien_id'];
        $msg = "La fiche de réception du véhicule " . $_GET['marque'] . ' ' . $_GET['modele'] . ' ' . $_GET['imma']. " à été attribuée au mécanicien " . $_GET['mech_name'];
    }
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Réception de véhicule - Liste des véhicules réceptionnés</h1>
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
            <div align="right" style="margin-bottom:1%;"><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception.php" data-original-title="Créer un nouveau formulaire de réception de véhicule"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a></div>
            <div class="box box-success">
                <div class="box-header">
                    <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
                    <h3 class="box-title"><i class="fa fa-list"></i> Liste des voitures réceptionnées</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>ID Reparation</th>
                                <th>Immatriculation</th>
                                <th>Client</th>
                                <th>Date reception</th>
                                <th>Date exp. assur</th>
                                <th>Date exp. vis. tech.</th>
                                <!-- <th>Attribué à</th> -->
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
                                    <td><span class="label label-success"><?php echo $row['repair_car_id']; ?></span></td>
                                    <td><?php echo $row['num_matricule']; ?></td>
                                    <td><?php echo $row['c_name']; ?></td>
                                    <td><?php echo $row['add_date_recep_vehi']; ?></td>
                                    <td><?php echo $row['add_date_assurance']; ?></td>
                                    <td><?php echo $row['add_date_visitetech']; ?></td>
                                    <!-- <td><?php echo $row['m_name']; ?></td> -->
                                    <td>

                                        <!-- <a class="btn btn-info" style="background-color:purple;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_diagnostic.php?add_car_id=<?php echo $row['add_car_id']; ?>&car_id=<?php echo $row['car_id']; ?>" data-original-title="Créer le formulaire de diagnostic du véhicule"><i class="fa fa-plus"></i></a> -->
                                        <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_doc.php?car_id=<?php echo $row['car_id']; ?>" data-original-title="Fiche de reception du véhicule"><i class="fa fa-file-text-o"></i></a>
                                        <?php

                                        // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                                        $rows = $wms->getComparPrixPieceRechangeInfoByDiagId($link, $row['vehi_diag_id']);

                                        // S'il y a des enregistrements correspondant à cet id existant déja en BDD
                                        // On affiche l'icone de la fiche
                                        if (!empty($rows)) { ?>
                                            <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/repaircar_diagnostic_doc.php?vehi_diag_id=<?php echo $row['vehi_diag_id']; ?>" data-original-title="Consulter la fiche de diagnostic du véhicule"><i class="fa fa-file-text-o"></i></a>
                                        <?php }
                                        
                                        // Si le client et le receptionniste ont signé au dépot la fiche de reception du véhicule
                                        if (isset($row['sign_cli_depot']) && isset($row['sign_recep_depot'])) {?>

                                            <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attibuer à un mécanicien ou un électricien"><i class="fa fa-user"></i></a>
                                            
                                        <?php } 
                                        
                                        // On récupère l'id du diagnostic du véhicule réceptionné à faire réparer 
                                        $rowsGetStatutEtatVehiSortie = $wms->getStatutEtatVehiSortie($link, $row['car_id']); 
                                        
                                        if (!empty($rowsGetStatutEtatVehiSortie)) {?>
                                        <a class="btn btn-primary" style="background-color:#021254;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/etat_vehicule_sortie.php?cid=<?php echo $row['car_id']; ?>" data-original-title="Définir l'état du véhicule à la sortie"><i class="fa fa-car"></i></a>
                                        <?php } ?>

                                        <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="Attibuer à un mécanicien"><i class="fa fa-eye"></i></a> -->
                                        <!-- <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> -->
                                        <!-- <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> -->
                                        <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header orange_header">
                                                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                                                        <h3 class="modal-title">Attribution du véhicule réceptionné</h3>
                                                    </div>
                                                    <!-- <div class="modal-body model_view" align="center">&nbsp;
                                                                                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image; ?>" /></div>
                                                                                        <div class="model_title"><?php echo $row['car_name']; ?></div>
                                                                                        <div style="color:#fff;font-size:15px;font-weight:bold;">Facture
                                                                                            No: <?php echo $row['repair_car_id']; ?></div>
                                                                                    </div> -->
                                                    <div class="modal-body">
                                                        <h3 style="text-decoration:underline;">Sélection du responsable approprié</h3>
                                                        <div class="row" style="margin: 0 auto;">

                                                            <form action="../diagnostic/attribution_mecanicien_traitement.php" method="post">
                                                                <div class="row">
                                                                    <div class="form-group col-md-8">
                                                                        <!-- <label for="type_client"><span style="color:red;">*</span> Type de client :</label> -->
                                                                        <select required class='form-control' id="mecanicienList" name="mecanicienList">
                                                                            <option selected value="">--Veuillez saisir ou sélectionner le responsable approprié--</option>
                                                                            <?php
                                                                            $mecanicien_list = $wms->getAllMechanicsListByTitle($link);
                                                                            foreach ($mecanicien_list as $mrow) {
                                                                                // if ($cus_id > 0 && $cus_id == $mrow['customer_id']) {
                                                                                echo '<option value="' . $mrow['usr_id'] . '">' . $mrow['usr_name'] .' - '. $mrow['usr_type'] . '</option>';
                                                                                // } else {
                                                                                // echo '<option value="' . $mrow['customer_id'] . '">' . $mrow['c_name'] . '</option>';
                                                                                // }
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <button type="submit" class="btn btn-primary">Attribuer</button>
                                                                    </div>

                                                                </div>
                                                               
                                                                <input type="hidden" value="<?php echo $row['add_car_id'] ?>" name="car_id" />
                                                                <input type="hidden" value="<?php echo $row['car_id'] ?>" name="reception_id" />
                                                                <input type="hidden" value="<?php echo $row['num_matricule'] ?>" name="imma_vehi" />
                                                            </form>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
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
                $("#me").hide(300);
                $("#you").hide(200000);
            }, 200000);
        });
    </script>
    <?php include('../footer.php'); ?>