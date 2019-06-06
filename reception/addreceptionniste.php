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
$title = 'Ajouter un nouveau réceptionniste';
$button_text = "Enregistrer information";
$successful_msg = "Ajouter un réceptionniste avec succès";
$form_url = WEB_URL . "reception/addreceptionniste.php";
$id = "";
$hdnid = "0";
$image_sup = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$manufacturerInfo = array();
$wow = false;


/*#############################################################*/
if (isset($_POST['txtSName'])) {

    // var_dump($_POST);
    // die();

    // $image_url = uploadImage();
    // if (empty($image_url)) {
    //     $image_url = $_POST['img_exist'];
    // }
    $wms->saveUpdateReceptionnisteInformation($link, $_POST, $image_url);
    if ((int)$_POST['reception_id'] > 0) {
        $url = WEB_URL . 'reception/receptionnistelist.php?m=up';
        header("Location: $url");
    } else {
        $url = WEB_URL . 'reception/receptionnistelist.php?m=add';
        header("Location: $url");
    }
    exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    //view
    $row = $wms->getReceptonnisteInfoByReceptonnistId($link, $_GET['id']);
    if (!empty($row)) {
        $r_name = $row['r_name'];
        $r_email = $row['r_email'];
        $r_password = $row['r_password'];
        // if ($row['image'] != '') {
        //     $image_sup = WEB_URL . 'img/upload/' . $row['image'];
        //     $img_track = $row['image'];
        // }
        $hdnid = $_GET['id'];
        $title = 'Modification du réceptionniste';
        $button_text = "Mise à jour";
        $successful_msg = "Modification du réceptionniste effectuée avec succès";
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
        <li class="active">réceptionniste</li>
        <li class="active">Ajouter un réceptionniste</li>
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

                <form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtSName"><span style="color:red;">*</span> Nom du réceptionniste :</label>
                            <input required type="text" name="txtSName" value="<?php echo $r_name; ?>" id="txtSName" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtSEmail"><span style="color:red;">*</span> Email :</label>
                            <input required type="text" name="txtSEmail" value="<?php echo $r_email; ?>" id="txtSEmail" class="form-control" />
                        </div>
                        <div class="form-group">
                            <label for="txtSPassword"><span style="color:red;">*</span> Mot de passe :</label>
                            <input required type="password" name="txtSPassword" value="<?php echo $r_password; ?>" id="txtSPassword" class="form-control" />
                        </div>
                        <!-- <div class="form-group">
                            <label for="Prsnttxtarea">Image :</label>
                            <img class="form-control" src="<?php echo $image_sup; ?>" style="height:100px;width:100px;" id="output" />
                            <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
                        </div>
                        <div class="form-group"> <span class="btn btn-file btn btn-primary">Upload Image
                                <input type="file" name="uploaded_file" onchange="loadFile(event)" />
                            </span> </div> -->
                    </div>
                    <input type="hidden" value="<?php echo $hdnid; ?>" name="reception_id" />
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                            <?php echo $button_text; ?></button>&emsp;
                        <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/receptionnistelist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a> </div>
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