<?php include('../header.php');
?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Suppression du devis de réparation du véhicule réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Ajout du devis de réparation du véhicule réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'attrib_vehi') {
    $addinfo = 'block';
    $msg = "Le devis N° " . $_GET['devis_simu_id'] . " à bien été attribué à la voiture " . $_GET['car_make'] . " " . $_GET['car_model'] . " " . $_GET['car_imma'];
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "Modification du devis de réparation du véhicule réussi";
}
$hdnid = "0";
$model_post_token = 0;

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Devis - Liste des devis attribués à des véhicules</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des devis de réparation attribués à des véhicules</li>
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
            <div align="right" style="margin-bottom:1%;">
                <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/adddevis.php" data-original-title="Créer un nouveau devis"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a>
            </div>
            <div class="box box-success">
                <!-- <div class="box-header"> -->
                    <!-- <h3 class="box-title"><i class="fa fa-list"></i> Voiture de réparation List</h3> -->
                    <!-- <h3 class="box-title"><i class="fa fa-list"></i> Liste des devis de réparation attribués à des véhicules</h3> -->
                <!-- </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>N° Devis</th>
                                <th>Nom du client</th>
                                <th>Téléphone</th>
                                <th>Immatriculation</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $result = $wms->getAllRepairCarDiagnosticDevisList($link);
                            $result = $wms->getAllRepairCarSimuDevisList($link);

                            // var_dump($result);
                            // die();

                            foreach ($result as $row) {
                                ?>
                                <tr>
                                    <td><span class="label label-success"><?php echo $row['devis_id']; ?></span></td>
                                    <td><?php echo $row['nom_client']; ?></td>
                                    <td><?php echo $row['numero_tel_client']; ?></td>
                                    <td><?php if (isset($row['imma_vehi_client'])) {
                                            echo $row['imma_vehi_client'];
                                        } else {
                                            echo "<p><span class='label label-warning'>Veuillez attribuer le devis à un véhicule</span>";
                                        } ?></td>
                                    <td><?php echo $row['marque_vehi_client']; ?></td>
                                    <td><?php echo $row['model_vehi_client']; ?></td>
                                    <td>

                                        <?php
                                        // On vérifie si ce devis à déja été attribué à un véhicule
                                        $ligne = $wms->getRepairCarSimuDevis($link, $row['devis_id']);

                                        // On vérifie si ce devis est lié à une facture
                                        $ligneFac = $wms->getFactureSimuFromDevisSimu($link, $row['devis_id']);

                                        // Si le devis à déja été attribué à un véhicule,
                                        // On fait apparaitre les autres boutons
                                        if (!empty($ligne)) { ?>
                                            <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/repaircar_simu_devis_doc.php?devis_id=<?php echo $row['devis_id']; ?>" data-original-title="Consulter le devis de réparation du véhicule"><i class="fa fa-file-text-o"></i></a>

                                            <!-- Si le devis n'est lié à aucune facture, on fait apparaitre le bouton
                                                d'association d'un devis à une facture
                                                -->
                                            <?php if (empty($ligneFac)) { ?>
                                                <a class="btn btn-info" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>estimate/repaircar_devis_facture_simu.php?devis_simu_id=<?php echo $row['devis_id']; ?>" data-original-title="Créer une facture à partir de ce devis"><i class="fa fa-plus"></i></a>
                                            <?php } ?>

                                        <?php } else {
                                            // Si aucun véhicule n'est lié à ce devis on affiche le bouton d'attribution du devis à un véhicule
                                            ?>
                                            <a class="btn btn-success" style="background-color:#0029CE;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#devis_vehicule_modal').modal('show');" data-original-title="Attribuer le devis à un véhicule"><i class="fa fa-car"></i></a>
                                        <?php
                                        }
                                        ?>

                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- <div id="devis_vehicule_modal" class="modal fade" role="dialog"> -->
    <div id="devis_vehicule_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal">×</a>
                    <h3>Formulaire d'attribution du devis à un véhicule</h3>
                </div>
                <form id="devisVehiForm" name="devis_vehi" role="form" enctype="multipart/form-data" method="POST" action="adddevis_traitement.php?devis_simu_id=<?php echo $row['devis_id']; ?>">
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="txtCName"> Nom & prénom du client :</label>
                            <!-- <input type="text" name="txtCName" value="" id="txtCName" class="form-control" /> -->
                            <input type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client" onfocus="">
                        </div>

                        <div class="form-group">
                            <label for="txtCName"> Numéro de téléphone du client :</label>
                            <!-- <input type="text" name="txtCName" value="" id="txtCName" class="form-control" /> -->
                            <input type="text" name="princ_tel_client_devis" value="" id="princ_tel_client_devis" class="form-control" placeholder="Saisissez votre numéro de téléphone principal" />
                        </div>

                        <div class="form-group">
                            <label> Immatriculation du véhicule :</label>
                            <!-- <input required type="text" name="immat" id="immat" class="form-control" placeholder="Saisissez l'immatriculation du véhicule"> -->
                            <input required onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule en saisissant son immatriculation">
                        </div>

                        <!-- <div class="form-group" id="marque_modele_vehi_box">
                            <label>Marque et modèle du véhicule :</label>
                            <input readonly onfocus="loadVehiData();" type="text" name="modeleMarqueVehi" id="marque_modele_vehi" class="form-control" value="">
                        </div> -->

                        <div class="form-group">
                            <label>Marque du véhicule :</label>
                            <input type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque de la voiture">
                        </div>

                        <div class="form-group">
                            <label>Modèle du véhicule :</label>
                            <input type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle de la voiture">
                        </div>

                        <!-- <div class="row">
                            <div class="form-group col-md-6">
                                <label for="ddlMake">Marque du véhicule :</label>
                                <select class="form-control" onchange="loadModel(this.value);" name="ddlMake_2" id="ddlMake_2">
                                    <option value=''>--Sélectionnez Marque--</option>
                                    <?php
                                    $make_list = $wms->get_all_make_list($link);
                                    foreach ($make_list as $make) {
                                        echo "<option value='" . $make['make_id'] . "'>" . $make['make_name'] . "</option>";
                                    }

                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ddl_model">Modèle du véhicule :</label>
                                <select class="form-control" onchange="loadYearData(this.value);" name="ddlModel_2" id="ddl_model_2">
                                    <option value=''>--Choisir un modèle--</option>
                                </select>
                            </div>
                        </div> -->

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-success" id="submit">Valider</button>
                    </div>

                    <!-- <input type="hidden" value="" name="txtCPassword" />
                    <input type="hidden" value="" name="tel_wa" />
                    <input type="hidden" value="<?php echo $hdnid; ?>" name="customer_id" /> -->
                    <input type="hidden" value="<?php echo $model_post_token; ?>" name="submit_token" />
                </form>
            </div>
        </div>
    </div>
</section>
<?php
mysql_close($link); ?>
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