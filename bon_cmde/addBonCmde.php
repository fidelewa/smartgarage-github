<?php
include('../header.php');

$button_text = "Enregistrer informations";
$hdnid = "0";

// Création du numéro du bon de commande généré automatiquement
$numboncmde = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

/*#############################################################*/
if (isset($_POST) && !empty($_POST)) { //Si les données ont été soumis à partir du formulaire

    // var_dump($_POST);
    // die();

    // On persiste les données en BDD
    $wms->saveUpdateBonCmdeInfo($link, $_POST);
    if ((int)$_POST['boncmde_id'] > 0) {
        $url = WEB_URL . 'bon_cmde/boncmdeList.php?m=up';
        header("Location: $url");
    } else {
        $url = WEB_URL . 'bon_cmde/boncmdeList.php?m=add';
        header("Location: $url");
    }
    exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    //view
    $row = $wms->getPersonnelInfoByPersonnelId($link, $_GET['id']);
    if (!empty($row)) {

        // var_dump($row);

        $per_name = $row['per_name'];
        $per_telephone = $row['per_telephone'];
        $per_fonction = $row['per_fonction'];
        $per_date_naiss = $row['per_date_naiss'];
        $per_lieu_naiss = $row['per_lieu_naiss'];
        $per_lieu_ori = $row['per_lieu_ori'];
        $per_num_cni = $row['per_num_cni'];
        $per_etat_civile = $row['per_etat_civile'];
        $per_nom_conjoint = $row['per_nom_conjoint'];
        $per_adrs = $row['per_adrs'];
        $per_nom_pere = $row['per_nom_pere'];
        $per_nom_mere = $row['per_nom_mere'];
        $per_sal = $row['per_sal'];
        $per_type_contrat = $row['per_type_contrat'];
        $per_mat = $row['per_mat'];
        $per_date_emb = $row['per_date_emb'];
        $perso_data = $row['perso_data'];

        $hdnid = $_GET['id'];
        $title = 'Modification du personnel';
        $button_text = "Mise à jour";
        $successful_msg = "Modification du personnel effectuée avec succès";
        $form_url = WEB_URL . "reception/addreceptionniste.php?id=" . $_GET['id'];
    }

    //mysql_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire d'enregistrement d'un bon de commande</title>
</head>

<body>
    <section class="content-header">
        <h1>Formulaire d'enregistrement d'un bon de commande
        </h1>
        <!-- <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> véhicule à faire réparer</a></li>
            <li class="active">Ajout de véhicule à faire réparer</li>
        </ol> -->
    </section>

    <div class="container">
        <!-- Main content -->
        <form method="post" enctype="multipart/form-data" id="mainForm" name="mainForm" role="form">
            <section class="content">
                <!-- Full Width boxes (Stat box) -->
                <div class="row">
                    <div class="col-md-12">

                        <div style="margin-bottom:1%;">
                            <!-- <a class="btn btn-success" style="background-color:#0029CE;color:#ffffff;" data-toggle="modal" data-target="#devis_vehicule_modal" title="Attribuer le devis à un véhicule"><i class="fa fa-plus"></i></a> -->
                            <!-- <button class="btn btn-success" type="submit" data-toggle="tooltip" href="javascript:;" data-original-title="<?php echo $button_text; ?>"><i class="fa fa-save"></i></button> &nbsp; -->
                            <!-- <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/customerlist.php" data-original-title="Back"><i class="fa fa-reply"></i></a> </div> -->

                            <div class="box box-success">

                                <div class="box-body">
                                    <div class="form-group col-md-12">
                                        <div class="form-group">
                                            <label for="add_date"> Numéro du bon de commande :</label>
                                            <input readonly type="text" name="numboncmde" value="<?php echo $numboncmde; ?>" id="numboncmde" class="form-control" placeholder="Saisissez le numéro du bon de commande" />
                                        </div>
                                        <div class="form-group">
                                            <label for="add_date"> Code/désignation :</label>
                                            <input type="text" name="codedesiboncmde" value="" id="codedesiboncmde" class="form-control" placeholder="Saisissez le code ou la désignation deu bon de commande" />
                                        </div>
                                        <div class="form-group">
                                            <label for="add_date"> Quantité :</label>
                                            <input type="number" name="qteboncmde" value="" id="qteboncmde" class="form-control" placeholder="Saisissez la quantité" />
                                        </div>
                                        <!-- <div class="form-group">
                                            <label for="add_date"> Prix unitaire HT :</label>
                                            <input type="number" name="prixhtboncmde" value="" id="prixhtboncmde" class="form-control" placeholder="Saisissez le prix unitaire hors taxe" />
                                        </div>
                                        <div class="form-group">
                                            <label for="add_date"> Total HT :</label>
                                            <input type="number" name="tothtboncmde" value="" id="tothtboncmde" class="form-control" placeholder="Saisissez le total hors taxe" />
                                        </div> -->

                                        <div class="form-group">
                                            <label for="assurance_vehi_recep">Fournisseur :</label>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <select class="form-control" name="four" id="four" onchange="loadSupplierEmail(this.value);">
                                                        <option value=''>--Sélectionnez un fournisseur--</option>
                                                        <?php
                                                        $result = $wms->getAllSuppliers($link);
                                                        foreach ($result as $row) {
                                                            echo "<option value='" . $row['supplier_id'] . "'>" . $row['s_name'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
            </section>
            <input type="hidden" value="<?php echo $hdnid; ?>" name="boncmde_id" />
            <div class="pull-right">
                <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                    <?php echo $button_text; ?></button>&emsp;
                <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a> 
            </div>
        </form>
    </div>
</body>

</html>
<?php
include('../footer.php'); ?>