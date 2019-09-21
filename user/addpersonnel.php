<?php
include('../header.php');
$success = "none";
$r_name = '';
$r_email = '';
$s_address = '';
$ddlCountry = 0;
$ddlState = 0;
$phone_number = '';
$post_code = '';
$website_url = '';
$s_fax = '';
$r_password = '';
$title = 'Formulaire de renseignement du personnel administratif';
$button_text = "Enregistrer informations";
$successful_msg = "Employé ajouté avec avec succès";
// $form_url = WEB_URL . "reception/addreceptionniste.php";
$id = "";
$hdnid = "0";
$image_sup = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$manufacturerInfo = array();
$wow = false;

$per_name = "";
$per_telephone = "";
$per_service = "";
$per_fonction = "";
$per_date_naiss = "";
$per_lieu_naiss = "";
$per_lieu_ori = "";
$per_num_cni = "";
$per_etat_civile = "";
$per_nom_conjoint = "";
$per_adrs = "";
$per_nom_pere = "";
$per_nom_mere = "";
$per_sal = "";
$per_type_contrat = "";
$per_mat = "";
$per_date_emb = "";

// Déclaration et initialisation du compteur de boucle
$row = 0;
$i = 0;
$perso_data = array();

/*#############################################################*/
if (isset($_POST) && !empty($_POST)) { //Si les données ont été soumis à partir du formulaire

    // var_dump($_POST);
    // die();

    // Echappement des caractères spéciaux

    // Remarque sur la voiture à son arrivée
    if (!empty($_POST['txtPersName'])) {
        $_POST['txtPersName'] = mysql_real_escape_string($_POST['txtPersName']);
    }

    if (!empty($_POST['telPers'])) {
        $_POST['telPers'] = mysql_real_escape_string($_POST['telPers']);
    }

    if (!empty($_POST['foncPers'])) {
        $_POST['foncPers'] = mysql_real_escape_string($_POST['foncPers']);
    }

    if (!empty($_POST['lieuNaisPers'])) {
        $_POST['lieuNaisPers'] = mysql_real_escape_string($_POST['lieuNaisPers']);
    }

    if (!empty($_POST['lieuOriPers'])) {
        $_POST['lieuOriPers'] = mysql_real_escape_string($_POST['lieuOriPers']);
    }

    if (!empty($_POST['etatcivilePers'])) {
        $_POST['etatcivilePers'] = mysql_real_escape_string($_POST['etatcivilePers']);
    }

    if (!empty($_POST['nomconjointPers'])) {
        $_POST['nomconjointPers'] = mysql_real_escape_string($_POST['nomconjointPers']);
    }

    if (!empty($_POST['adrsPers'])) {
        $_POST['adrsPers'] = mysql_real_escape_string($_POST['adrsPers']);
    }

    if (!empty($_POST['nomperePers'])) {
        $_POST['nomperePers'] = mysql_real_escape_string($_POST['nomperePers']);
    }

    if (!empty($_POST['nomerePers'])) {
        $_POST['nomerePers'] = mysql_real_escape_string($_POST['nomerePers']);
    }

    $_POST['salPers'] = (int)$_POST['salPers'];

    // Linéarisation de l'array des données du personnel pour le stocker en base de données
    // $_POST['perso_data'] = serialize($_POST['perso_data']);
    $_POST['perso_data'] = json_encode($_POST['perso_data'], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

    // On persiste les données en BDD
    $wms->saveUpdatePersonnelInformation($link, $_POST);
    if ((int)$_POST['personnel_id'] > 0) {
        $url = WEB_URL . 'user/listepersonnel.php?m=up';
        header("Location: $url");
    } else {
        $url = WEB_URL . 'user/listepersonnel.php?m=add';
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
        $button_text = "Modifier";
        $successful_msg = "Modification du personnel effectuée avec succès";
        $form_url = WEB_URL . "reception/addreceptionniste.php?id=" . $_GET['id'];
    }

    //mysql_close($link);
}

//for image upload
function uploadImage()
{
    if ((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
        $filename = basename($_FILES['uploaded_file']['name']);
        $ext = substr($filename, strrpos($filename, '.') + 1);
        if (($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')) {
            $temp = explode(".", $_FILES["uploaded_file"]["name"]);
            $newfilename = NewGuid() . '.' . end($temp);
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
            return $newfilename;
        } else {
            return '';
        }
    }
    return '';
}
function NewGuid()
{
    $s = strtoupper(md5(uniqid(rand(), true)));
    $guidText =
        substr($s, 0, 8) . '-' .
        substr($s, 8, 4) . '-' .
        substr($s, 12, 4) . '-' .
        substr($s, 16, 4) . '-' .
        substr($s, 20);
    return $guidText;
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <?php echo $title; ?> </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">personnel</li>
        <li class="active">Ajouter un personnel</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">

            <!-- <div class="box box-success" id="box_model">
          
        </div> -->
            <div class="box box-success">

                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtPersName"><span style="color:red;">*</span> Nom et prénom :</label>
                            <input required type="text" name="txtPersName" value="<?php echo $per_name; ?>" id="txtPersName" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="telPers"><span style="color:red;">*</span> Téléphone:</label>
                            <input required type="text" maxlength="10" name="telPers" value="<?php echo $per_telephone; ?>" id="telPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="foncPers"><span style="color:red;">*</span>Fonction:</label>
                            <input required type="text" name="foncPers" value="<?php echo $per_fonction; ?>" id="foncPers" class="form-control" />
                        </div>

                        <div class="form-group">
                            <label for="salPers">Salaire:</label>
                            <input type="number" name="salPers" value="<?php echo $per_sal; ?>" id="salPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="typctrPers">Type de contrat:</label>
                            <input type="text" name="typctrPers" value="<?php echo $per_type_contrat; ?>" id="typctrPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="matPers">N° matricule:</label>
                            <input type="text" name="matPers" value="<?php echo $per_mat; ?>" id="matPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="datembPers">Date d'embauche:</label>
                            <input type="text" name="datembPers" value="<?php echo $per_date_emb; ?>" id="datembPers" class="form-control datepicker" />
                        </div>

                        <div class="form-group">
                            <label for="txtPersName"> Date de naissance:</label>
                            <input type="text" name="dateNaisPers" value="<?php echo $per_date_naiss; ?>" id="dateNaisPers" class="form-control datepicker" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Lieu de naissance :</label>
                            <input type="text" name="lieuNaisPers" value="<?php echo $per_lieu_naiss; ?>" id="lieuNaisPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Lieu d'origine :</label>
                            <input type="text" name="lieuOriPers" value="<?php echo $per_lieu_ori; ?>" id="lieuOriPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Numéro de la CNI :</label>
                            <input type="text" name="numcniPers" value="<?php echo $per_num_cni; ?>" id="numcniPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Etat civile :</label>
                            <input type="text" name="etatcivilePers" value="<?php echo $per_etat_civile; ?>" id="etatcivilePers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Nom et prénom du conjoint :</label>
                            <input type="text" name="nomconjointPers" value="<?php echo $per_nom_conjoint; ?>" id="nomconjointPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Adresse complète :</label>
                            <input type="text" name="adrsPers" value="<?php echo $per_adrs; ?>" id="adrsPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Nom et prénom du père :</label>
                            <input type="text" name="nomperePers" value="<?php echo $per_nom_pere; ?>" id="nomperePers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtPersName"> Nom et prénom de la mère :</label>
                            <input type="text" name="nomerePers" value="<?php echo $per_nom_mere; ?>" id="nomerePers" class="form-control" />
                        </div>
                        <div class="table-responsive">
                            <table id="labour_table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Enfant</th>
                                        <th>Nom</th>
                                        <th>Prenom</th>
                                        <th>Date de naissance</th>
                                        <th>&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($perso_data as $perso) { ?>
                                        <tr id="estimate-row<?php echo $row; ?>">
                                            <td class="text-right"><input id="perso_enfant_<?php echo $row; ?>" type="text" value="" name="perso_data[<?php echo $row; ?>][enfant]" class="form-control" /></td>
                                            <td class="text-right"><input id="perso_nom_enfant_<?php echo $row; ?>" type="text" value="" name="perso_data[<?php echo $row; ?>][perso_nom_enfant]" class="form-control" /></td>
                                            <td class="text-right"><input id="perso_prenom_enfant_<?php echo $row; ?>" type="text" value="" name="perso_data[<?php echo $row; ?>][perso_prenom_enfant]" class="form-control" /></td>
                                            <td class="text-right"><input id="perso_datenaiss_enfant_<?php echo $row; ?>" type="text" name="perso_data[<?php echo $row; ?>][perso_datenaiss_enfant]" value="" class="form-control" /></td>
                                            <td class="text-left"><button type="button" onclick="$('#estimate-row<?php echo $row; ?>').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                                        </tr>
                                        <?php $row++;
                                    } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4"></td>
                                        <td class="text-left"><button type="button" onclick="addEstimate();" data-toggle="tooltip" title="Ajouter une entrée" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $hdnid; ?>" name="personnel_id" />
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                            <?php echo $button_text; ?></button>&emsp;
                        <!-- <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/receptionnistelist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a>  -->
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </div>
    </div>
    <!-- /.row -->

    <script type="text/javascript">
        var row = <?php echo $row; ?>;

        function addEstimate() {
            html = '<tr id="estimate-row' + row + '">';
            html += '  <td class="text-right"><input id="perso_enfant_' + row + '" type="text" name="perso_data[' + row + '][enfant]" class="form-control"></td>';
            html += '  <td class="text-right"><input id="perso_nom_enfant_' + row + '" type="text" name="perso_data[' + row + '][perso_nom_enfant]" class="form-control"></td>';
            html += '  <td class="text-right"><input type="text" id="perso_prenom_enfant_' + row + '" name="perso_data[' + row + '][perso_prenom_enfant]" value="" class="form-control" /></td>';
            html += '  <td class="text-right"><input id="perso_datenaiss_enfant_' + row + '" type="text" name="perso_data[' + row + '][perso_datenaiss_enfant]" value="" class="form-control" /></td>';
            html += '  <td class="text-left"><button type="button" onclick="$(\'#estimate-row' + row + '\').remove();totalEstCost();" data-toggle="tooltip" title="Supprimer" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
            html += '</tr>';
            $('#labour_table tbody').append(html);
            row++;
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>

    <?php include('../footer.php'); ?>