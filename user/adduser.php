<?php
include('../header.php');
$hdnid = "0";
$button_text = "Enregistrer information";
$usr_name = "";
$usr_email = "";
$usr_password = "";
$usr_type = "";
$usr_image = "";

// Importation de l'autoload de composer
// require ROOT_PATH.'/vendor/autoload.php';

if (isset($_POST) && !empty($_POST)) {
    $image_url = uploadImage();
    if (empty($image_url)) {
        $image_url = $_POST['img_exist'];
    }

    // échappement des espaces blancs et des caractères spéciaux lors de la définition du nom de l'utilisateur
    $_POST['txtUserName'] = mysql_real_escape_string(trim($_POST['txtUserName']));

    // échappement des espaces blancs et des caractères spéciaux lors de la définition du mot de passe de l'utilisateur
    $_POST['txtUserPassword'] = mysql_real_escape_string(trim($_POST['txtUserPassword']));

    // Récupération de la valeur brute du mot de passe
    $plainPassword = $_POST['txtUserPassword'];

    // Génération d'une valeur de sel aléatoire
    // $salt = substr(md5(time()), 0, 23);

    // Génération d'une valeur du sel basée sur le mot de passe brute de l'utilisateur
    $salt = "53fYcjF!Vq&bDw" . $plainPassword . "&MuURm@86BsUtD";

    // Hashage du mot de passe de l'utilisateur
    $hashed = hash('sha512', $salt);

    // Instanciaton de l'encoder
    // $encoder = new \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder();

    // Traitement du mot de passe encodé
    // $password = $encoder->encodePassword($plainPassword, $salt);

    // Récupération et enregistrement du mot de passe encodé en base de données
    // $_POST['txtUserPassword'] = $hashed;

    if ($_POST['user_type'] == "administrateur") {
// Méhode à exécuter lorsque l'on veut créer un administrateur

        // var_dump($_POST);
        // die('je suis dans admin');

        $wms->createAdminUser($link, $_POST, $image_url);
    } else if ($_POST['user_type'] == "mecanicien" OR $_POST['user_type'] == "electricien" OR $_POST['user_type'] == "chef mecanicien" OR $_POST['user_type'] == "chef electricien") {

        // die('je suis dans mech');
        // Méhode à exécuter lorsque l'on veut créer un mécanicien ou un électricien
        $wms->createMechUser($link, $_POST, $image_url);
    } else {

        $wms->saveUpdateUserInformation($link, $_POST, $image_url);
    }

    // On fait une redirection
    if ((int) $_POST['user_id'] > 0) {
        $url = WEB_URL . 'user/userlist.php?m=up';
        header("Location: $url");
    } else {
        $url = WEB_URL . 'user/userlist.php?m=add';
        header("Location: $url");
    }
    exit();
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
            move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/' . $newfilename);
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

$image = WEB_URL . 'img/no_image.jpg';
// if (!empty($_SESSION['objLogin']['image'])) {
//     $image = WEB_URL . 'img/' . $_SESSION['objLogin']['image'];
//     $img_track = $_SESSION['objLogin']['image'];
// }

if (isset($_GET['id']) && $_GET['id'] != '') {
    //view
    $row = $wms->getUserInfoByUserId($link, $_GET['id']);
    if (!empty($row)) {
        $usr_name = $row['usr_name'];
        $usr_email = $row['usr_email'];
        $usr_password = $row['usr_password'];
        $usr_type = $row['usr_type'];
        $usr_image = $row['usr_image'];
        // if ($row['image'] != '') {
        //     $image_sup = WEB_URL . 'img/upload/' . $row['image'];
        //     $img_track = $row['image'];
        // }
        $hdnid = $_GET['id'];
        $title = 'Modification de l\'utilisateur';
        $button_text = "Mise à jour";
        $successful_msg = "Modification de l'utilisateur effectuée avec succès";
        $form_url = WEB_URL . "user/adduser.php?id=" . $_GET['id'];
    }

    //mysql_close($link);
}

?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-user"></i> Formulaire de création d'un utilisateur </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
        <li class="active">Création d'un utilisateur</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">

            <div class="box box-success">

                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="txtUserName"><span style="color:red;">*</span> Nom:</label>
                            <input type="text" name="txtUserName" value="<?php echo $usr_name ?>" id="txtUserName" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="txtEmail"><span style="color:red;">*</span>N° téléphone :<span style="color:red;"> (le numéro de téléphone est le login)</span></label>
                            <input type="text" maxlength="10" name="txtUserEmail" value="<?php echo $usr_email ?>" id="txtUserEmail" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="txtPassword"><span style="color:red;">*</span>Mot de passe :</label>
                            <input type="password" name="txtUserPassword" value="<?php echo $usr_password ?>" id="txtUserPassword" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label for="user_type"><span style="color:red;">*</span> Type de l'utilisateur :</label>
                            <select required class='form-control' id="user_type" name="user_type">
                                <option value="">--Sélectionner le type de l'utilisateur--</option>
                                <?php if (isset($usr_type) && ($usr_type == "receptionniste")) {
                                    echo "<option selected value='" . $usr_type . "'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "comptable")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option selected value='" . $usr_type . "'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "mecanicien")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option selected value='" . $usr_type . "'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "electricien")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option selected value='" . $usr_type . "'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "chef mecanicien")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option selected value='" . $usr_type . "'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "chef electricien")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option selected value='" . $usr_type . "'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "service client")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option selected value='" . $usr_type . "'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                } elseif (isset($usr_type) && ($usr_type == "administrateur")) {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option selected value='" . $usr_type . "'>Administrateur</option>";
                                } else {
                                    echo "<option value='receptionniste'>Réceptioniste</option>";
                                    echo "<option value='comptable'>Comptable</option>";
                                    echo "<option value='mecanicien'>Mécanicien</option>";
                                    echo "<option value='electricien'>Electricien</option>";
                                    echo "<option value='chef mecanicien'>Chef mécanicien</option>";
                                    echo "<option value='chef electricien'>Chef électricien</option>";
                                    echo "<option value='service client'>Service client</option>";
                                    echo "<option value='administrateur'>Administrateur</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <!-- <div class="form-group">
                            <label for="Prsnttxtarea">Preview :</label>
                            <img class="form-control" src="<?php echo $image; ?>" style="height:100px;width:100px;" id="output" />
                            <input type="hidden" name="img_exist" value="" />
                        </div> -->

                        <!-- <div class="form-group"> <span class="btn btn-file btn btn-success">Uploader une image
                                <input type="file" name="uploaded_file" onchange="loadFile(event)" />
                            </span> </div> -->
                    </div>
                    <div class="pull-right">
                        <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                            <?php echo $button_text; ?></button>&emsp;
                        <!-- <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/receptionnistelist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a> -->
                    </div>
                    <input type="hidden" value="<?php echo $hdnid; ?>" name="usr_id" />
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <!-- /.row -->
    <!-- <script type="text/javascript">
        function validateMe() {
            if ($("#txtUserName").val() == '') {
                alert("User Name est Obligatoire !!!");
                $("#txtUserName").focus();
                return false;
            } else if ($("#txtEmail").val() == '') {
                alert("Valid Email Required !!!");
                $("#txtEmail").focus();
                return false;
            } else if ($("#txtPassword").val() == '') {
                alert("Password Required !!!");
                $("#txtPassword").focus();
                return false;
            } else {
                return true;
            }
        }
    </script> -->
    <?php include('../footer.php'); ?>