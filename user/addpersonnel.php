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
$title = 'Ajouter un nouveau membre au personnel';
$button_text = "Enregistrer information";
$successful_msg = "Ajouter un personnel avec succès";
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

/*#############################################################*/
if (isset($_POST) && !empty($_POST)) { //Si les données ont été soumis à partir du formulaire

    // var_dump($_POST);
    // die();

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
        $per_name = $row['per_name'];
        $per_telephone = $row['per_telephone'];
        $per_service = $row['per_service'];
        $per_fonction = $row['per_fonction'];
        // if ($row['image'] != '') {
        //     $image_sup = WEB_URL . 'img/upload/' . $row['image'];
        //     $img_track = $row['image'];
        // }
        $hdnid = $_GET['id'];
        $title = 'Modification du personnel';
        $button_text = "Mise à jour";
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
                            <input required type="text" name="telPers" value="<?php echo $per_telephone; ?>" id="telPers" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="foncPers"><span style="color:red;">*</span>Fonction:</label>
                            <input type="text" name="foncPers" value="<?php echo $per_fonction; ?>" id="foncPers" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="servPers"><span style="color:red;">*</span> Service :</label>
                            <select required class='form-control' id="servPers" name="servPers">
                                <option value="">--Sélectionner le type de l'utilisateur--</option>
                                <?php if (isset($per_service) && ($per_service == "reception")) {
                                    echo "<option selected value='" . $per_service . "'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilité</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option value='commercial'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                } elseif (isset($per_service) && ($per_service == "comptabilite")) {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option selected value='" . $per_service . "'>Comptabilite</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option value='commercial'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                } elseif (isset($per_service) && ($per_service == "mecanique")) {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilite</option>";
                                    echo "<option selected value='" . $per_service . "'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option value='commercial'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                } elseif (isset($per_service) && ($per_service == "electrique")) {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilite</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option selected value='" . $per_service . "'>Electrique</option>";
                                    echo "<option value='commercial'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                } elseif (isset($per_service) && ($per_service == "commercial")) {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilite</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option selected value='" . $per_service . "'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                } elseif (isset($per_service) && ($per_service == "commercial")) {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilite</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option value='comercial'>Commercial</option>";
                                    echo "<option selected value='" . $per_service . "'>Direction/option>";
                                } else {
                                    echo "<option value='reception'>Réception</option>";
                                    echo "<option value='comptabilite'>Comptabilite</option>";
                                    echo "<option value='mecanique'>Mécanique</option>";
                                    echo "<option value='electrique'>Electrique</option>";
                                    echo "<option value='commercial'>Commercial</option>";
                                    echo "<option value='direction'>Direction</option>";
                                }
                                ?>
                            </select>
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
        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>

    <?php include('../footer.php'); ?>