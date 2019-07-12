<?php
include('../header.php');
$success = "none";
$cus_id = 0;
$car_names = '';
$c_name = '';
$c_make = 0;
$c_model = 0;
$c_year = 0;
$c_chasis_no = '';
$vin = '';
$c_registration = '';
$c_note = '';
$c_add_date = date_format(date_create('now'), 'd/m/Y');


$car_pneu_av = '';
$car_gente_ar = '';
$car_pneu_ar = '';
$car_gente_av = '';
$add_date_visitetech = date_format(date_create('now'), 'd/m/Y');
$add_date_assurance  = date_format(date_create('now'), 'd/m/Y');

$title = "Réception d'un véhicule";
$button_text = "Enregistrer information";
$successful_msg = "Add véhicule de réparation Successfully";
// $form_url = WEB_URL . "repaircar/addcar.php";
$form_url = WEB_URL . "reception/repaircar_traitement.php";
$id = "";
$hdnid = "0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';

// Création de l'identifiant de réparation générée automatiquement
$invoice_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

/*added my*/
$cus_id = 0;
if (isset($_GET['cid']) && (int) $_GET['cid'] > 0) {
    $cus_id = $_GET['cid'];
}

// var_dump($_SESSION);

if (isset($_SESSION['objRecep']) && !empty($_SESSION['objRecep'])) {

    $recep_id = $_SESSION['objRecep']['user_id'];
} else {
    $recep_id = 0;
}

// if (isset($_SESSION['immat']) && !empty($_SESSION['immat'])) { // Quand le paramètre immat existe dans l'url

//     $immat = $_SESSION['immat']; // On affecte directement sa valeur à $vin

//   } else { // Quand le paramètre immat n'existe pas dans l'url
//     $immat = ''; // on affecte la valeur de la variable de session à $vin
//   }

if (isset($_POST['car_names'])) { // Si le nom de la voiture existe et à une valeur
    $image_url = uploadImage();
    if (empty($image_url)) {
        $image_url = $_POST['img_exist'];
    }

    // $wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);
    $wms->saveRecepRepairCarInformation($link, $_POST, $image_url);
    // if((int)$_POST['repair_car'] > 0){
    // 	$url = WEB_URL.'repaircar/carlist.php?m=up';
    // 	header("Location: $url");
    // } else {
    // 	$url = WEB_URL.'repaircar/carlist.php?m=add';
    // 	header("Location: $url");
    // }
    exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    $row = $wms->getRepairCarInfoByRepairCarId($link, $_GET['id']);
    if (!empty($row)) {
        $cus_id = $row['customer_id'];
        $car_names = $row['car_name'];
        $c_make = $row['car_make'];
        $c_model = $row['car_model'];
        $c_year = $row['year'];
        $c_chasis_no = $row['chasis_no'];
        $c_registration = $row['car_reg_no'];
        $vin = $row['VIN'];
        $c_note = $row['note'];
        $c_add_date = $row['added_date'];

        $car_pneu_av = $row['car_pneu_av'];
        $car_gente_ar = $row['car_gente_ar'];
        $car_pneu_ar = $row['car_pneu_ar'];
        $car_gente_av = $row['car_gente_av'];
        $add_date_visitetech = $row['add_date_visitetech'];
        $add_date_assurance  = $row['add_date_assurance'];

        if ($row['image'] != '') {
            $image_cus = WEB_URL . 'img/upload/' . $row['image'];
            $img_track = $row['image'];
        }
        $invoice_id = $row['repair_car_id'];
        $hdnid = $_GET['id'];
        $title = 'Update Car Information';
        $button_text = "Update Information";

        //$successful_msg="Update car Successfully";
        $form_url = WEB_URL . "repaircar/addcar.php?id=" . $_GET['id'];
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


$msg = '';
$addinfo = 'none';
if (isset($_GET['m']) && $_GET['m'] == 'add_car') {
    $addinfo = 'block';
    $msg = "Ajout du véhicule réussi";
}

?>
<!-- Content Header (Page header) -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire de réception d'un véhicule</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
    <!-- <script type="text/javascript" src="<?php echo WEB_URL; ?>reception/repaircar_reception_validation.js"></script> -->
    <!-- <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.2/js/bootstrapValidator.min.js"></script> -->

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            background-color: #f1f1f1;
        }

        #regForm {
            background-color: #ffffff;
            margin: 100px auto;
            font-family: Raleway;
            padding: 40px;
            width: auto;
            height: auto;
            min-width: 300px;
        }

        /* [class*="col-"] {
            border: 1px dotted rgb(0, 0, 0);
            border-radius: 1px;
        } */

        /* h1 {
      text-align: center;
    } */

        /* input,
    select {
      padding: 10px;
      width: 100%;
      font-size: 17px;
      font-family: Raleway;
      border: 1px solid #aaaaaa;
    } */

        /* Mark input boxes that gets an error on validation: */
        input.invalid,
        select.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }

        #prevBtn {
            background-color: #bbbbbb;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #4CAF50;
        }
    </style>

</head>

