<?php
include('../header.php');
$success = "none";
$title = 'Formulaire d\'enregistrement  d\'outils de travail';
$button_text = "Enregistrer informations";
$successful_msg = "Outil ajouté avec succès";
// $form_url = WEB_URL . "reception/addreceptionniste.php";
$id = "";
$hdnid = "0";

// Déclaration et initialisation du compteur de boucle
$lib_tool = "";
$num_tool = "";
$type_tool = "";

/*#############################################################*/
if (isset($_POST) && !empty($_POST)) { //Si les données ont été soumis à partir du formulaire

    // var_dump($_POST);
    // die();

    // Echappement des caractères spéciaux

    // Remarque sur la voiture à son arrivée
    if (!empty($_POST['numTool'])) {
        $_POST['numTool'] = mysql_real_escape_string($_POST['numTool']);
    }

    if (!empty($_POST['libtool'])) {
        $_POST['libtool'] = mysql_real_escape_string($_POST['libTool']);
    }

    if (!empty($_POST['typetool'])) {
        $_POST['typetool'] = mysql_real_escape_string($_POST['typeTool']);
    }

    // On persiste les données en BDD
    $wms->saveUpdateWorkToolInformation($link, $_POST);
    if ((int)$_POST['worktool_id'] > 0) {
        $url = WEB_URL . 'user/listepersonnel.php?m=up_worktool';
        header("Location: $url");
    } else {
        $url = WEB_URL . 'user/listepersonnel.php?m=add_worktool';
        header("Location: $url");
    }
    exit();
}

// if (isset($_GET['id']) && $_GET['id'] != '') {
//     //view
//     $row = $wms->getPersonnelInfoByPersonnelId($link, $_GET['id']);
//     if (!empty($row)) {

//         // var_dump($row);

//         $per_name = $row['per_name'];
//         $per_telephone = $row['per_telephone'];
//         $per_fonction = $row['per_fonction'];
//         $per_date_naiss = $row['per_date_naiss'];
//         $per_lieu_naiss = $row['per_lieu_naiss'];
//         $per_lieu_ori = $row['per_lieu_ori'];
//         $per_num_cni = $row['per_num_cni'];
//         $per_etat_civile = $row['per_etat_civile'];
//         $per_nom_conjoint = $row['per_nom_conjoint'];
//         $per_adrs = $row['per_adrs'];
//         $per_nom_pere = $row['per_nom_pere'];
//         $per_nom_mere = $row['per_nom_mere'];
//         $per_sal = $row['per_sal'];
//         $per_type_contrat = $row['per_type_contrat'];
//         $per_mat = $row['per_mat'];
//         $per_date_emb = $row['per_date_emb'];
//         $perso_data = $row['perso_data'];

//         $hdnid = $_GET['id'];
//         $title = 'Modification du personnel';
//         $button_text = "Mise à jour";
//         $successful_msg = "Modification du personnel effectuée avec succès";
//         $form_url = WEB_URL . "reception/addreceptionniste.php?id=" . $_GET['id'];
//     }

//     //mysql_close($link);
// }

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
        <li class="active">Ajouter un outil de travail</li>
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
                            <label for="txtPersName"><span style="color:red;">*</span> Numéro :</label>
                            <input required type="text" name="numTool" value="<?php echo $num_tool; ?>" id="numTool" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="libTool"><span style="color:red;">*</span> Libellé :</label>
                            <input required type="text" name="libTool" value="<?php echo $lib_tool; ?>" id="libTool" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="libTool"> Type :</label>
                            <input type="text" name="typeTool" value="<?php echo $type_tool; ?>" id="typeTool" class="form-control" />
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo $hdnid; ?>" name="worktool_id" />
                    <input type="hidden" value="<?php echo $_GET['per_id']; ?>" name="personnel_id" />
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

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>

    <?php include('../footer.php'); ?>