<body>

    <section class="content-header">
        <h1> Réception de véhicule - Formulaire de réception d'un véhicule</h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
            <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> réception d'un véhicule</a></li>
            <li class="active">réception d'un véhicule</li>
        </ol>
    </section>
    <div class="container">
        <!-- Main content -->
        <form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="regForm">
            <section class="content">

                <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    <?php echo $msg; ?>
                </div>
                <!-- One "tab" for each step in the form: -->
                <div class="tab">

                    <h1 style="text-align:center;">Enregistrement du véhicule</h1>

                    <div class="form-group row">
                        <span style="color:red;"> (si le véhicule n'existe pas encore, veuillez cliquer sur le bouton "+" pour l'enregistrer)</span>
                        <div class="col-md-11">
                            <!-- <input onkeyup="verifImma(this.value);" onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule en saisissant son immatriculation"><span id="immabox"></span> -->
                            <input onkeyup="verifImma(this.value);" onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule existant en saisissant son immatriculation"><span id="immabox"></span>
                        </div>
                        <div class=" col-md-1">
                            <a class="btn btn-success" data-toggle="tooltip" data-original-title="Ajouter une nouvelle voiture" target="_blank" onclick="getImmaValue();"><i class="fa fa-plus"></i></a>
                            <!-- <a class="btn btn-success" type="button" data-toggle="modal" data-target="#myModal" data-original-title="Ajouter un véhicule"><i class="fa fa-plus"></i></a> -->
                        </div>
                    </div>

                    <div class="form-group" id="marque_modele_vehi_box">
                        <input readonly onfocus="loadVehiData();" type="text" name="modeleMarqueVehi" id="marque_modele_vehi" class="form-control" value="">
                    </div>

                    <div class="form-group row">
                        <label for="heure_reception" class="col-md-3 col-form-label">Date de réception du véhicule</label>
                        <div class="col-md-9" style="padding-left:0px;">
                        <input type="text" name="add_date" value="<?php echo $c_add_date; ?>" id="add_date" class="form-control datepicker" placeholder="Saisissez la date de reception du véhicule" />
                        </div>
                    </div>

                    <!-- <p>
                        <select class='form-control' id="immat" name="immat" onchange="loadMarqueModeleVoiture(this.value);">
                            <option value="">--Veuillez saisir ou sélectionner le nom du client--</option>
                            <?php
                            $customer_list = $wms->getAllCustomerList($link);
                            foreach ($customer_list as $crow) {
                                echo '<option value="' . $crow['customer_id'] . '">' . $crow['c_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </p> -->
                    <!-- Immatriculation du véhicule -->
                    <!-- <p>
                        <select class='form-control' onchange="loadMarqueModeleVoiture(this.value);" name="ddlImma" id="ddl_imma">
                            <option selected value="">--Veuillez sélectionner l'immatriculation du véhicule--</option>
                            <?php
                            $result_car = $wms->getCarListByCustomerId($link, $cus_id);
                            foreach ($result_car as $row_car) {
                                echo '<option value="' . $row_car['VIN'] . '">' . $row_car['VIN'] . '</option>';
                            }
                            ?>
                        </select>
                    </p> -->

                    <!-- <p>
                        
                        <select onchange="loadVehiData();" class="form-control" name="modeleMarqueVehi" id="marque_modele_vehi">
                            <option selected value="">--Veuillez sélectionner le véhicule à enregistrer correspondant à ce client--</option>
                        </select>
                    </p> -->


                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Prise en charge</h1>

                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="heure_reception" class="col-md-3 col-form-label">Heure</label>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="text" id="heure_reception" name="heure_reception" value="<?php echo date_format(date_create('now'), 'H:i:s'); ?>" class="bootstrap-timepicker form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="km_reception_vehi" class="col-md-3 col-form-label"> Kilométrage</label>
                            <div class="col-md-9 input-group" style="padding-left:0px;">
                                <span class="input-group-addon">
                                    <select name="type_km">
                                        <option value="km">km</option>
                                        <option value="miles">miles</option>
                                    </select>
                                </span>
                                <input type="text" id="km_reception_vehi" maxlength="6" name="km_reception_vehi" value="" class="form-control" placeholder="Saisissez le kilométrage en km ou en miles" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nivo_carbu_recep_vehi" class="col-md-3 col-form-label"><span style="color:red;">*</span> Niveau de carburant</label>
                            <div class="col-md-1 form-check" style="padding-left:0px;">
                                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_0_4" value="0/4">
                                <label class="form-check-label" for="nivo_carbu_recep_vehi">0/4</label>
                            </div>
                            <div class="col-md-1 form-check" style="padding-left:0px;">
                                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_1_4" value="1/4" checked>
                                <label class="form-check-label" for="nivo_carbu_recep_vehi">1/4</label>
                            </div>
                            <div class="col-md-1 form-check" style="padding-left:0px;">
                                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_1_2" value="1/2">
                                <label class="form-check-label" for="nivo_carbu_recep_vehi">1/2</label>
                            </div>
                            <div class="col-md-1 form-check" style="padding-left:0px;">
                                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_3_4" value="3/4">
                                <label class="form-check-label" for="nivo_carbu_recep_vehi">3/4</label>
                            </div>
                            <div class="col-md-1 form-check" style="padding-left:0px;">
                                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_4_4" value="4/4">
                                <label class="form-check-label" for="nivo_carbu_recep_vehi">4/4</label>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="checkbox" id="cle_recep_vehi" name="cle_recep_vehi" value="Clé du véhicule" class="form-check-input" checked />
                                <label for="clé du véhicule"><span style="color:red;">*</span> Clé du véhicule</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="number" min="0" max="100" name="cle_recep_vehi_text" id="cle_recep_vehi_text" class="form-control" placeholder="Veuillez renseigner le nombre de clé du véhicule" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="checkbox" id="carte_grise_recep_vehi" name="carte_grise_recep_vehi" value="Carte grise" class="form-check-input">
                                <label for="carte_grise_recep_vehi">Carte grise</label>
                            </div>
                        </div>

                    </div>

                    <div class="container" id="date_assurance_visitetech" style="width:auto;">
                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="checkbox" id="assur_recep_vehi" name="assur_recep_vehi" value="Assurance" class="form-check-input">
                                <label for="assurance"><span style="color:red;">*</span> Assurance</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;" id="date_assurance">
                                <input type="text" name="add_date_assurance" value="<?php echo $add_date_assurance; ?>" id="add_date_assurance" class="datepicker form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                                <input type="checkbox" id="visitetech_recep_vehi" name="visitetech_recep_vehi" value="Visite technique">
                                <label for="visite technique"><span style="color:red;">*</span> Visite technique</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;" id="date_visitetech">
                                <input type="text" name="add_date_visitetech" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="datepicker form-control" />
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Accessoires véhicule</h1>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <input type="checkbox" id="cric_levage_recep_vehi" name="cric_levage_recep_vehi" value="Cric de levage">
                            <label for="cric_levage_recep_vehi">Cric de levage</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="cle_roue" name="cle_roue" value="Clé de roue">
                            <label for="cle_roue">Clé de roue</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="rallonge_roue_recep_vehi" name="rallonge_roue_recep_vehi" value="Rallonge de la roue">
                            <label for="rallonge_roue_recep_vehi">Rallonge de la roue</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="pneu_secours" name="pneu_secours" value="Pneu secours">
                            <label for="pneu_secours">Pneu secours</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3">
                            <input type="checkbox" id="panneau_remorquage_recep_vehi" name="panneau_remorquage_recep_vehi" value="Panneau de remorquage">
                            <label for="panneau_remorquage_recep_vehi">Panneau de remorquage</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="triangle" name="triangle" value="Triangle">
                            <label for="triangle">Triangle</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="boite_pharma" name="boite_pharma" value="Boite pharmaceutique">
                            <label for="boite_pharma">Boite pharmaceutique</label>
                        </div>
                        <div class="col-md-3">
                            <input type="checkbox" id="extincteur" name="extincteur" value="Extincteur">
                            <label for="extincteur">Extincteur</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="remarque_access_vehi" class="col-md-2 col-form-label">Remarque :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <textarea class="form-control" id="remarque_access_vehi" rows="4" name="remarque_access_vehi"></textarea>
                        </div>
                    </div>

                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2" />
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Motif de dépot</h1>
                    <p style="color:red; font-style:italic">NB: Veuillez sélectionner le ou les motifs de dépots</p>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <input type="checkbox" id="scanner_recep_vehi" name="scanner_recep_vehi" value="Scanner" checked>
                            <label for="scanner_recep_vehi">Scanner</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="elec_recep_vehi" name="elec_recep_vehi" value="Electrique">
                            <label for="elec_recep_vehi">Electrique</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="meca_recep_vehi" name="meca_recep_vehi" value="Mecanique">
                            <label for="mecanique">Mécanique</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <input type="checkbox" id="pb_electro_recep_vehi" name="pb_electro_recep_vehi" value="Problèmes électroniques">
                            <label for="problèmes électroniques">Problèmes électroniques</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="pb_demar_recep_vehi" name="pb_demar_recep_vehi" value="Problèmes de démarrage">
                            <label for="problèmes de démarrage">Problèmes de démarrage</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="pb_meca_recep_vehi" name="pb_meca_recep_vehi" value="Problèmes mécaniques">
                            <label for="problèmes mécaniques">Problèmes mécaniques</label>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="col-md-4">
                            <input type="checkbox" id="conf_cle_recep_vehi" name="conf_cle_recep_vehi" value="Confection de clé">
                            <label for="confection de clé">Confection de clé</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="sup_adblue_recep_vehi" name="sup_adblue_recep_vehi" value="Suppression adblue">
                            <label for="suppression adblue">Suppression adblue</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="sup_fil_parti_recep_vehi" name="sup_fil_parti_recep_vehi" value="Suppression filtre à particule">
                            <label for="suppression filtre à particule">Suppression filtre à particule</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <input type="checkbox" id="dupli_cle_recep_vehi" name="dupli_cle_recep_vehi" value="Duplication de clé">
                            <label for="duplication de clé">Duplication de clé</label>
                        </div>
                        <div class="col-md-4">
                            <input type="checkbox" id="sup_vanne_egr_recep_vehi" name="sup_vanne_egr_recep_vehi" value="Suppression de vanne EGR">
                            <label for="Suppression de vanne EGR">Suppression de vanne EGR</label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="row">
                                <label for="voyants allumés">Voyants allumés</label>
                                <p style="color:red; font-style:italic">NB: Veuillez sélectionner le ou les voyants allumés</p>
                            </div>
                            <div class="row">
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_1.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_2" name="voyant_2" value="img/voyants_auto/voyant_2.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_2.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_3" name="voyant_3" value="img/voyants_auto/voyant_3.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_3.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_4" name="voyant_4" value="img/voyants_auto/voyant_4.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_4.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_5" name="voyant_5" value="img/voyants_auto/voyant_5.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_5.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_6" name="voyant_6" value="img/voyants_auto/voyant_6.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_6.png" alt="" height="44" width="46">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_7" name="voyant_7" value="img/voyants_auto/voyant_7.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_7.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_8" name="voyant_8" value="img/voyants_auto/voyant_8.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_8.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_9" name="voyant_9" value="img/voyants_auto/voyant_9.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_9.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_10" name="voyant_10" value="img/voyants_auto/voyant_10.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_10.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_11" name="voyant_11" value="img/voyants_auto/voyant_11.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_11.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_12" name="voyant_12" value="img/voyants_auto/voyant_12.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_12.png" alt="" height="44" width="46">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_13" name="voyant_13" value="img/voyants_auto/voyant_13.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_13.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_14" name="voyant_14" value="img/voyants_auto/voyant_14.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_14.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_15" name="voyant_15" value="img/voyants_auto/voyant_15.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_15.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_16" name="voyant_16" value="img/voyants_auto/voyant_16.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_16.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_17" name="voyant_17" value="img/voyants_auto/voyant_17.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_17.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_18" name="voyant_18" value="img/voyants_auto/voyant_18.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_18.png" alt="" height="44" width="46">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_19" name="voyant_19" value="img/voyants_auto/voyant_19.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_19.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_20" name="voyant_20" value="img/voyants_auto/voyant_20.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_20.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_21" name="voyant_21" value="img/voyants_auto/voyant_21.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_21.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_22" name="voyant_22" value="img/voyants_auto/voyant_22.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_22.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_23" name="voyant_23" value="img/voyants_auto/voyant_23.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_23.png" alt="" height="44" width="46">
                                </div>
                                <div class="col-md-2" style="display:flex;flex-direction:row;">
                                    <input type="checkbox" id="voyant_24" name="voyant_24" value="img/voyants_auto/voyant_24.png">
                                    <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_24.png" alt="" height="44" width="46">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="remarque_motif_depot" class="col-md-2 col-form-label">Remarque :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <textarea class="form-control" id="remarque_motif_depot" rows="4" name="remarque_motif_depot"></textarea>
                        </div>
                    </div>



                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4" />
                                </span>
                            </div>
                        </div>
                    </fieldset>

                    <!-- <h1 style="text-align:center;">Enregistrement du véhicule</h1>

                    <div class="form-group row">
                        <div class="col-md-11">
                            
                            <input required onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule en saisissant son immatriculation">
                        </div>
                        <div class=" col-md-1">
                            <a class="btn btn-success" data-toggle="tooltip" data-original-title="Ajouter une nouvelle voiture" target="_blank" onclick="getImmaValue();"><i class="fa fa-plus"></i></a>
                            
                        </div>
                    </div>

                    <div class="form-group" id="marque_modele_vehi_box">
                        <input readonly onfocus="loadVehiData();" type="text" name="modeleMarqueVehi" id="marque_modele_vehi" class="form-control" value="">
                    </div>

                    <p>
                    
                        <input type="text" name="add_date" value="<?php echo $c_add_date; ?>" id="add_date" class="form-control datepicker" placeholder="Saisissez la date de reception du véhicule" />
                    </p> -->


                </div>
                <div class="tab">
                    <h1 style="text-align:center;">Etat du véhicule à l'arrivée</h1>

                    <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre véhicule</p>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="radio" id="etat_proprete_arrivee_1" name="etat_proprete_arrivee" value="Propre" checked>
                            <label for="propre">Propre</label>
                        </div>
                        <div class="col-md-6">
                            <input type="radio" id="etat_proprete_arrivee_3" name="etat_proprete_arrivee" value="Poussiéreuse">
                            <label for="poussiereuse">Poussiéreuse</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <input type="radio" id="etat_vehi_arrive_conduit" name="etat_vehi_arrive" value="Conduit" checked>
                            <label for="conduit">Conduit</label>
                        </div>
                        <div class="col-md-6" style="padding:0px;">
                            <div class="col-md-3">
                                <input type="radio" id="etat_vehi_arrive_remorq" name="etat_vehi_arrive" value="Remorqué">
                                <label for="remorque">Remorqué</label>
                            </div>
                            <div class="col-md-9" style="padding-left:0px;">
                                <input type="text" name="arriv_remarq_recep_vehi_text" id="arriv_remarq_recep_vehi_text" class="form-control" value="">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <input type="checkbox" id="accident_recep_vehi" name="accident_recep_vehi" value="Accidenté" class="form-check-input">
                            <label for="accidente">Accidenté</label>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="remarque_etat_vehi_arrive" class="col-md-2 col-form-label">Remarque :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <textarea class="form-control" id="remarque_etat_vehi_arrive" rows="4" name="remarque_etat_vehi_arrive"></textarea>
                        </div>
                    </div>

                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Aspect extérieur</h1>
                    <h6>B:bon, M:mauvais, A:absent</h6>
                    <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre composant</p>
                    <div class="row">
                        <!-- debut row -->

                        <div class="col-md-6">
                            <!-- debut gauche -->

                            <!-- Pare brise avant -->
                            <div class="form-group row">
                                <label for="pare_brise_avant" class="col-md-6 col-form-label">Pare brise avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant" value="Bon" checked>
                                    <label class="form-check-label" for="pare_brise_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant" value="Mauvais">
                                    <label class="form-check-label" for="pare_brise_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant" value="Absent">
                                    <label class="form-check-label" for="pare_brise_avant">A</label>
                                </div>
                            </div>

                            <!-- Phare gauche -->
                            <div class="form-group row">
                                <label for="phare_gauche" class="col-md-6 col-form-label">Phare gauche</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche" value="Bon" checked>
                                    <label class="form-check-label" for="phare_gauche">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche" value="Mauvais">
                                    <label class="form-check-label" for="phare_gauche">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche" value="Absent">
                                    <label class="form-check-label" for="phare_gauche">A</label>
                                </div>
                            </div>

                            <!-- Clignotant droit -->
                            <div class="form-group row">
                                <label for="clignotant_droit" class="col-md-6 col-form-label">Clignotant droit</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit" value="Bon" checked>
                                    <label class="form-check-label" for="clignotant_droit">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit" value="Mauvais">
                                    <label class="form-check-label" for="clignotant_droit">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit" value="Absent">
                                    <label class="form-check-label" for="clignotant_droit">A</label>
                                </div>
                            </div>

                            <!-- Pare choc avant -->
                            <div class="form-group row">
                                <label for="pare_choc_avant" class="col-md-6 col-form-label">Pare choc avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_avant" id="pare_choc_avant" value="Bon" checked>
                                    <label class="form-check-label" for="pare_choc_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_avant" id="pare_choc_avant" value="Mauvais">
                                    <label class="form-check-label" for="pare_choc_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_avant" id="pare_choc_avant" value="Absent">
                                    <label class="form-check-label" for="pare_choc_avant">A</label>
                                </div>
                            </div>

                            <!-- Feu avant -->
                            <div class="form-group row">
                                <label for="feu_avant" class="col-md-6 col-form-label">Feu avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_avant" id="feu_avant" value="Bon" checked>
                                    <label class="form-check-label" for="feu_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_avant" id="feu_avant" value="Mauvais">
                                    <label class="form-check-label" for="feu_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_avant" id="feu_avant" value="Absent">
                                    <label class="form-check-label" for="feu_avant">A</label>
                                </div>
                            </div>

                            <!-- Vitres avant -->
                            <div class="form-group row">
                                <label for="vitre_avant" class="col-md-6 col-form-label">Vitres avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_avant" id="vitre_avant" value="Bon" checked>
                                    <label class="form-check-label" for="vitre_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_avant" id="vitre_avant" value="Mauvais">
                                    <label class="form-check-label" for="vitre_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_avant" id="vitre_avant" value="Absent">
                                    <label class="form-check-label" for="vitre_avant">A</label>
                                </div>
                            </div>

                            <!-- Poignet avant -->
                            <div class="form-group row">
                                <label for="poignet_avant" class="col-md-6 col-form-label">Poignet avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_avant" id="poignet_avant" value="Bon" checked>
                                    <label class="form-check-label" for="poignet_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_avant" id="poignet_avant" value="Mauvais">
                                    <label class="form-check-label" for="poignet_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_avant" id="poignet_avant" value="Absent">
                                    <label class="form-check-label" for="poignet_avant">A</label>
                                </div>
                            </div>

                            <!-- Plaque avant -->
                            <div class="form-group row">
                                <label for="plaque_avant" class="col-md-6 col-form-label">Plaque avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_avant" id="plaque_avant" value="Bon" checked>
                                    <label class="form-check-label" for="plaque_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_avant" id="plaque_avant" value="Mauvais">
                                    <label class="form-check-label" for="plaque_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_avant" id="plaque_avant" value="Absent">
                                    <label class="form-check-label" for="plaque_avant">A</label>
                                </div>
                            </div>

                            <!-- Feu de brouillard -->
                            <div class="form-group row">
                                <label for="feu_brouillard" class="col-md-6 col-form-label">Feu de brouillard</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_brouillard" id="feu_brouillard" value="Bon" checked>
                                    <label class="form-check-label" for="feu_brouillard">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_brouillard" id="feu_brouillard" value="Mauvais">
                                    <label class="form-check-label" for="feu_brouillard">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_brouillard" id="feu_brouillard" value="Absent">
                                    <label class="form-check-label" for="feu_brouillard">A</label>
                                </div>
                            </div>

                            <!-- Balai essuie glace -->
                            <div class="form-group row">
                                <label for="balai_essuie_glace" class="col-md-6 col-form-label">Balai essuie glace</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="balai_essuie_glace" id="balai_essuie_glace" value="Bon" checked>
                                    <label class="form-check-label" for="balai_essuie_glace">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="balai_essuie_glace" id="balai_essuie_glace" value="Mauvais">
                                    <label class="form-check-label" for="balai_essuie_glace">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="balai_essuie_glace" id="balai_essuie_glace" value="Absent">
                                    <label class="form-check-label" for="balai_essuie_glace">A</label>
                                </div>
                            </div>

                            <!-- Rétroviseur gauche -->
                            <div class="form-group row">
                                <label for="retroviseur_gauche" class="col-md-6 col-form-label">Rétroviseur gauche</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_gauche" id="retroviseur_gauche" value="Bon" checked>
                                    <label class="form-check-label" for="retroviseur_gauche">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_gauche" id="retroviseur_gauche" value="Mauvais">
                                    <label class="form-check-label" for="retroviseur_gauche">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_gauche" id="retroviseur_gauche" value="Absent">
                                    <label class="form-check-label" for="retroviseur_gauche">A</label>
                                </div>
                            </div>

                            <!-- Symbole avant -->
                            <div class="form-group row">
                                <label for="symbole_avant" class="col-md-6 col-form-label">Symbole avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_avant" id="symbole_avant" value="Bon" checked>
                                    <label class="form-check-label" for="symbole_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_avant" id="symbole_avant" value="Mauvais">
                                    <label class="form-check-label" for="symbole_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_avant" id="symbole_avant" value="Absent">
                                    <label class="form-check-label" for="symbole_avant">A</label>
                                </div>
                            </div>

                            <!-- Poignet de capot -->
                            <div class="form-group row">
                                <label for="poignet_capot" class="col-md-6 col-form-label">Poignet de capot</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_capot" id="poignet_capot" value="Bon" checked>
                                    <label class="form-check-label" for="poignet_capot">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_capot" id="poignet_capot" value="Mauvais">
                                    <label class="form-check-label" for="poignet_capot">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_capot" id="poignet_capot" value="Absent">
                                    <label class="form-check-label" for="poignet_capot">A</label>
                                </div>
                            </div>

                            <!-- Alternateur -->
                            <div class="form-group row">
                                <label for="alternateur" class="col-md-6 col-form-label">Alternateur</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="alternateur" id="alternateur" value="Bon" checked>
                                    <label class="form-check-label" for="alternateur">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="alternateur" id="alternateur" value="Mauvais">
                                    <label class="form-check-label" for="alternateur">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="alternateur" id="alternateur" value="Absent">
                                    <label class="form-check-label" for="alternateur">A</label>
                                </div>
                            </div>

                        </div> <!-- fin gauche -->

                        <div class="col-md-6">
                            <!-- debut droit -->

                            <!-- Pare brise arrière -->
                            <div class="form-group row">
                                <label for="pare_brise_arriere" class="col-md-6 col-form-label">Pare brise arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_arriere" id="pare_brise_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="pare_brise_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_arriere" id="pare_brise_arriere" value="Mauvais">
                                    <label class="form-check-label" for="pare_brise_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_brise_arriere" id="pare_brise_arriere" value="Absent">
                                    <label class="form-check-label" for="pare_brise_arriere">A</label>
                                </div>
                            </div>

                            <!-- Phare droit -->
                            <div class="form-group row">
                                <label for="phare_droit" class="col-md-6 col-form-label">Phare droit</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_droit" id="phare_droit" value="Bon" checked>
                                    <label class="form-check-label" for="phare_droit">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_droit" id="phare_droit" value="Mauvais">
                                    <label class="form-check-label" for="phare_droit">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="phare_droit" id="phare_droit" value="Absent">
                                    <label class="form-check-label" for="phare_droit">A</label>
                                </div>
                            </div>

                            <!-- Clignotant gauche -->
                            <div class="form-group row">
                                <label for="clignotant_gauche" class="col-md-6 col-form-label">Clignotant gauche</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_gauche" id="clignotant_gauche" value="Bon" checked>
                                    <label class="form-check-label" for="clignotant_gauche">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_gauche" id="clignotant_gauche" value="Mauvais">
                                    <label class="form-check-label" for="clignotant_gauche">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="clignotant_gauche" id="clignotant_gauche" value="Absent">
                                    <label class="form-check-label" for="clignotant_gauche">A</label>
                                </div>
                            </div>

                            <!-- Pare choc arrière -->
                            <div class="form-group row">
                                <label for="pare_choc_arriere" class="col-md-6 col-form-label">Pare choc arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_arriere" id="pare_choc_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="pare_choc_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_arriere" id="pare_choc_arriere" value="Mauvais">
                                    <label class="form-check-label" for="pare_choc_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="pare_choc_arriere" id="pare_choc_arriere" value="Absent">
                                    <label class="form-check-label" for="pare_choc_arriere">A</label>
                                </div>
                            </div>

                            <!-- Feu arrière -->
                            <div class="form-group row">
                                <label for="feu_arriere" class="col-md-6 col-form-label">Feu arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_arriere" id="feu_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="feu_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_arriere" id="feu_arriere" value="Mauvais">
                                    <label class="form-check-label" for="feu_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="feu_arriere" id="feu_arriere" value="Absent">
                                    <label class="form-check-label" for="feu_arriere">A</label>
                                </div>
                            </div>

                            <!-- Vitres arrière -->
                            <div class="form-group row">
                                <label for="vitre_arriere" class="col-md-6 col-form-label">Vitres arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_arriere" id="vitre_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="vitre_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_arriere" id="vitre_arriere" value="Mauvais">
                                    <label class="form-check-label" for="vitre_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="vitre_arriere" id="vitre_arriere" value="Absent">
                                    <label class="form-check-label" for="vitre_arriere">A</label>
                                </div>
                            </div>

                            <!-- Poignet arrière -->
                            <div class="form-group row">
                                <label for="poignet_arriere" class="col-md-6 col-form-label">Poignet arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_arriere" id="poignet_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="poignet_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_arriere" id="poignet_arriere" value="Mauvais">
                                    <label class="form-check-label" for="poignet_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poignet_arriere" id="poignet_arriere" value="Absent">
                                    <label class="form-check-label" for="poignet_arriere">A</label>
                                </div>
                            </div>

                            <!-- Plaque arrière -->
                            <div class="form-group row">
                                <label for="plaque_arriere" class="col-md-6 col-form-label">Plaque arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_arriere" id="plaque_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="plaque_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_arriere" id="plaque_arriere" value="Mauvais">
                                    <label class="form-check-label" for="plaque_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="plaque_arriere" id="plaque_arriere" value="Absent">
                                    <label class="form-check-label" for="plaque_arriere">A</label>
                                </div>
                            </div>

                            <!-- Contrôle pneu -->
                            <div class="form-group row">
                                <label for="controle_pneu" class="col-md-6 col-form-label">Contrôle pneu</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="controle_pneu" id="controle_pneu" value="Bon" checked>
                                    <label class="form-check-label" for="controle_pneu">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="controle_pneu" id="controle_pneu" value="Mauvais">
                                    <label class="form-check-label" for="controle_pneu">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="controle_pneu" id="controle_pneu" value="Absent">
                                    <label class="form-check-label" for="controle_pneu">A</label>
                                </div>
                            </div>

                            <!-- Batterie -->
                            <div class="form-group row">
                                <label for="batterie" class="col-md-6 col-form-label">Batterie</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="batterie" id="batterie" value="Bon" checked>
                                    <label class="form-check-label" for="batterie">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="batterie" id="batterie" value="Mauvais">
                                    <label class="form-check-label" for="batterie">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="batterie" id="batterie" value="Absent">
                                    <label class="form-check-label" for="batterie">A</label>
                                </div>
                            </div>

                            <!-- Rétroviseur droit -->
                            <div class="form-group row">
                                <label for="retroviseur_droit" class="col-md-6 col-form-label">Rétroviseur droit</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_droit" id="retroviseur_droit" value="Bon" checked>
                                    <label class="form-check-label" for="retroviseur_droit">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_droit" id="retroviseur_droit" value="Mauvais">
                                    <label class="form-check-label" for="retroviseur_droit">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_droit" id="retroviseur_droit" value="Absent">
                                    <label class="form-check-label" for="retroviseur_droit">A</label>
                                </div>
                            </div>

                            <!-- Symbole arrière -->
                            <div class="form-group row">
                                <label for="symbole_arriere" class="col-md-6 col-form-label">Symbole arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_arriere" id="symbole_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="symbole_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_arriere" id="symbole_arriere" value="Mauvais">
                                    <label class="form-check-label" for="symbole_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="symbole_arriere" id="symbole_arriere" value="Absent">
                                    <label class="form-check-label" for="symbole_arriere">A</label>
                                </div>
                            </div>

                            <!-- Cache moteur -->
                            <div class="form-group row">
                                <label for="cache_moteur" class="col-md-6 col-form-label">Cache moteur</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="cache_moteur" id="cache_moteur" value="Bon" checked>
                                    <label class="form-check-label" for="cache_moteur">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="cache_moteur" id="cache_moteur" value="Mauvais">
                                    <label class="form-check-label" for="cache_moteur">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="cache_moteur" id="cache_moteur" value="Absent">
                                    <label class="form-check-label" for="cache_moteur">A</label>
                                </div>
                            </div>

                        </div> <!-- fin droit-->

                    </div> <!-- fin row -->

                    <div class="form-group row">
                        <label for="remarque_aspect_ext" class="col-md-2 col-form-label">Dimensions du pneu :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <input type="text" name="dim_pneu" id="dim_pneu" class="form-control" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="remarque_aspect_ext" class="col-md-2 col-form-label">Remarque :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <textarea class="form-control" id="remarque_aspect_ext" rows="4" name="remarque_aspect_ext"></textarea>
                        </div>
                    </div>

                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6" />
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Aspect intérieur</h1>
                    <h6>B:bon, M:mauvais, A:absent</h6>
                    <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre composant</p>
                    <div class="row">
                        <!-- debut row -->
                        <div class="col-md-6">
                            <!-- debut gauche -->

                            <!-- Poste auto -->
                            <div class="form-group row">
                                <label for="poste_auto" class="col-md-6 col-form-label">Poste auto</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poste_auto" id="poste_auto" value="Bon" checked>
                                    <label class="form-check-label" for="poste_auto">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poste_auto" id="poste_auto" value="Mauvais">
                                    <label class="form-check-label" for="poste_auto">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="poste_auto" id="poste_auto" value="Absent">
                                    <label class="form-check-label" for="poste_auto">A</label>
                                </div>
                            </div>

                            <!-- Coffre à gant -->
                            <div class="form-group row">
                                <label for="coffre_gant" class="col-md-6 col-form-label">Coffre à gant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="coffre_gant" id="coffre_gant" value="Bon" checked>
                                    <label class="form-check-label" for="coffre_gant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="coffre_gant" id="coffre_gant" value="Mauvais">
                                    <label class="form-check-label" for="coffre_gant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="coffre_gant" id="coffre_gant" value="Absent">
                                    <label class="form-check-label" for="coffre_gant">A</label>
                                </div>
                            </div>

                            <!-- Tapis plafond -->
                            <div class="form-group row">
                                <label for="tapis_plafond" class="col-md-6 col-form-label">Tapis plafond</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_plafond" id="tapis_plafond" value="Bon" checked>
                                    <label class="form-check-label" for="tapis_plafond">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_plafond" id="tapis_plafond" value="Mauvais">
                                    <label class="form-check-label" for="tapis_plafond">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_plafond" id="tapis_plafond" value="Absent">
                                    <label class="form-check-label" for="tapis_plafond">A</label>
                                </div>
                            </div>

                            <!-- Ecran de bord -->
                            <div class="form-group row">
                                <label for="ecran_bord" class="col-md-6 col-form-label">Ecran de bord</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ecran_bord" id="ecran_bord" value="Bon" checked>
                                    <label class="form-check-label" for="ecran_bord">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ecran_bord" id="ecran_bord" value="Mauvais">
                                    <label class="form-check-label" for="ecran_bord">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ecran_bord" id="ecran_bord" value="Absent">
                                    <label class="form-check-label" for="ecran_bord">A</label>
                                </div>
                            </div>

                            <!-- Rétroviseur interne -->
                            <div class="form-group row">
                                <label for="retroviseur_interne" class="col-md-6 col-form-label">Rétroviseur interne</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_interne" id="retroviseur_interne" value="Bon" checked>
                                    <label class="form-check-label" for="retroviseur_interne">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_interne" id="retroviseur_interne" value="Mauvais">
                                    <label class="form-check-label" for="retroviseur_interne">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="retroviseur_interne" id="retroviseur_interne" value="Absent">
                                    <label class="form-check-label" for="retroviseur_interne">A</label>
                                </div>
                            </div>

                            <!-- Bouton de vitre arriere -->
                            <div class="form-group row">
                                <label for="bouton_vitre_arriere" class="col-md-6 col-form-label">Bouton de vitre arrière</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_arriere" id="bouton_vitre_arriere" value="Bon" checked>
                                    <label class="form-check-label" for="bouton_vitre_arriere">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_arriere" id="bouton_vitre_arriere" value="Mauvais">
                                    <label class="form-check-label" for="bouton_vitre_arriere">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_arriere" id="bouton_vitre_arriere" value="Absent">
                                    <label class="form-check-label" for="bouton_vitre_arriere">A</label>
                                </div>
                            </div>

                        </div> <!-- fin gauche -->

                        <div class="col-md-6">
                            <!-- debut droit -->

                            <!-- Tableau de bord -->
                            <div class="form-group row">
                                <label for="tableau_bord" class="col-md-6 col-form-label">Tableau de bord</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tableau_bord" id="tableau_bord" value="Bon" checked>
                                    <label class="form-check-label" for="tableau_bord">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tableau_bord" id="tableau_bord" value="Mauvais">
                                    <label class="form-check-label" for="tableau_bord">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tableau_bord" id="tableau_bord" value="Absent">
                                    <label class="form-check-label" for="tableau_bord">A</label>
                                </div>
                            </div>

                            <!-- Tapis de sol -->
                            <div class="form-group row">
                                <label for="tapis_sol" class="col-md-6 col-form-label">Tapis de sol</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_sol" id="tapis_sol" value="Bon" checked>
                                    <label class="form-check-label" for="tapis_sol">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_sol" id="tapis_sol" value="Mauvais">
                                    <label class="form-check-label" for="tapis_sol">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="tapis_sol" id="tapis_sol" value="Absent">
                                    <label class="form-check-label" for="tapis_sol">A</label>
                                </div>
                            </div>

                            <!-- Commutateur central -->
                            <div class="form-group row">
                                <label for="commutateur_central" class="col-md-6 col-form-label">Commutateur central</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="commutateur_central" id="commutateur_central" value="Bon" checked>
                                    <label class="form-check-label" for="commutateur_central">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="commutateur_central" id="commutateur_central" value="Mauvais">
                                    <label class="form-check-label" for="commutateur_central">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="commutateur_central" id="commutateur_central" value="Absent">
                                    <label class="form-check-label" for="commutateur_central">A</label>
                                </div>
                            </div>

                            <!-- Ampoule intérieure -->
                            <div class="form-group row">
                                <label for="ampoule_interieure" class="col-md-6 col-form-label">Ampoule intérieure</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ampoule_interieure" id="ampoule_interieure" value="Bon" checked>
                                    <label class="form-check-label" for="ampoule_interieure">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ampoule_interieure" id="ampoule_interieure" value="Mauvais">
                                    <label class="form-check-label" for="ampoule_interieure">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="ampoule_interieure" id="ampoule_interieure" value="Absent">
                                    <label class="form-check-label" for="ampoule_interieure">A</label>
                                </div>
                            </div>

                            <!-- Bouton de vitre avant -->
                            <div class="form-group row">
                                <label for="bouton_vitre_avant" class="col-md-6 col-form-label">Bouton de vitre avant</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_avant" id="bouton_vitre_avant" value="Bon" checked>
                                    <label class="form-check-label" for="bouton_vitre_avant">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_avant" id="bouton_vitre_avant" value="Mauvais">
                                    <label class="form-check-label" for="bouton_vitre_avant">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_vitre_avant" id="bouton_vitre_avant" value="Absent">
                                    <label class="form-check-label" for="bouton_vitre_avant">A</label>
                                </div>
                            </div>

                            <!-- Bouton de siège -->
                            <div class="form-group row">
                                <label for="bouton_siege" class="col-md-6 col-form-label">Bouton de siège</label>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_siege" id="bouton_siege" value="Bon" checked>
                                    <label class="form-check-label" for="bouton_siege">B</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_siege" id="bouton_siege" value="Mauvais">
                                    <label class="form-check-label" for="bouton_siege">M</label>
                                </div>
                                <div class="col-md-2 form-check" style="padding-left:0px;">
                                    <input class="form-check-input" type="radio" name="bouton_siege" id="bouton_siege" value="Absent">
                                    <label class="form-check-label" for="bouton_siege">A</label>
                                </div>
                            </div>

                        </div> <!-- fin droit -->
                    </div>
                    <div class="form-group row">
                        <label for="remarque_aspect_int" class="col-md-2 col-form-label">Remarque :</label>
                        <div class="col-md-10" style="padding-left:0px;">
                            <textarea class="form-control" id="remarque_aspect_int" rows="4" name="remarque_aspect_int"></textarea>
                        </div>
                    </div>

                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_7" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_8" />
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Travaux à effectuer</h1>
                    <textarea class="form-control" id="travo_effec" rows="6" name="travo_effec"></textarea>
                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_9" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_10" />
                                </span>
                            </div>
                        </div>
                    </fieldset>
                    <!-- </div> -->
                    <!-- <div class="tab"> -->
                    <h1 style="text-align:center;">Autres observations</h1>
                    <textarea class="form-control" id="autres_obs" rows="6" name="autres_obs"></textarea>
                    <fieldset>
                        <legend>Ajouter des fichiers joints</legend>
                        <div class="row">
                            <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_11" />
                                </span>
                            </div>
                            <div class="col-md-1 col-md-onset-10">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_12" />
                                </span>
                            </div>
                        </div>
                    </fieldset>
                </div>
    </div>
    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
        </div>
    </div>
    <!-- Circles which indicates the steps of the form: -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <!-- <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span>
                    <span class="step"></span> -->
    </div>
    <input type="hidden" value="<?php echo $hdnid; ?>" name="repair_car" />
    <input type="hidden" name="hfInvoiceId" value="<?php echo $invoice_id; ?>" />
    <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
    <input type="hidden" name="ddlMake" value="" />
    <input type="hidden" name="ddlModel" value="" />
    <input type="hidden" name="ddlImma" value="" />
    <input type="hidden" name="recep_id" value="<?php echo $recep_id; ?>" />

    </section>
    </form>
    </div>
    <script type="text/javascript">
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        // Récupération des éléments à partir de leur id
        const elt_etat_vehi_arrive_remorq = document.getElementById('etat_vehi_arrive_remorq');
        const elt_nivo_carbu_recep_vehi_0_4 = document.getElementById('nivo_carbu_recep_vehi_0_4');
        const elt_nivo_carbu_recep_vehi_1_2 = document.getElementById('nivo_carbu_recep_vehi_1_2');
        const elt_nivo_carbu_recep_vehi_1_4 = document.getElementById('nivo_carbu_recep_vehi_1_4');
        const elt_nivo_carbu_recep_vehi_3_4 = document.getElementById('nivo_carbu_recep_vehi_3_4');
        const elt_nivo_carbu_recep_vehi_4_4 = document.getElementById('nivo_carbu_recep_vehi_4_4');

        const elt_elec_recep_vehi = document.getElementById('elec_recep_vehi');
        const elt_meca_recep_vehi = document.getElementById('meca_recep_vehi');
        const elt_pb_electro_recep_vehi = document.getElementById('pb_electro_recep_vehi');
        const elt_pb_demar_recep_vehi = document.getElementById('pb_demar_recep_vehi');
        const elt_pb_meca_recep_vehi = document.getElementById('pb_meca_recep_vehi');
        const elt_sup_adblue_recep_vehi = document.getElementById('sup_adblue_recep_vehi');
        const elt_sup_fil_parti_recep_vehi = document.getElementById('sup_fil_parti_recep_vehi');
        const elt_sup_vanne_egr_recep_vehi = document.getElementById('sup_vanne_egr_recep_vehi');
        const elt_dupli_cle_recep_vehi = document.getElementById('dupli_cle_recep_vehi');

        const elt_voyant_1 = document.getElementById('voyant_1');
        const elt_voyant_2 = document.getElementById('voyant_2');
        const elt_voyant_3 = document.getElementById('voyant_3');
        const elt_voyant_4 = document.getElementById('voyant_4');
        const elt_voyant_5 = document.getElementById('voyant_5');
        const elt_voyant_6 = document.getElementById('voyant_6');
        const elt_voyant_7 = document.getElementById('voyant_7');
        const elt_voyant_8 = document.getElementById('voyant_8');
        const elt_voyant_9 = document.getElementById('voyant_9');
        const elt_voyant_10 = document.getElementById('voyant_10');
        const elt_voyant_11 = document.getElementById('voyant_11');
        const elt_voyant_12 = document.getElementById('voyant_12');
        const elt_voyant_13 = document.getElementById('voyant_13');
        const elt_voyant_14 = document.getElementById('voyant_14');
        const elt_voyant_15 = document.getElementById('voyant_15');
        const elt_voyant_16 = document.getElementById('voyant_16');
        const elt_voyant_17 = document.getElementById('voyant_17');
        const elt_voyant_18 = document.getElementById('voyant_18');
        const elt_voyant_19 = document.getElementById('voyant_19');
        const elt_voyant_20 = document.getElementById('voyant_20');
        const elt_voyant_21 = document.getElementById('voyant_21');
        const elt_voyant_22 = document.getElementById('voyant_22');
        const elt_voyant_23 = document.getElementById('voyant_23');
        const elt_voyant_24 = document.getElementById('voyant_24');

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Valider";
            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("tab");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateMe()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;

            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("regForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, z, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            z = x[currentTab].getElementsByTagName("select");

            // Cette boucle vérifie chaque champ input de l'onglet courant
            for (i = 0; i < y.length; i++) {

                if (y[i].type == "hidden") { // Traitement des champs de type hidden "champs cachés"

                    // Même si la valeur du champ hidden est vide
                    // On valide quaund même son statut
                    if (y[i].value == "") {
                        valid = true;
                    }
                } else if (y[i].type == "checkbox") { // Traitement des champs de type checkbox

                    // On vérifie si l'id de l'élément courant correspond à l'id recherché
                    if (y[i].id == "assur_recep_vehi") {

                        // On vérifie que l'élément ayant cet id est checked
                        if (!y[i].checked) {
                            // Si l'élément en question n'est pas checked, alors il est invalide
                            y[i].className += " invalid";
                            valid = false;
                            alert("Veuillez cochez l'assurance SVP !!!");
                        }

                    }

            

                    // On vérifie si l'id de l'élément courant correspond à l'id recherché
                    if (y[i].id == "visitetech_recep_vehi") {

                        // On vérifie que l'élément ayant cet id est checked
                        if (!y[i].checked) {
                            // Si l'élément en question n'est pas checked, alors il est invalide
                            y[i].className += " invalid";
                            valid = false;
                            alert("Veuillez cochez la visite technique SVP !!!");
                        }

                    }

                    if (y[i].id == "sortie_remarq_recep_vehi") {

                        // On vérifie que l'élément ayant cet id est checked
                        if (!y[i].checked) {
                            // Si l'élément en question n'est pas checked, alors il est invalide
                            // y[i].className += " invalid";
                            valid = true;
                            // alert("Veuillez cochez le statut remorqué SVP !!!");
                        }

                    }
                } else if (y[i].type == "text") { // Traitement des champs de type text

                    if (y[i].id == "immat") {

                        // Si la valeur ou le contenu de l'élément text courant est vide alors il est invalid
                        if (y[i].value == "") {

                            // console.log(y[i]);

                            // Si le champ text est invalide, une alerte est déclenchée
                            y[i].className += " invalid";
                            valid = false;
                            alert("Veuillez renseigner ce champ SVP lorsque vous réceptionnez un véhicule !!!");
                        }
                    }

                    // Si l'élément courant est celui recherché
                    if (y[i].id == "arriv_remarq_recep_vehi_text") {

                        // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                        if (elt_etat_vehi_arrive_remorq.id == "etat_vehi_arrive_remorq") {

                            // On vérifie que l'élément ayant cet id est checked
                            // et que la valeur de ce élément checked est "remorqué"
                            if (elt_etat_vehi_arrive_remorq.checked && elt_etat_vehi_arrive_remorq.value == "Remorqué") {

                                // console.log(elt_etat_vehi_arrive_remorq);

                                // Si la valeur ou le contenu de l'élément text courant est vide alors il est invalid
                                if (y[i].value == "") {

                                    // console.log(y[i]);

                                    // Si le champ text est invalide, une alerte est déclenchée
                                    y[i].className += " invalid";
                                    valid = false;
                                    alert("Veuillez renseigner ce champ SVP lorsque le véhicule est rémorqué !!!");
                                }

                            } else { // Sinon si le bouton radio de valeur "remorqué" n'est pas coché

                                // Même si la valeur ou le contenu de l'élément text courant est vide
                                // alors il est valide
                                if (y[i].value == "") {

                                    // console.log(y[i]);

                                    valid = true;
                                }

                            }

                        }

                    } else if (y[i].id == "sortie_remarq_recep_vehi_text") {

                        if (y[i].value == "") {
                            valid = true;
                        }

                    } else {
                        // Même si la valeur du champ hidden est vide
                        // On valide quaund même son statut
                        if (y[i].value == "") {
                            // add an "invalid" class to the field:
                            y[i].className += " invalid";
                            // and set the current valid statut to false
                            valid = false;
                            // valid = true;
                        }

                    }

                } else if (y[i].type == "number") {

                    if (y[i].id == "km_reception_vehi") {
                        if (y[i].value == "") {
                            valid = true;
                        }
                    }

                    if (y[i].id == "cle_recep_vehi_text") {
                        if (y[i].value == "") {
                            valid = true;
                        }
                    }

                } else {
                    valid = true;
                }
            }

            // Cette boucle vérifie chaque champ select de l'onglet courant
            for (i = 0; i < z.length; i++) {
                // If a field is empty...
                if (z[i].value == "") {
                    // add an "invalid" class to the field:
                    z[i].className += " invalid";
                    // and set the current valid statut to false
                    valid = false;
                    // valid = true;
                }
            }

            // If the valid statut is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("step")[currentTab].className += " finish";
            }
            return valid; // return the valid statut
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("step");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

        // Au chargement du DOM
        $(document).ready(function() {

            elt_nivo_carbu_recep_vehi_0_4.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // On vérifie que l'élément ayant cet id est checked
                if (elt_nivo_carbu_recep_vehi_0_4.checked == true) {

                    // console.log(elt_nivo_carbu_recep_vehi_0_4.checked);

                    // Si l'élément en question est checked, c'est que les autres éléments ne sont pas checké
                    elt_nivo_carbu_recep_vehi_1_2.checked = false;
                    elt_nivo_carbu_recep_vehi_3_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_4.checked = false;
                    elt_nivo_carbu_recep_vehi_4_4.checked = false;

                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_elec_recep_vehi.id == "elec_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_elec_recep_vehi.disabled = true;
                    }
                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_meca_recep_vehi.id == "meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_meca_recep_vehi.disabled = true;
                    }
                    if (elt_pb_electro_recep_vehi.id == "pb_electro_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_electro_recep_vehi.disabled = true;
                    }
                    if (elt_pb_demar_recep_vehi.id == "pb_demar_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_demar_recep_vehi.disabled = true;
                    }
                    if (elt_pb_meca_recep_vehi.id == "pb_meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_meca_recep_vehi.disabled = true;
                    }
                    if (elt_sup_adblue_recep_vehi.id == "sup_adblue_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_adblue_recep_vehi.disabled = true;
                    }
                    if (elt_sup_fil_parti_recep_vehi.id == "sup_fil_parti_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_fil_parti_recep_vehi.disabled = true;
                    }
                    if (elt_sup_vanne_egr_recep_vehi.id == "sup_vanne_egr_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_vanne_egr_recep_vehi.disabled = true;
                    }
                    if (elt_dupli_cle_recep_vehi.id == "dupli_cle_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_dupli_cle_recep_vehi.disabled = true;
                    }


                    if (elt_voyant_1.id == "voyant_1") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_1.disabled = true;
                    }
                    if (elt_voyant_2.id == "voyant_2") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_2.disabled = true;
                    }
                    if (elt_voyant_3.id == "voyant_3") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_3.disabled = true;
                    }
                    if (elt_voyant_4.id == "voyant_4") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_4.disabled = true;
                    }
                    if (elt_voyant_5.id == "voyant_5") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_5.disabled = true;
                    }
                    if (elt_voyant_6.id == "voyant_6") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_6.disabled = true;
                    }
                    if (elt_voyant_7.id == "voyant_7") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_7.disabled = true;
                    }
                    if (elt_voyant_8.id == "voyant_8") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_8.disabled = true;
                    }
                    if (elt_voyant_9.id == "voyant_9") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_9.disabled = true;
                    }
                    if (elt_voyant_10.id == "voyant_10") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_10.disabled = true;
                    }
                    if (elt_voyant_11.id == "voyant_11") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_11.disabled = true;
                    }
                    if (elt_voyant_12.id == "voyant_12") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_12.disabled = true;
                    }
                    if (elt_voyant_13.id == "voyant_13") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_13.disabled = true;
                    }
                    if (elt_voyant_14.id == "voyant_14") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_14.disabled = true;
                    }
                    if (elt_voyant_15.id == "voyant_15") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_15.disabled = true;
                    }
                    if (elt_voyant_16.id == "voyant_16") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_16.disabled = true;
                    }
                    if (elt_voyant_17.id == "voyant_17") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_17.disabled = true;
                    }
                    if (elt_voyant_18.id == "voyant_18") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_18.disabled = true;
                    }
                    if (elt_voyant_19.id == "voyant_19") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_19.disabled = true;
                    }
                    if (elt_voyant_20.id == "voyant_20") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_20.disabled = true;
                    }
                    if (elt_voyant_21.id == "voyant_21") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_21.disabled = true;
                    }
                    if (elt_voyant_22.id == "voyant_22") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_22.disabled = true;
                    }
                    if (elt_voyant_23.id == "voyant_23") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_23.disabled = true;
                    }
                    if (elt_voyant_24.id == "voyant_24") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_24.disabled = true;
                    }

                }
            });

            elt_nivo_carbu_recep_vehi_1_2.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // console.log(elt_nivo_carbu_recep_vehi_0_4.checked);

                // On vérifie que l'élément ayant cet id est checked
                if (elt_nivo_carbu_recep_vehi_1_2.checked == true) {

                    // Si l'élément en question est checked, c'est que les autres éléments ne sont pas checké
                    elt_nivo_carbu_recep_vehi_0_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_4.checked = false;
                    elt_nivo_carbu_recep_vehi_3_4.checked = false;
                    elt_nivo_carbu_recep_vehi_4_4.checked = false;


                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_elec_recep_vehi.id == "elec_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_elec_recep_vehi.disabled = false;
                    }
                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_meca_recep_vehi.id == "meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_meca_recep_vehi.disabled = false;
                    }
                    if (elt_pb_electro_recep_vehi.id == "pb_electro_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_electro_recep_vehi.disabled = false;
                    }
                    if (elt_pb_demar_recep_vehi.id == "pb_demar_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_demar_recep_vehi.disabled = false;
                    }
                    if (elt_pb_meca_recep_vehi.id == "pb_meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_meca_recep_vehi.disabled = false;
                    }
                    if (elt_sup_adblue_recep_vehi.id == "sup_adblue_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_adblue_recep_vehi.disabled = false;
                    }
                    if (elt_sup_fil_parti_recep_vehi.id == "sup_fil_parti_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_fil_parti_recep_vehi.disabled = false;
                    }
                    if (elt_sup_vanne_egr_recep_vehi.id == "sup_vanne_egr_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_vanne_egr_recep_vehi.disabled = false;
                    }
                    if (elt_dupli_cle_recep_vehi.id == "dupli_cle_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_dupli_cle_recep_vehi.disabled = false;
                    }

                    if (elt_voyant_1.id == "voyant_1") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_1.disabled = false;
                    }
                    if (elt_voyant_2.id == "voyant_2") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_2.disabled = false;
                    }
                    if (elt_voyant_3.id == "voyant_3") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_3.disabled = false;
                    }
                    if (elt_voyant_4.id == "voyant_4") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_4.disabled = false;
                    }
                    if (elt_voyant_5.id == "voyant_5") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_5.disabled = false;
                    }
                    if (elt_voyant_6.id == "voyant_6") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_6.disabled = false;
                    }
                    if (elt_voyant_7.id == "voyant_7") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_7.disabled = false;
                    }
                    if (elt_voyant_8.id == "voyant_8") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_8.disabled = false;
                    }
                    if (elt_voyant_9.id == "voyant_9") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_9.disabled = false;
                    }
                    if (elt_voyant_10.id == "voyant_10") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_10.disabled = false;
                    }
                    if (elt_voyant_11.id == "voyant_11") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_11.disabled = false;
                    }
                    if (elt_voyant_12.id == "voyant_12") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_12.disabled = false;
                    }
                    if (elt_voyant_13.id == "voyant_13") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_13.disabled = false;
                    }
                    if (elt_voyant_14.id == "voyant_14") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_14.disabled = false;
                    }
                    if (elt_voyant_15.id == "voyant_15") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_15.disabled = false;
                    }
                    if (elt_voyant_16.id == "voyant_16") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_16.disabled = false;
                    }
                    if (elt_voyant_17.id == "voyant_17") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_17.disabled = false;
                    }
                    if (elt_voyant_18.id == "voyant_18") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_18.disabled = false;
                    }
                    if (elt_voyant_19.id == "voyant_19") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_19.disabled = false;
                    }
                    if (elt_voyant_20.id == "voyant_20") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_20.disabled = false;
                    }
                    if (elt_voyant_21.id == "voyant_21") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_21.disabled = false;
                    }
                    if (elt_voyant_22.id == "voyant_22") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_22.disabled = false;
                    }
                    if (elt_voyant_23.id == "voyant_23") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_23.disabled = false;
                    }
                    if (elt_voyant_24.id == "voyant_24") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_24.disabled = false;
                    }

                }
            });

            elt_nivo_carbu_recep_vehi_1_4.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // console.log(elt_nivo_carbu_recep_vehi_0_4.checked);

                // On vérifie que l'élément ayant cet id est checked
                if (elt_nivo_carbu_recep_vehi_1_4.checked == true) {

                    // Si l'élément en question est checked, c'est que les autres éléments ne sont pas checké
                    elt_nivo_carbu_recep_vehi_0_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_2.checked = false;
                    elt_nivo_carbu_recep_vehi_3_4.checked = false;
                    elt_nivo_carbu_recep_vehi_4_4.checked = false;

                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_elec_recep_vehi.id == "elec_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_elec_recep_vehi.disabled = false;
                    }
                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_meca_recep_vehi.id == "meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_meca_recep_vehi.disabled = false;
                    }
                    if (elt_pb_electro_recep_vehi.id == "pb_electro_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_electro_recep_vehi.disabled = false;
                    }
                    if (elt_pb_demar_recep_vehi.id == "pb_demar_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_demar_recep_vehi.disabled = false;
                    }
                    if (elt_pb_meca_recep_vehi.id == "pb_meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_meca_recep_vehi.disabled = false;
                    }
                    if (elt_sup_adblue_recep_vehi.id == "sup_adblue_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_adblue_recep_vehi.disabled = false;
                    }
                    if (elt_sup_fil_parti_recep_vehi.id == "sup_fil_parti_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_fil_parti_recep_vehi.disabled = false;
                    }
                    if (elt_sup_vanne_egr_recep_vehi.id == "sup_vanne_egr_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_vanne_egr_recep_vehi.disabled = false;
                    }
                    if (elt_dupli_cle_recep_vehi.id == "dupli_cle_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_dupli_cle_recep_vehi.disabled = false;
                    }

                    if (elt_voyant_1.id == "voyant_1") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_1.disabled = false;
                    }
                    if (elt_voyant_2.id == "voyant_2") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_2.disabled = false;
                    }
                    if (elt_voyant_3.id == "voyant_3") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_3.disabled = false;
                    }
                    if (elt_voyant_4.id == "voyant_4") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_4.disabled = false;
                    }
                    if (elt_voyant_5.id == "voyant_5") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_5.disabled = false;
                    }
                    if (elt_voyant_6.id == "voyant_6") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_6.disabled = false;
                    }
                    if (elt_voyant_7.id == "voyant_7") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_7.disabled = false;
                    }
                    if (elt_voyant_8.id == "voyant_8") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_8.disabled = false;
                    }
                    if (elt_voyant_9.id == "voyant_9") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_9.disabled = false;
                    }
                    if (elt_voyant_10.id == "voyant_10") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_10.disabled = false;
                    }
                    if (elt_voyant_11.id == "voyant_11") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_11.disabled = false;
                    }
                    if (elt_voyant_12.id == "voyant_12") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_12.disabled = false;
                    }
                    if (elt_voyant_13.id == "voyant_13") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_13.disabled = false;
                    }
                    if (elt_voyant_14.id == "voyant_14") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_14.disabled = false;
                    }
                    if (elt_voyant_15.id == "voyant_15") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_15.disabled = false;
                    }
                    if (elt_voyant_16.id == "voyant_16") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_16.disabled = false;
                    }
                    if (elt_voyant_17.id == "voyant_17") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_17.disabled = false;
                    }
                    if (elt_voyant_18.id == "voyant_18") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_18.disabled = false;
                    }
                    if (elt_voyant_19.id == "voyant_19") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_19.disabled = false;
                    }
                    if (elt_voyant_20.id == "voyant_20") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_20.disabled = false;
                    }
                    if (elt_voyant_21.id == "voyant_21") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_21.disabled = false;
                    }
                    if (elt_voyant_22.id == "voyant_22") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_22.disabled = false;
                    }
                    if (elt_voyant_23.id == "voyant_23") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_23.disabled = false;
                    }
                    if (elt_voyant_24.id == "voyant_24") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_24.disabled = false;
                    }

                }
            });

            elt_nivo_carbu_recep_vehi_3_4.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // console.log(elt_nivo_carbu_recep_vehi_0_4.checked);

                // On vérifie que l'élément ayant cet id est checked
                if (elt_nivo_carbu_recep_vehi_3_4.checked == true) {

                    // Si l'élément en question est checked, c'est que les autres éléments ne sont pas checké
                    elt_nivo_carbu_recep_vehi_0_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_2.checked = false;
                    elt_nivo_carbu_recep_vehi_4_4.checked = false;

                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_elec_recep_vehi.id == "elec_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_elec_recep_vehi.disabled = false;
                    }
                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_meca_recep_vehi.id == "meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_meca_recep_vehi.disabled = false;
                    }
                    if (elt_pb_electro_recep_vehi.id == "pb_electro_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_electro_recep_vehi.disabled = false;
                    }
                    if (elt_pb_demar_recep_vehi.id == "pb_demar_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_demar_recep_vehi.disabled = false;
                    }
                    if (elt_pb_meca_recep_vehi.id == "pb_meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_meca_recep_vehi.disabled = false;
                    }
                    if (elt_sup_adblue_recep_vehi.id == "sup_adblue_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_adblue_recep_vehi.disabled = false;
                    }
                    if (elt_sup_fil_parti_recep_vehi.id == "sup_fil_parti_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_fil_parti_recep_vehi.disabled = false;
                    }
                    if (elt_sup_vanne_egr_recep_vehi.id == "sup_vanne_egr_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_vanne_egr_recep_vehi.disabled = false;
                    }
                    if (elt_dupli_cle_recep_vehi.id == "dupli_cle_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_dupli_cle_recep_vehi.disabled = false;
                    }

                    if (elt_voyant_1.id == "voyant_1") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_1.disabled = false;
                    }
                    if (elt_voyant_2.id == "voyant_2") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_2.disabled = false;
                    }
                    if (elt_voyant_3.id == "voyant_3") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_3.disabled = false;
                    }
                    if (elt_voyant_4.id == "voyant_4") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_4.disabled = false;
                    }
                    if (elt_voyant_5.id == "voyant_5") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_5.disabled = false;
                    }
                    if (elt_voyant_6.id == "voyant_6") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_6.disabled = false;
                    }
                    if (elt_voyant_7.id == "voyant_7") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_7.disabled = false;
                    }
                    if (elt_voyant_8.id == "voyant_8") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_8.disabled = false;
                    }
                    if (elt_voyant_9.id == "voyant_9") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_9.disabled = false;
                    }
                    if (elt_voyant_10.id == "voyant_10") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_10.disabled = false;
                    }
                    if (elt_voyant_11.id == "voyant_11") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_11.disabled = false;
                    }
                    if (elt_voyant_12.id == "voyant_12") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_12.disabled = false;
                    }
                    if (elt_voyant_13.id == "voyant_13") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_13.disabled = false;
                    }
                    if (elt_voyant_14.id == "voyant_14") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_14.disabled = false;
                    }
                    if (elt_voyant_15.id == "voyant_15") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_15.disabled = false;
                    }
                    if (elt_voyant_16.id == "voyant_16") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_16.disabled = false;
                    }
                    if (elt_voyant_17.id == "voyant_17") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_17.disabled = false;
                    }
                    if (elt_voyant_18.id == "voyant_18") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_18.disabled = false;
                    }
                    if (elt_voyant_19.id == "voyant_19") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_19.disabled = false;
                    }
                    if (elt_voyant_20.id == "voyant_20") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_20.disabled = false;
                    }
                    if (elt_voyant_21.id == "voyant_21") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_21.disabled = false;
                    }
                    if (elt_voyant_22.id == "voyant_22") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_22.disabled = false;
                    }
                    if (elt_voyant_23.id == "voyant_23") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_23.disabled = false;
                    }
                    if (elt_voyant_24.id == "voyant_24") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_24.disabled = false;
                    }

                }
            });

            elt_nivo_carbu_recep_vehi_4_4.addEventListener('click', function() { // On écoute l'événement click sur cet élément

                // console.log(elt_nivo_carbu_recep_vehi_0_4.checked);

                // On vérifie que l'élément ayant cet id est checked
                if (elt_nivo_carbu_recep_vehi_4_4.checked == true) {

                    // Si l'élément en question est checked, c'est que les autres éléments ne sont pas checké
                    elt_nivo_carbu_recep_vehi_0_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_4.checked = false;
                    elt_nivo_carbu_recep_vehi_1_2.checked = false;
                    elt_nivo_carbu_recep_vehi_3_4.checked = false;

                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_elec_recep_vehi.id == "elec_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_elec_recep_vehi.disabled = false;
                    }
                    // on vérifie que l'id de l'élément récupéré correspond à celui recherché
                    if (elt_meca_recep_vehi.id == "meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_meca_recep_vehi.disabled = false;
                    }
                    if (elt_pb_electro_recep_vehi.id == "pb_electro_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_electro_recep_vehi.disabled = false;
                    }
                    if (elt_pb_demar_recep_vehi.id == "pb_demar_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_demar_recep_vehi.disabled = false;
                    }
                    if (elt_pb_meca_recep_vehi.id == "pb_meca_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_pb_meca_recep_vehi.disabled = false;
                    }
                    if (elt_sup_adblue_recep_vehi.id == "sup_adblue_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_adblue_recep_vehi.disabled = false;
                    }
                    if (elt_sup_fil_parti_recep_vehi.id == "sup_fil_parti_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_fil_parti_recep_vehi.disabled = false;
                    }
                    if (elt_sup_vanne_egr_recep_vehi.id == "sup_vanne_egr_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_sup_vanne_egr_recep_vehi.disabled = false;
                    }
                    if (elt_dupli_cle_recep_vehi.id == "dupli_cle_recep_vehi") {
                        // Si c'est le cas, on le désactive
                        elt_dupli_cle_recep_vehi.disabled = false;
                    }

                    if (elt_voyant_1.id == "voyant_1") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_1.disabled = false;
                    }
                    if (elt_voyant_2.id == "voyant_2") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_2.disabled = false;
                    }
                    if (elt_voyant_3.id == "voyant_3") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_3.disabled = false;
                    }
                    if (elt_voyant_4.id == "voyant_4") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_4.disabled = false;
                    }
                    if (elt_voyant_5.id == "voyant_5") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_5.disabled = false;
                    }
                    if (elt_voyant_6.id == "voyant_6") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_6.disabled = false;
                    }
                    if (elt_voyant_7.id == "voyant_7") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_7.disabled = false;
                    }
                    if (elt_voyant_8.id == "voyant_8") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_8.disabled = false;
                    }
                    if (elt_voyant_9.id == "voyant_9") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_9.disabled = false;
                    }
                    if (elt_voyant_10.id == "voyant_10") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_10.disabled = false;
                    }
                    if (elt_voyant_11.id == "voyant_11") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_11.disabled = false;
                    }
                    if (elt_voyant_12.id == "voyant_12") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_12.disabled = false;
                    }
                    if (elt_voyant_13.id == "voyant_13") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_13.disabled = false;
                    }
                    if (elt_voyant_14.id == "voyant_14") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_14.disabled = false;
                    }
                    if (elt_voyant_15.id == "voyant_15") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_15.disabled = false;
                    }
                    if (elt_voyant_16.id == "voyant_16") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_16.disabled = false;
                    }
                    if (elt_voyant_17.id == "voyant_17") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_17.disabled = false;
                    }
                    if (elt_voyant_18.id == "voyant_18") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_18.disabled = false;
                    }
                    if (elt_voyant_19.id == "voyant_19") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_19.disabled = false;
                    }
                    if (elt_voyant_20.id == "voyant_20") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_20.disabled = false;
                    }
                    if (elt_voyant_21.id == "voyant_21") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_21.disabled = false;
                    }
                    if (elt_voyant_22.id == "voyant_22") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_22.disabled = false;
                    }
                    if (elt_voyant_23.id == "voyant_23") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_23.disabled = false;
                    }
                    if (elt_voyant_24.id == "voyant_24") {
                        // Si c'est le cas, on le désactive
                        elt_voyant_24.disabled = false;
                    }

                }
            });

        });

        function getImmaValue() {

            // On récupère l'élément immatriculation 
            var elt_immat = document.getElementById('immat');
            // on récupère le nom de domaine de l'application
            var web_url = "<?php echo WEB_URL; ?>";

            // On fait une redirection en faisant passer la valeur de l'immatriculation saisie dans l'url
            window.location.href = web_url + "repaircar/addcar_reception.php?immat=" + elt_immat.value;

        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });

        function validateMe() {
            if ($("#immat").val() == '') {
                alert("L'immatriculation du véhicule est obligatoire, saisissez la !!!");
                $("#immat").focus();
                return false;
            } else {
                return true;
            }
        }
    </script>

</body>

</html>

<?php include('../footer.php'); ?>