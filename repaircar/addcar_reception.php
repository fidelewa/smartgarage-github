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
$add_date_vidange = "";
$km_last_vidange = "";

$car_pneu_av = '';
$car_gente_ar = '';
$car_pneu_ar = '';
$car_gente_av = '';
// $add_date_visitetech = date_format(date_create('now'), 'd/m/Y');
// $add_date_assurance  = date_format(date_create('now'), 'd/m/Y');
$add_date_visitetech = "";
$add_date_assurance  = "";

$title = "Formulaire d'enregistrement et de réception d'un véhicule";
$button_text = "Enregistrer information";
$successful_msg = "Ajout du véhicule de réparation réussi";
// $form_url = WEB_URL . "repaircar/addcar.php";
$form_url = WEB_URL . "repaircar/addcar_reception_traitement.php";
$id = "";
$hdnid = "0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';

// Création de l'identifiant de réparation
$invoice_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);
$model_post_token = 0;

/*added my*/
$cus_id = 0;
if (isset($_GET['cid']) && (int) $_GET['cid'] > 0) {
  $cus_id = $_GET['cid'];
}

if (isset($_SESSION['objRecep']) && !empty($_SESSION['objRecep'])) {

  $recep_id = $_SESSION['objRecep']['user_id'];

  // Il n'y a pas que le réceptionniste qui peut réceptionner un véhicule
  // le service client peut le faire également
} else if (isset($_SESSION['objServiceClient']) && !empty($_SESSION['objServiceClient'])) {

  $recep_id = $_SESSION['objServiceClient']['user_id'];
} else {
  $recep_id = 0;
}


// var_dump($_SESSION);

// if (isset($_SESSION['immat']) && !empty($_SESSION['immat'])) { // Quand le paramètre immat existe dans l'url

//     $immat = $_SESSION['immat']; // On affecte directement sa valeur à $vin

//   } else { // Quand le paramètre immat n'existe pas dans l'url
//     $immat = ''; // on affecte la valeur de la variable de session à $vin
//   }

// if (isset($_POST['car_names'])) { // Si le nom de la voiture existe et à une valeur
//   $image_url = uploadImage();
//   if (empty($image_url)) {
//     $image_url = $_POST['img_exist'];
//   }

//   // $wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);
//   $wms->saveRecepRepairCarInformation($link, $_POST, $image_url);
//   // if((int)$_POST['repair_car'] > 0){
//   // 	$url = WEB_URL.'repaircar/carlist.php?m=up';
//   // 	header("Location: $url");
//   // } else {
//   // 	$url = WEB_URL.'repaircar/carlist.php?m=add';
//   // 	header("Location: $url");
//   // }
//   exit();
// }

if (isset($_GET['immat']) && $_GET['immat'] != '') {
  $row = $wms->getRepairCarInfoByRepairCarImma($link, $_GET['immat']);

  // var_dump($row);

  if (!empty($row)) {
    $cus_id = $row['customer_id'];
    $car_names = $row['car_name'];
    $c_make = $row['car_make'];
    $c_model = $row['car_model'];
    $c_year = $row['year'];
    $c_chasis_no = $row['chasis_no'];
    // $c_registration = $row['car_reg_no'];
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
    $hdnid = $_GET['immat'];
    // $title = 'Update Car Information';
    $button_text = "Update Information";

    //$successful_msg="Update car Successfully";
    // $form_url = WEB_URL . "repaircar/addcar.php?id=" . $_GET['id'];
  }

  //mysql_close($link);
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

$resultCarScanning = $wms->getCarScanningById($link, $_GET['vehicule_scanner_id']);
$etat_vehi_arrive = $resultCarScanning['etat_vehi_arrive'];
$scanner_mecanique = $resultCarScanning['scanner_mecanique'];
$scanner_electrique = $resultCarScanning['scanner_electrique'];

// var_dump($etat_vehi_arrive);

?>
<!-- Content Header (Page header) -->

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Formulaire d'enregistrement et de réception d'un véhicule</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
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

    /* Echaffaudage #2 */
    /* [class*="col-"] {
      border: 1px dotted rgb(0, 0, 0);
      border-radius: 1px;
    } */
  </style>

</head>

<body>

  <section class="content-header">
    <h1>Formulaire d'enregistrement et de réception d'un véhicule</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
      <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> réception d'un véhicule</a></li>
      <li class="active">réception d'un véhicule</li>
    </ol>
  </section>
  <div class="container">
    <!-- Main content -->
    <form action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="regForm">
    <!-- <form role="form" method="POST" enctype="multipart/form-data" id="regForm"> -->
      <section class="content">

        <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
          <h4><i class="icon fa fa-check"></i> Success!</h4>
          <?php echo $msg; ?>
        </div>
        <!-- One "tab" for each step in the form: -->
        <div class="tab">
          <div class="box box-success">
            <div class="box-header">
              <h3 class="box-title"><i class="fa fa-plus"></i> <?php echo $title; ?></h3>
            </div>
            <div class="box-body">
              <div class="form-group">
                <label for="vin"><span style="color:red;">*</span> Immatriculation :</label>
                <input type="text" readonly name="vin" value="<?php echo $vin ?>" id="vin" class="form-control" placeholder="Saisissez l'immatriculation de la voiture" />
              </div>
              <div class="form-group">
                <label for="ddlMake"><span style="color:red;">*</span> Marque :</label>
                <div class="row">
                  <div class="col-md-12">
                    <!-- <input type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque de la voiture"> -->
                    <?php

                    if ($hdnid == $_GET['immat']) {

                      $make_list = $wms->get_all_make_list($link);

                      foreach ($make_list as $make) {
                        if ($c_make == $make['make_id']) { ?>

                          <input type="text" readonly class='form-control' value="<?php echo $make['make_name']; ?>" name="ddlMake" id="ddlMake" placeholder="Saisissez la marque de la voiture">

                      <?php }
                        }
                      } else { ?>
                      <input type="text" class='form-control' value="<?php echo $model['model_name']; ?>" name="ddlMake" id="ddlMake" placeholder="Saisissez la marque de la voiture">
                    <?php
                    }
                    ?>
                  </div>
                  <!-- <div class="col-md-1" id="marque">
                    <a class="btn btn-success" data-toggle="modal" data-target="#marque-modal" data-original-title="Ajouter une nouvelle marque">ajouter</a> -->
                  <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting_reception.php" data-original-title="Ajouter une nouvelle marque"><i class="fa fa-plus"></i></a> -->
                  <!-- </div> -->
                </div>
              </div>
              <div class="form-group">
                <label for="ddl_model"><span style="color:red;">*</span> Modèle :</label>
                <div class="row">
                  <div class="col-md-12">
                    <!-- <input type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle de la voiture"> -->
                    <?php

                    if ($hdnid == $_GET['immat']) {

                      $model_list = $wms->get_all_model_list($link);

                      foreach ($model_list as $model) {
                        if ($c_model == $model['model_id']) { ?>

                          <input readonly type="text" class='form-control' value="<?php echo $model['model_name']; ?>" name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle de la voiture">

                      <?php }
                        }
                      } else { ?>
                      <input type="text" class='form-control' value="<?php echo $model['model_name']; ?>" name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle de la voiture">
                    <?php
                    }
                    ?>
                  </div>
                </div>
              </div>
              <!-- <div class="form-group">
                <label for="assurance_vehi_recep"><span style="color:red;">*</span> Assurance :</label>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class='form-control' name="assurance_vehi_recep" id="assurance_vehi_recep" placeholder="Saisissez l'assurance de la voiture">
                    <select class='form-control' id="assurance_vehi_recep" name="assurance_vehi_recep">
                      <option value="">--Sélectionner l'assurance du véhicule--</option>
                      <?php
                      $result = $wms->get_all_assurance_vehicule_list($link);
                      foreach ($result as $row) {
                        echo "<option value='" . $row['assur_vehi_libelle'] . "'>" . $row['assur_vehi_libelle'] . "</option>";
                      } ?>
                    </select>
                  </div>
                </div>
              </div> -->
              <div class="form-group">
                <label for="assurance_vehi_recep"><span style="color:red;">*</span> Client :<span style="color:red;"> (si le client n'existe pas encore, veuillez cliquer sur le bouton "+" pour l'enregistrer, puis saisissez son nom à nouveau)</span></label>
                <div class="row">
                  <div class="col-md-11">
                    <!-- <input onkeyup="verifClient(this.value);" type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client s'il existe déja" onfocus=""><span id="clientbox"></span> -->
                    <?php

                    if ($hdnid == $_GET['immat']) {

                      $customer_list = $wms->get_all_customer_list($link);

                      foreach ($customer_list as $customer) {
                        if ($cus_id == $customer['customer_id']) { ?>

                          <input readonly value="<?php echo $customer['c_name']; ?>" onkeyup="verifClient(this.value);" type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client s'il existe déja" onfocus=""><span id="clientbox"></span>

                      <?php }
                        }
                      } else { ?>
                      <input value="<?php echo $customer['c_name']; ?>" onkeyup="verifClient(this.value);" type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client s'il existe déja" onfocus=""><span id="clientbox"></span>
                    <?php
                    }
                    ?>
                  </div>
                  <div class="col-md-1" id="client">
                    <a class="btn btn-success" data-toggle="modal" data-target="#client-modal" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a>
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer_reception.php" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a> -->
                  </div>
                </div>
              </div>

              <input type="hidden" value="<?php echo $car_names; ?>" name="car_names" />
              <input type="hidden" value="<?php echo $recep_id; ?>" name="recep_id" />
              <input type="hidden" value="" name="txtCPassword" />
              <input type="hidden" value="" name="tel_wa" />
              <input type="hidden" value="<?php echo $hdnid; ?>" name="customer_id" />
              <input type="hidden" value="<?php echo $model_post_token; ?>" name="submit_token" />

              <!-- <div class="form-group">
                <label for="ddlYear"><span style="color:red;">*</span> Année :</label>
                <input type="text" class='form-control' name="ddlYear" id="ddlYear" placeholder="Saisissez année">
              </div> -->
              <div class="form-group">
                <label for="car_chasis_no"><span style="color:red;">*</span> Chasis No :</label>
                <input minlength="14" type="text" name="car_chasis_no" value="<?php echo $c_chasis_no; ?>" id="car_chasis_no" class="form-control" placeholder="Saisissez le numéro de chasis de la voiture">
              </div>
              <!-- <div class="form-group">
                <label for="car_note">Note :</label>
                <textarea type="text" name="car_note" value="" id="car_note" class="form-control"><?php echo $c_note; ?></textarea>
              </div> -->
              <!-- <div class="form-group">
                <label for="add_date">Date d'enregistrement:</label>
                <input readonly type="text" name="add_date" value="<?php echo $c_add_date; ?>" id="add_date" class="form-control datepicker" placeholder="veuillez cliquer pour choisir une date" />
              </div> -->
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de mise en circulation:</label>
                <input type="text" name="add_date_mise_circu" value="" id="add_date_mise_circu" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date d'immatriculation:</label>
                <input type="text" name="add_date_imma" value="" id="add_date_imma" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <!-- <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de début de l'assurance:</label>
                <input type="text" name="add_date_assurance_car" value="" id="add_date_assurance" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de fin de l'assurance:</label>
                <input type="text" name="add_date_assurance_fin" value="" id="add_date_assurance_fin" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div> -->
              <!-- <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de la prochaine visite technique:</label>
                <input type="text" name="add_date_visitetech_car" value="" id="add_date_visitetech" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div> -->
              <div class="form-group">
                <label for="add_date"> Date de dernière vidange:</label>
                <input type="text" name="add_date_derniere_vidange" value="" id="add_date_derniere_vidange" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"> Date de changement de filtre à air:</label>
                <input type="text" name="add_date_changement_filtre_air" value="" id="add_date_changement_filtre_air" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"> Date de changement de filtre à huile:</label>
                <input type="text" name="add_date_changement_filtre_huile" value="" id="add_date_changement_filtre_huile" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"> Date de changement de filtre à pollen:</label>
                <input type="text" name="add_date_changement_filtre_pollen" value="" id="add_date_changement_filtre_pollen" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <!-- <div class="form-group">
                <label for="duree_assurance"><span style="color:red;">*</span> Durée de l'assurance :</label>
                <select class='form-control' id="duree_assurance" name="duree_assurance">
                  <option value="">--Sélectionner la durée de l'assurance du véhicule--</option>
                  <option value="P1M">1 mois</option>
                  <option value="P2M">2 mois</option>
                  <option value="P3M">3 mois</option>
                  <option value="P4M">4 mois</option>
                  <option value="P5M">5 mois</option>
                  <option value="P6M">6 mois</option>
                  <option value="P7M">7 mois</option>
                  <option value="P8M">8 mois</option>
                  <option value="P9M">9 mois</option>
                  <option value="P10M">10 mois</option>
                  <option value="P11M">11 mois</option>
                  <option value="P12M">12 mois</option>
                </select>
              </div> -->

              <!-- <div class="form-group">
                <label for="km_last_vidange"><span style="color:red;">*</span> Kilométrage de dernière vidange :</label>
                <input type="text" id="km_last_vidange" maxlength="6" name="km_last_vidange" class='form-control' value="<?php echo $km_last_vidange; ?>" placeholder="Veuillez saisir le kilométrage de la dernière vidange" />
              </div> -->
              <!-- <div class="form-group">
                <label for="add_date_ctr_tech"><span style="color:red;">*</span> Date du contrôle technique:</label>
                <input type="text" name="add_date_ctr_tech" value="<?php echo $add_date_ctr_tech; ?>" id="add_date_ctr_tech" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div> -->
              <!-- <div class="form-group">
                <label for="delai_ctr_tech"><span style="color:red;">*</span> Délai du contrôle technique :</label>
                <select class='form-control' id="delai_ctr_tech" name="delai_ctr_tech">
                  <option value="">--Sélectionner le délai du contrôle technique du véhicule--</option>
                  <option value="P3M">3 mois</option>
                  <option value="P6M">6 mois</option>
                </select>
              </div> -->
              <div class="form-group">
                <label for="genre_vehi_recep"><span style="color:red;">*</span> Genre :</label>
                <select class='form-control' id="genre_vehi_recep" name="genre_vehi_recep">
                  <option value="">--Sélectionner un genre de véhicule--</option>
                  <option value="particulier">Particulier</option>
                  <option value="utilitaire">Utilitaire</option>
                  <option value="berline">Berline</option>
                  <option value="suv">SUV</option>
                  <option value="pick-up">Pick-up</option>
                  <option value="autre">Autre</option>
                </select>
              </div>

              <div class="form-group">
                <label for="energie_vehi_recep"><span style="color:red;">*</span> Energie :</label>
                <select class='form-control' id="energie_vehi_recep" name="energie_vehi_recep">
                  <option value="">--Sélectionner le type de carburant du véhicule--</option>
                  <option value="essence">Essence</option>
                  <option value="gasoil">Gasoil</option>
                  <option value="diesel">Diesel</option>
                  <option value="hybride">Hybride</option>
                  <option value="autre">Autre</option>
                </select>
              </div>

              <div class="form-group">
                <label for="boite_vitesse_vehi_recep"><span style="color:red;">*</span> Boite vitesse :</label>
                <select class='form-control' id="boite_vitesse_vehi_recep" name="boite_vitesse_vehi_recep">
                  <option value="">--Sélectionner le type de boite de vitesse--</option>
                  <option value="automatique">Automatique</option>
                  <option value="semi-automatique">Semi-Automatique</option>
                  <option value="manuel">Manuel</option>
                  <option value="hybride">Hybride</option>
                </select>
              </div>

              <div class="form-group">
                <label for="nb_cylindre"><span style="color:red;">*</span> Nombre de cylindre :</label>
                <input type="number" id="nb_cylindre" name="nb_cylindre" min="0" max="100" class='form-control'>
              </div>

              <div class="form-group">
                <label for="couleur_vehi"><span style="color:red;">*</span> Couleur :</label>
                <!-- <input type="text" name="couleur_vehi" value="" id="couleur_vehi" class="form-control" /> -->
                <select class='form-control' id="couleur_vehi" name="couleur_vehi">
                  <option value="">--Sélectionner la couleur de votre voiture--</option>
                  <option value="bleu">Bleu</option>
                  <option value="rouge">Rouge</option>
                  <option value="jaune">Jaune</option>
                  <option value="orange">Orange</option>
                  <option value="noir">Noir</option>
                  <option value="marron">Marron</option>
                  <option value="vert">Vert</option>
                  <option value="blanc">Blanc</option>
                  <option value="gris">Gris</option>
                  <option value="rose">Rose</option>
                  <option value="violet">Violet</option>
                  <option value="autre">Autre</option>
                </select>
              </div>

              <div class="form-group">
                <label for="fisc_vehi"><span style="color:red;">*</span> Puissance fiscale</label>
                <input type="text" name="fisc_vehi" value="" id="fisc_vehi" class="form-control" />
              </div>

              <div class="form-group">
                <label for="Prsnttxtarea">Visualiser l'image du véhicule :</label>
                <img class="form-control" src="<?php echo $image_cus; ?>" style="height:100px;width:100px;" id="output" />
                <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
              </div>
              <div class="form-group"> <span class="btn btn-file btn btn-primary">Uploader l'image de la voiture
                  <input type="file" name="uploaded_file" onchange="loadFile(event)" />
                </span> </div>
              <fieldset>
                <legend>Ajouter des fichiers joints</legend>
                <div class="row">
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_7_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_8_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_9_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_10_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_11_car" />
                    </span>
                  </div>
                  <div class="col-sm-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_12_car" />
                    </span>
                  </div>
                </div>
              </fieldset>
            </div>
            <input type="hidden" value="<?php echo $hdnid; ?>" name="repair_car" />
            <input type="hidden" name="hfInvoiceId" value="<?php echo $invoice_id; ?>" />
            <div class="box-body">
              <div class="form-group col-md-12" style="padding-top:10px;">
                <!-- <div class="pull-left">
                  <label class="label label-danger" style="font-size:15px;"><i class="fa fa-car"></i> Voiture de réparation ID-<?php echo $invoice_id; ?></label>
                </div> -->

              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="tab">
          <h1 style="text-align:center;">Prise en charge</h1>

          <div class="form-group row">
            <label for="heure_reception" class="col-md-3 col-form-label">Date de réception du véhicule</label>
            <div class="col-md-9" style="padding-left:0px;">
              <input type="text" name="add_date" value="<?php echo date_format(date_create('now'), 'd/m/Y'); ?>" id="add_date" class="form-control datepicker" placeholder="Saisissez la date de reception du véhicule" />
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group row">
              <label for="heure_reception" class="col-md-3 col-form-label">Heure</label>
              <div class="col-md-9" style="padding-left:0px;">
                <input type="text" id="heure_reception" name="heure_reception" value="<?php echo date_format(date_create('now'), 'H:i:s'); ?>" class="bootstrap-timepicker form-control">
              </div>
            </div>

            <div class="form-group row">
              <label for="km_reception_vehi" class="col-md-3 col-form-label"><span style="color:red;">*</span> Kilométrage</label>
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
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Niveau de carburant</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_0_4" value="0/4">
                <label class="form-check-label">0/4</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_1_4" value="1/4">
                <label class="form-check-label">1/4</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_1_2" value="1/2">
                <label class="form-check-label">1/2</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_3_4" value="3/4">
                <label class="form-check-label">3/4</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="nivo_carbu_recep_vehi" id="nivo_carbu_recep_vehi_4_4" value="4/4">
                <label class="form-check-label">4/4</label>
              </div>
            </div>


            <hr>

            <div class="form-group row">
              <div class="col-md-3">
                <input type="checkbox" id="cle_recep_vehi" name="cle_recep_vehi" value="Clé du véhicule" class="form-check-input" />
                <label for="clé du véhicule"><span style="color:red;">*</span> Clé du véhicule</label>
              </div>
              <div class="col-md-9" style="padding-left:0px;">
                <input type="number" min="0" max="100" name="cle_recep_vehi_text" id="cle_recep_vehi_text" class="form-control" placeholder="Veuillez renseigner le nombre de clé du véhicule" />
              </div>
            </div>

            <!-- CARTE GRISE -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Carte grise</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="carte_grise_recep_vehi" id="carte_grise_recep_vehi_oui" value="Carte grise">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="carte_grise_recep_vehi" id="carte_grise_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="carte_grise_box">
                <!-- <div class="col-md-4 form-check" style="padding-left:0px;">
                  <input class="form-check-input form-control" type="text" name="carte_grise_numero" id="carte_grise_numero" value="" placeholder="Renseigner le numéro de la carte grise">
                </div> -->
                <div class="col-md-6 form-check" style="padding-left:0px;">
                  <span class="btn btn-file btn btn-primary">Ajouter la pièce de la carte grise<input type="file" name="pj_carte_grise" id="pj_carte_grise" />
                  </span>
                </div>
              </div>
            </div>

            <!-- VISITE TECHNIQUE -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Visite technique</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="visitetech_recep_vehi" id="visite_tech_recep_vehi_oui" value="Visite technique">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="visitetech_recep_vehi" id="visite_tech_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="visite_tech_box">
                <div class="col-md-7 form-check" style="padding-left:0px;">
                  <!-- <input style="margin-bottom:5px;" class="form-check-input form-control" type="text" name="visite_tech_numero" id="visite_tech_numero" value="" placeholder="Renseigner le numéro de la visite technique SVP"> -->
                  <input style="margin-bottom:5px;" class="form-control datepicker" type="text" name="add_date_visitetech_car" id="add_date_visitetech_car" value="" placeholder="Cliquez pour choisir la date d'expiration de la visite technique SVP">
                  <span style="margin-bottom:5px;" class="btn btn-file btn btn-primary">Ajouter la pièce de la visite technique<input type="file" name="pj_visite_tech" id="pj_visite_tech" />
                  </span>
                </div>
              </div>
            </div>

            <!-- ASSURANCE -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Assurance</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="assur_recep_vehi" id="assurance_recep_vehi_oui" value="Assurance">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="assur_recep_vehi" id="assurance_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="assurance_box">
                <div class="col-md-7 form-check" style="padding-left:0px;">
                  <!-- <input style="margin-bottom:5px;" class="form-check-input form-control" type="text" name="assurance_numero" id="assurance_numero" value="" placeholder="Saisissez le numéro de l'assurance du véhicule SVP"> -->
                  <input style="margin-bottom:5px;" type="text" class='form-control' name="assurance_vehi_recep" id="assurance_vehi_recep" placeholder="Saisissez le nom de l'assurance du véhicule">
                  <input style="margin-bottom:5px;" type="text" name="add_date_assurance_car" value="" id="add_date_assurance" class="form-control datepicker" placeholder="Veuillez sélectionner la date de début de l'assurance" />
                  <input style="margin-bottom:5px;" type="text" name="add_date_assurance_fin" value="" id="add_date_assurance_fin" class="form-control datepicker" placeholder="Veuillez sélectionner la date de fin de l'assurance" />
                  <span style="margin-bottom:5px;" class="btn btn-file btn btn-primary">Ajouter la pièce de l'assurance<input type="file" name="pj_assurance" id="pj_assurance" />
                  </span>
                </div>
              </div>
            </div>

            <!-- ASSURANCE CEDEAO -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Assurance CEDEAO</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="assurance_cedeao_recep_vehi" id="assurance_cedeao_recep_vehi_oui" value="Assurance CEDEAO">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="assurance_cedeao_recep_vehi" id="assurance_cedeao_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="assurance_cedeao_box">
                <div class="col-md-6 form-check" style="padding-left:0px;">
                  <span class="btn btn-file btn btn-primary">Ajouter la pièce de l'assurance CEDEAO<input type="file" name="pj_assurance_cedeao" id="pj_assurance_cedeao" />
                  </span>
                </div>
              </div>
            </div>

            <!-- CONTRAT ASSURANCE -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Contrat d'assurance</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="contrat_assurance_recep_vehi" id="contrat_assurance_recep_vehi_oui" value="Contrat asurance">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="contrat_assurance_recep_vehi" id="contrat_assurance_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="contrat_assurance_box">
                <div class="col-md-6 form-check" style="padding-left:0px;">
                  <span class="btn btn-file btn btn-primary">Ajouter la pièce du contrat d'assurance<input type="file" name="pj_contrat_assurance" id="pj_contrat_assurance" />
                  </span>
                </div>
              </div>
            </div>

            <!-- AUTRES PIECES -->
            <div class="form-group row">
              <label class="col-md-3 col-form-label"><span style="color:red;">*</span> Autres pièces</label>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="otre_piece_recep_vehi" id="otre_piece_recep_vehi_oui" value="Autres pièces">
                <label class="form-check-label">OUI</label>
              </div>
              <div class="col-md-1 form-check" style="padding-left:0px;">
                <input class="form-check-input" type="radio" name="otre_piece_recep_vehi" id="otre_piece_recep_vehi_non" value="">
                <label class="form-check-label">NON</label>
              </div>
              <div id="otre_piece_box">
                <div class="col-md-7 form-check" style="padding-left:0px;">
                  <input style="margin-bottom:5px;" class="form-check-input form-control" type="text" name="otre_piece_numero" id="otre_piece_numero" value="" placeholder="Renseigner le numéro de la pièce SVP">
                  <input style="margin-bottom:5px;" class="form-control datepicker" type="text" name="date_otre_piece_recep_vehi" id="date_otre_piece_recep_vehir" value="" placeholder="Cliquez pour sélectionner la date d'expiration de la pièce SVP">
                  <span style="margin-bottom:5px;" class="btn btn-file btn btn-primary">Ajouter la pièce<input type="file" name="pj_otre_piece" id="pj_otre_piece" />
                  </span>
                </div>
              </div>
            </div>

          </div>

          <input type="hidden" name="add_date_assurance" value="<?php echo $add_date_assurance; ?>" id="add_date_assurance" class="datepicker form-control" />
          <input type="hidden" name="add_date_visitetech" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="datepicker form-control" />
          <input type="hidden" value="<?php echo $_GET['vehicule_scanner_id']; ?>" name="vehicule_scanner_id" />

          <!-- <div class="container" id="date_assurance_visitetech" style="width:auto;">
            <div class="form-group row">
              <div class="col-md-3">
                <input type="checkbox" id="assur_recep_vehi" name="assur_recep_vehi" value="Assurance" class="form-check-input">
                <label for="assurance"><span style="color:red;">*</span> Assurance</label>
              </div>
              <div class="col-md-9" style="padding-left:0px;" id="date_assurance">
                <input type="hidden" name="add_date_assurance" value="<?php echo $add_date_assurance; ?>" id="add_date_assurance" class="datepicker form-control" />
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-3">
                <input type="checkbox" id="visitetech_recep_vehi" name="visitetech_recep_vehi" value="Visite technique">
                <label for="visite technique"><span pstyle="color:red;">*</span> Visite technique</label>
              </div>
              <div class="col-md-9" style="padding-left:0px;" id="date_visitetech">
                <input type="hidden" name="add_date_visitetech" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="datepicker form-control" />
              </div>
            </div>
          </div> -->
          <!-- </div> -->
          <!-- <div class="tab"> -->
          <h1 style="text-align:center;">Accessoires véhicule</h1>

          <div class="form-group row">
            <div class="col-md-3">

              <label for="cric_levage_recep_vehi"><span style="color:red;">*</span> Cric de levage</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cric_levage_recep_vehi" id="cric_levage_recep_vehi_oui" value="Cric de levage">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cric_levage_recep_vehi" id="cric_levage_recep_vehi_non" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="cle_roue" name="cle_roue" value="Clé de roue"> -->
              <label for="cle_roue"><span style="color:red;">*</span> Clé de roue</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cle_roue" value="Clé de roue">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-4 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cle_roue" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="rallonge_roue_recep_vehi" name="rallonge_roue_recep_vehi" value="Rallonge de la roue"> -->
              <label for="rallonge_roue_recep_vehi"><span style="color:red;">*</span> Rallonge de la roue</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="rallonge_roue_recep_vehi" value="Rallonge de la roue">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="rallonge_roue_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="pneu_secours" name="pneu_secours" value="Pneu secours"> -->
              <label for="pneu_secours"><span style="color:red;">*</span> Pneu secours</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pneu_secours" value="Pneu secours">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pneu_secours" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-3">
              <!-- <input type="checkbox" id="anneau_remorquage_recep_vehi" name="anneau_remorquage_recep_vehi" value="Anneau de remorquage"> -->
              <label for="anneau_remorquage_recep_vehi"><span style="color:red;">*</span> Anneau de remorquage</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="anneau_remorquage_recep_vehi" value="Anneau de remorquage">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="anneau_remorquage_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="triangle" name="triangle" value="Triangle"> -->
              <label for="triangle"><span style="color:red;">*</span> Triangle</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="triangle" value="Triangle">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="triangle" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="boite_pharma" name="boite_pharma" value="Boite pharmaceutique"> -->
              <label for="boite_pharma"><span style="color:red;">*</span> Boite pharmaceutique</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="boite_pharma" value="Boite pharmaceutique">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="boite_pharma" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-3">
              <!-- <input type="checkbox" id="extincteur" name="extincteur" value="Extincteur"> -->
              <label for="extincteur"><span style="color:red;">*</span> Extincteur</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="extincteur" value="Extincteur">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="extincteur" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>
          <div class="form-group row">
            <label for="remarque_access_vehi" class="col-md-2 col-form-label"><span style="color:red;">*</span> Remarque du réceptionniste sur le véhicule :</label>
            <div class="col-md-10" style="padding-left:0px;">
              <textarea class="form-control" rows="4" name="remarque_access_vehi" id="remarque_access_vehi"></textarea>
            </div>
          </div>

          <fieldset>
            <legend>Ajouter les photos des accessoires du véhicule en pièces jointes</legend>
            <div class="row">
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 1<input type="file" name="pj_access_1" />
                </span>
              </div>
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 2<input type="file" name="pj_access_2" />
                </span>
              </div>
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 3<input type="file" name="pj_access_3" />
                </span>
              </div>
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 4<input type="file" name="pj_access_4" />
                </span>
              </div>
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 5<input type="file" name="pj_access_5" />
                </span>
              </div>
              <div class="col-md-2">
                <span class="btn btn-file btn btn-primary">Accessoire 6<input type="file" name="pj_access_6" />
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
              <input type="checkbox" id="scanner_recep_vehi" name="scanner_recep_vehi" value="Scanner">
              <label for="scanner_recep_vehi">Scanner</label>
            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="elec_recep_vehi" name="elec_recep_vehi" value="Electrique"> -->
              <label for="elec_recep_vehi"><span style="color:red;">*</span> Electrique</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="elec_recep_vehi" id="elec_recep_vehi_oui" value="Electrique">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="elec_recep_vehi" id="elec_recep_vehi_non" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="meca_recep_vehi" name="meca_recep_vehi" value="Mecanique"> -->
              <label for="mecanique"><span style="color:red;">*</span> Mécanique</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="meca_recep_vehi" id="meca_recep_vehi_oui" value="Mecanique">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="meca_recep_vehi" id="meca_recep_vehi_non" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <!-- <input type="checkbox" id="pb_electro_recep_vehi" name="pb_electro_recep_vehi" value="Problèmes électroniques"> -->
              <label for="problèmes électroniques"><span style="color:red;">*</span> Problèmes électroniques</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_electro_recep_vehi" value="Problèmes électroniques">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_electro_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="pb_demar_recep_vehi" name="pb_demar_recep_vehi" value="Problèmes de démarrage"> -->
              <label for="problèmes de démarrage"><span style="color:red;">*</span> Problèmes de démarrage</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_demar_recep_vehi" value="Problèmes de démarrage">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_demar_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="pb_meca_recep_vehi" name="pb_meca_recep_vehi" value="Problèmes mécaniques"> -->
              <label for="problèmes mécaniques"><span style="color:red;">*</span> Problèmes mécaniques</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_meca_recep_vehi" value="Problèmes mécaniques">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pb_meca_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-4">
              <!-- <input type="checkbox" id="conf_cle_recep_vehi" name="conf_cle_recep_vehi" value="Confection de clé"> -->
              <label for="confection de clé"><span style="color:red;">*</span> Confection de clé</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="conf_cle_recep_vehi" value="Confection de clé">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="conf_cle_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="sup_adblue_recep_vehi" name="sup_adblue_recep_vehi" value="Suppression adblue"> -->

              <label for="suppression adblue"><span style="color:red;">*</span> Suppression adblue</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_adblue_recep_vehi" value="Suppression adblue">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_adblue_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="sup_fil_parti_recep_vehi" name="sup_fil_parti_recep_vehi" value="Suppression filtre à particule"> -->
              <label for="suppression filtre à particule"><span style="color:red;">*</span> Suppression filtre à particule</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_fil_parti_recep_vehi" value="Suppression filtre à particule">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_fil_parti_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>
          <div class="form-group row">
            <div class="col-md-4">
              <!-- <input type="checkbox" id="dupli_cle_recep_vehi" name="dupli_cle_recep_vehi" value="Duplication de clé"> -->
              <label for="duplication de clé"><span style="color:red;">*</span> Duplication de clé</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="dupli_cle_recep_vehi" value="Duplication de clé">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="dupli_cle_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
            <div class="col-md-4">
              <!-- <input type="checkbox" id="sup_vanne_egr_recep_vehi" name="sup_vanne_egr_recep_vehi" value="Suppression de vanne EGR"> -->
              <label for="Suppression de vanne EGR"><span style="color:red;">*</span> Suppression de vanne EGR</label>

              <div class="form-group row">
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_vanne_egr_recep_vehi" value="Suppression de vanne EGR">
                  <label class="form-check-label">OUI</label>
                </div>
                <div class="col-md-3 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="sup_vanne_egr_recep_vehi" value="">
                  <label class="form-check-label">NON</label>
                </div>
              </div>

            </div>
          </div>

          <div class="form-group row" id="voyant_box">
            <div class="col-md-12">
              <div class="row">
                <label for="voyants allumés">Voyants allumés</label>
                <p style="color:red; font-style:italic">NB: Veuillez sélectionner le ou les voyants allumés</p>
              </div>
              <div class="row">
                <div class="col-md-2" style="display:flex;flex-direction:row">
                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_1.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_1" value="img/voyants_auto/voyant_1.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_1" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_2.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_2" value="img/voyants_auto/voyant_2.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_2" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_3.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_3" value="img/voyants_auto/voyant_3.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_3" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- <input type="checkbox" id="voyant_3" name="voyant_3" value="img/voyants_auto/voyant_3.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_3.png" alt="" height="44" width="46"> -->
                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_4" name="voyant_4" value="img/voyants_auto/voyant_4.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_4.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_4.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_4" value="img/voyants_auto/voyant_4.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_4" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_5" name="voyant_5" value="img/voyants_auto/voyant_5.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_5.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_5.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_5" value="img/voyants_auto/voyant_5.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_5" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_6" name="voyant_6" value="img/voyants_auto/voyant_6.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_6.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_6.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_6" value="img/voyants_auto/voyant_6.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_6" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_7" name="voyant_7" value="img/voyants_auto/voyant_7.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_7.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_7.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_7" value="img/voyants_auto/voyant_7.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_7" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_8" name="voyant_8" value="img/voyants_auto/voyant_8.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_8.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_8.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_8" value="img/voyants_auto/voyant_8.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_8" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_9" name="voyant_9" value="img/voyants_auto/voyant_9.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_9.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_9.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_9" value="img/voyants_auto/voyant_9.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_9" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_10" name="voyant_10" value="img/voyants_auto/voyant_10.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_10.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_10.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_10" value="img/voyants_auto/voyant_10.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_10" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_11" name="voyant_11" value="img/voyants_auto/voyant_11.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_11.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_11.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_11" value="img/voyants_auto/voyant_11.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_11" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_12" name="voyant_12" value="img/voyants_auto/voyant_12.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_12.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_12.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_12" value="img/voyants_auto/voyant_12.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_12" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_13" name="voyant_13" value="img/voyants_auto/voyant_13.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_13.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_13.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_13" value="img/voyants_auto/voyant_13.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_13" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_14" name="voyant_14" value="img/voyants_auto/voyant_14.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_14.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_14.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_14" value="img/voyants_auto/voyant_14.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_14" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_15" name="voyant_15" value="img/voyants_auto/voyant_15.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_15.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_15.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_15" value="img/voyants_auto/voyant_15.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_15" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_16" name="voyant_16" value="img/voyants_auto/voyant_16.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_16.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_16.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_16" value="img/voyants_auto/voyant_16.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_16" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_17" name="voyant_17" value="img/voyants_auto/voyant_17.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_17.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_17.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_17" value="img/voyants_auto/voyant_17.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_17" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_18" name="voyant_18" value="img/voyants_auto/voyant_18.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_18.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_18.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_18" value="img/voyants_auto/voyant_18.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_18" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="row">
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_19" name="voyant_19" value="img/voyants_auto/voyant_19.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_19.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_19.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_19" value="img/voyants_auto/voyant_19.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_19" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_20" name="voyant_20" value="img/voyants_auto/voyant_20.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_20.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_20.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_20" value="img/voyants_auto/voyant_20.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_20" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_21" name="voyant_21" value="img/voyants_auto/voyant_21.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_21.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_21.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_21" value="img/voyants_auto/voyant_21.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_21" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_22" name="voyant_22" value="img/voyants_auto/voyant_22.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_22.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_22.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_22" value="img/voyants_auto/voyant_22.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_22" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_23" name="voyant_23" value="img/voyants_auto/voyant_23.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_23.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_23.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_23" value="img/voyants_auto/voyant_23.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_23" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="col-md-2" style="display:flex;flex-direction:row;">
                  <!-- <input type="checkbox" id="voyant_24" name="voyant_24" value="img/voyants_auto/voyant_24.png">
                  <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_24.png" alt="" height="44" width="46"> -->

                  <div class="row">
                    <div class="col-md-6">
                      <!-- <input type="checkbox" id="voyant_1" name="voyant_1" value="img/voyants_auto/voyant_1.png"> -->
                      <img src="<?php echo WEB_URL ?>img/voyants_auto/voyant_24.png" alt="" height="44" width="46">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group row">
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_24" value="img/voyants_auto/voyant_24.png">
                          <label class="form-check-label">OUI</label>
                        </div>
                        <div class="col-md-6 form-check" style="padding-left:0px;">
                          <input class="form-check-input" type="radio" name="voyant_24" value="">
                          <label class="form-check-label">NON</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-group row">
            <label for="remarque_motif_depot" class="col-md-2 col-form-label"><span style="color:red;">*</span> Remarque autres voyants allumés :</label>
            <div class="col-md-10" style="padding-left:0px;">
              <textarea class="form-control" id="remarque_motif_depot" rows="4" name="remarque_motif_depot" id="remarque_motif_depot"></textarea>
            </div>
          </div>

          <fieldset>
            <legend>Ajouter des photos du tableau de bord en pièces jointes</legend>
            <div class="row">
              <div class="col-md-1">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_voyants_1" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_voyants_2" />
                </span>
              </div>
            </div>
          </fieldset>
        </div>
        <div class="tab">
          <h1 style="text-align:center;">Etat du véhicule à l'arrivée</h1>

          <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre véhicule</p>

          <div class="form-group row">
            <div class="col-md-6">
              <input type="radio" id="etat_proprete_arrivee_1" name="etat_proprete_arrivee" value="Propre">
              <label for="propre">Propre</label>
            </div>
            <div class="col-md-6">
              <input type="radio" id="etat_proprete_arrivee_3" name="etat_proprete_arrivee" value="Poussiéreuse">
              <label for="poussiereuse">Poussiéreuse</label>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-md-6">
              <input type="radio" id="etat_vehi_arrive_conduit" name="etat_vehi_arrive" value="Conduit">
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
            <label for="remarque_etat_vehi_arrive" class="col-md-2 col-form-label"><span style="color:red;">*</span> Remarque du réceptionniste sur le véhicule :</label>
            <div class="col-md-10" style="padding-left:0px;">
              <textarea class="form-control" id="remarque_etat_vehi_arrive" rows="4" name="remarque_etat_vehi_arrive"></textarea>
            </div>
          </div>

          <!-- </div> -->
          <!-- <div class="tab"> -->
          <h1 style="text-align:center;">Aspect extérieur</h1>
          <h6>B:bon, M:mauvais, A:absent, R:remorquage</h6>
          <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre composant</p>
          <div class="row">
            <!-- debut row -->

            <div class="col-md-6">
              <!-- debut gauche -->

              <!-- Pare brise avant -->
              <div class="form-group row">
                <label for="pare_brise_avant" class="col-md-4 col-form-label">Pare brise avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant_b" value="Bon">
                  <label class="form-check-label" for="pare_brise_avant">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant_m" value="Mauvais">
                  <label class="form-check-label" for="pare_brise_avant">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant_a" value="Absent">
                  <label class="form-check-label" for="pare_brise_avant">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_avant" id="pare_brise_avant_r" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Phare gauche -->
              <div class="form-group row">
                <label for="phare_gauche" class="col-md-4 col-form-label">Phare gauche</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche_b" value="Bon">
                  <label class="form-check-label" for="phare_gauche">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche_m" value="Mauvais">
                  <label class="form-check-label" for="phare_gauche">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche_a" value="Absent">
                  <label class="form-check-label" for="phare_gauche">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_gauche" id="phare_gauche" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Clignotant droit -->
              <div class="form-group row">
                <label for="clignotant_droit" class="col-md-4 col-form-label">Clignotant droit</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit_b" value="Bon">
                  <label class="form-check-label" for="clignotant_droit">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit_m" value="Mauvais">
                  <label class="form-check-label" for="clignotant_droit">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit_a" value="Absent">
                  <label class="form-check-label" for="clignotant_droit">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_droit" id="clignotant_droit_r" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Pare choc avant -->
              <div class="form-group row">
                <label for="pare_choc_avant" class="col-md-4 col-form-label">Pare choc avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_choc_avant" id="pare_choc_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_choc_avant" id="pare_choc_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Feu avant -->
              <div class="form-group row">
                <label for="feu_avant" class="col-md-4 col-form-label">Feu avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_avant" id="feu_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_avant" id="feu_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Vitres avant -->
              <div class="form-group row">
                <label for="vitre_avant" class="col-md-4 col-form-label">Vitres avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="vitre_avant" id="vitre_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="vitre_avant" id="vitre_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Poignet avant -->
              <div class="form-group row">
                <label for="poignet_avant" class="col-md-4 col-form-label">Poignet avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_avant" id="poignet_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_avant" id="poignet_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Plaque avant -->
              <div class="form-group row">
                <label for="plaque_avant" class="col-md-4 col-form-label">Plaque avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="plaque_avant" id="plaque_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="plaque_avant" id="plaque_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Feu de brouillard -->
              <div class="form-group row">
                <label for="feu_brouillard" class="col-md-4 col-form-label">Feu de brouillard</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_brouillard" id="feu_brouillard" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_brouillard" id="feu_brouillard" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Balai essuie glace -->
              <div class="form-group row">
                <label for="balai_essuie_glace" class="col-md-4 col-form-label">Balai essuie glace</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="balai_essuie_glace" id="balai_essuie_glace" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="balai_essuie_glace" id="balai_essuie_glace" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Rétroviseur gauche -->
              <div class="form-group row">
                <label for="retroviseur_gauche" class="col-md-4 col-form-label">Rétroviseur gauche</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_gauche" id="retroviseur_gauche" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_gauche" id="retroviseur_gauche" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Symbole avant -->
              <div class="form-group row">
                <label for="symbole_avant" class="col-md-4 col-form-label">Symbole avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="symbole_avant" id="symbole_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="symbole_avant" id="symbole_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Poignet de capot -->
              <div class="form-group row">
                <label for="poignet_capot" class="col-md-4 col-form-label">Poignet de capot</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_capot" id="poignet_capot" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_capot" id="poignet_capot" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Alternateur -->
              <div class="form-group row">
                <label for="alternateur" class="col-md-4 col-form-label">Alternateur</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="alternateur" id="alternateur" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="alternateur" id="alternateur" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Climatisation -->
              <div class="form-group row">
                <label for="climatisation" class="col-md-4 col-form-label">Climatisation</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="climatisation" id="climatisation" value="Bon">
                  <label class="form-check-label" for="climatisation">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="climatisation" id="climatisation" value="Mauvais">
                  <label class="form-check-label" for="climatisation">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="climatisation" id="climatisation" value="Absent">
                  <label class="form-check-label" for="climatisation">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="climatisation" id="climatisation" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

            </div> <!-- fin gauche -->

            <div class="col-md-6">
              <!-- debut droit -->

              <!-- Pare brise arrière -->
              <div class="form-group row">
                <label for="pare_brise_arriere" class="col-md-4 col-form-label">Pare brise arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_arriere" id="pare_brise_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_brise_arriere" id="pare_brise_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Phare droit -->
              <div class="form-group row">
                <label for="phare_droit" class="col-md-4 col-form-label">Phare droit</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_droit" id="phare_droit" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="phare_droit" id="phare_droit" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Clignotant gauche -->
              <div class="form-group row">
                <label for="clignotant_gauche" class="col-md-4 col-form-label">Clignotant gauche</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_gauche" id="clignotant_gauche" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="clignotant_gauche" id="clignotant_gauche" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Pare choc arrière -->
              <div class="form-group row">
                <label for="pare_choc_arriere" class="col-md-4 col-form-label">Pare choc arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_choc_arriere" id="pare_choc_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="pare_choc_arriere" id="pare_choc_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Feu arrière -->
              <div class="form-group row">
                <label for="feu_arriere" class="col-md-4 col-form-label">Feu arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_arriere" id="feu_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="feu_arriere" id="feu_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Vitres arrière -->
              <div class="form-group row">
                <label for="vitre_arriere" class="col-md-4 col-form-label">Vitres arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="vitre_arriere" id="vitre_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="vitre_arriere" id="vitre_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Poignet arrière -->
              <div class="form-group row">
                <label for="poignet_arriere" class="col-md-4 col-form-label">Poignet arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_arriere" id="poignet_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poignet_arriere" id="poignet_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Plaque arrière -->
              <div class="form-group row">
                <label for="plaque_arriere" class="col-md-4 col-form-label">Plaque arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="plaque_arriere" id="plaque_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="plaque_arriere" id="plaque_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Contrôle pneu -->
              <div class="form-group row">
                <label for="controle_pneu" class="col-md-4 col-form-label">Contrôle pneu</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="controle_pneu" id="controle_pneu" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="controle_pneu" id="controle_pneu" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Batterie -->
              <div class="form-group row">
                <label for="batterie" class="col-md-4 col-form-label">Batterie</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="batterie" id="batterie" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="batterie" id="batterie" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Rétroviseur droit -->
              <div class="form-group row">
                <label for="retroviseur_droit" class="col-md-4 col-form-label">Rétroviseur droit</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_droit" id="retroviseur_droit" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_droit" id="retroviseur_droit" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Symbole arrière -->
              <div class="form-group row">
                <label for="symbole_arriere" class="col-md-4 col-form-label">Symbole arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="symbole_arriere" id="symbole_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="symbole_arriere" id="symbole_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Cache moteur -->
              <div class="form-group row">
                <label for="cache_moteur" class="col-md-4 col-form-label">Cache moteur</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cache_moteur" id="cache_moteur" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="cache_moteur" id="cache_moteur" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Suspension -->
              <div class="form-group row">
                <label for="suspension" class="col-md-4 col-form-label">Suspension</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="suspension" id="suspension" value="Bon">
                  <label class="form-check-label" for="suspension">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="suspension" id="suspension" value="Mauvais">
                  <label class="form-check-label" for="suspension">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="suspension" id="suspension" value="Absent">
                  <label class="form-check-label" for="suspension">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="suspension" id="suspension" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Etat carosserie -->
              <div class="form-group row">
                <label for="cache_moteur" class="col-md-4 col-form-label">Etat carosserie</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="etat_carosserie" id="etat_carosserier" value="Bon">
                  <label class="form-check-label" for="etat_carosserie">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="etat_carosserie" id="etat_carosserier" value="Mauvais">
                  <label class="form-check-label" for="etat_carosserie">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="etat_carosserie" id="etat_carosserie" value="Absent">
                  <label class="form-check-label" for="etat_carosserie">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="etat_carosserie" id="etat_carosserie" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

            </div> <!-- fin droit-->

          </div> <!-- fin row -->

          <div class="form-group row">
            <label for="remarque_aspect_ext" class="col-md-2 col-form-label"><span style="color:red;">*</span> Dimensions du pneu</label>
            <div class="col-md-10" style="padding-left:0px;">
              <input type="text" name="dim_pneu" id="dim_pneu" class="form-control" />
            </div>
          </div>

          <div class="form-group row">
            <label for="remarque_aspect_ext" class="col-md-2 col-form-label"><span style="color:red;">*</span> Remarque du réceptionniste sur le véhicule :</label>
            <div class="col-md-10" style="padding-left:0px;">
              <textarea class="form-control" id="remarque_aspect_ext" rows="4" name="remarque_aspect_ext" id="remarque_aspect_ext"></textarea>
            </div>
          </div>

          <fieldset>
            <legend>Ajouter des fichiers joints</legend>
            <div class="row">
              <div class="col-md-1">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_7_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_8_recep" />
                </span>
              </div>
            </div>
          </fieldset>
          <!-- </div> -->
          <!-- <div class="tab"> -->
          <h1 style="text-align:center;">Aspect intérieur</h1>
          <h6>B:bon, M:mauvais, A:absent, R:remorquage</h6>
          <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre composant</p>
          <div class="row">
            <!-- debut row -->
            <div class="col-md-6">
              <!-- debut gauche -->

              <!-- Poste auto -->
              <div class="form-group row">
                <label for="poste_auto" class="col-md-4 col-form-label">Poste auto</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poste_auto" id="poste_auto" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="poste_auto" id="poste_auto" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Coffre à gant -->
              <div class="form-group row">
                <label for="coffre_gant" class="col-md-4 col-form-label">Coffre à gant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="coffre_gant" id="coffre_gant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="coffre_gant" id="coffre_gant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Tapis plafond -->
              <div class="form-group row">
                <label for="tapis_plafond" class="col-md-4 col-form-label">Tapis plafond</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tapis_plafond" id="tapis_plafond" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tapis_plafond" id="tapis_plafond" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Ecran de bord -->
              <div class="form-group row">
                <label for="ecran_bord" class="col-md-4 col-form-label">Ecran de bord</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="ecran_bord" id="ecran_bord" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="ecran_bord" id="ecran_bord" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Rétroviseur interne -->
              <div class="form-group row">
                <label for="retroviseur_interne" class="col-md-4 col-form-label">Rétroviseur interne</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_interne" id="retroviseur_interne" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="retroviseur_interne" id="retroviseur_interne" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Bouton de vitre arriere -->
              <div class="form-group row">
                <label for="bouton_vitre_arriere" class="col-md-4 col-form-label">Bouton de vitre arrière</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_vitre_arriere" id="bouton_vitre_arriere" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_vitre_arriere" id="bouton_vitre_arriere" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

            </div> <!-- fin gauche -->

            <div class="col-md-6">
              <!-- debut droit -->

              <!-- Tableau de bord -->
              <div class="form-group row">
                <label for="tableau_bord" class="col-md-4 col-form-label">Tableau de bord</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tableau_bord" id="tableau_bord" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tableau_bord" id="tableau_bord" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Tapis de sol -->
              <div class="form-group row">
                <label for="tapis_sol" class="col-md-4 col-form-label">Tapis de sol</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tapis_sol" id="tapis_sol" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="tapis_sol" id="tapis_sol" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Commutateur central -->
              <div class="form-group row">
                <label for="commutateur_central" class="col-md-4 col-form-label">Commutateur central</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="commutateur_central" id="commutateur_central" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="commutateur_central" id="commutateur_central" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Ampoule intérieure -->
              <div class="form-group row">
                <label for="ampoule_interieure" class="col-md-4 col-form-label">Ampoule intérieure</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="ampoule_interieure" id="ampoule_interieure" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="ampoule_interieure" id="ampoule_interieure" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Bouton de vitre avant -->
              <div class="form-group row">
                <label for="bouton_vitre_avant" class="col-md-4 col-form-label">Bouton de vitre avant</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_vitre_avant" id="bouton_vitre_avant" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_vitre_avant" id="bouton_vitre_avant" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Bouton de siège -->
              <div class="form-group row">
                <label for="bouton_siege" class="col-md-4 col-form-label">Bouton de siège</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_siege" id="bouton_siege" value="Bon">
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
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_siege" id="bouton_siege" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Frein à main -->
              <div class="form-group row">
                <label for="frein_main" class="col-md-4 col-form-label">Frein à main</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="frein_main" id="frein_main" value="Bon">
                  <label class="form-check-label" for="frein_main">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="frein_main" id="frein_main" value="Mauvais">
                  <label class="form-check-label" for="frein_maine">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="frein_main" id="frein_main" value="Absent">
                  <label class="form-check-label" for="frein_main">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="frein_main" id="frein_main" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

              <!-- Bouton de detresse -->
              <div class="form-group row">
                <label for="bouton_siege" class="col-md-4 col-form-label">Bouton de detresse</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_detresse" id="bouton_detresse" value="Bon">
                  <label class="form-check-label" for="bouton_detresse">B</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_detresse" id="bouton_detresse" value="Mauvais">
                  <label class="form-check-label" for="bouton_detresse">M</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_detresse" id="bouton_detresse" value="Absent">
                  <label class="form-check-label" for="bouton_siege">A</label>
                </div>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="bouton_detresse" id="bouton_detresse" value="Remorquage">
                  <label class="form-check-label" for="pare_brise_avant">R</label>
                </div>
              </div>

            </div> <!-- fin droit -->
          </div>
          <div class="form-group row">
            <label for="remarque_aspect_int" class="col-md-2 col-form-label"><span style="color:red;">*</span> Remarque du réceptionniste sur le véhicule :</label>
            <div class="col-md-10" style="padding-left:0px;">
              <textarea class="form-control" id="remarque_aspect_int" rows="4" name="remarque_aspect_int" id="remarque_aspect_int"></textarea>
            </div>
          </div>

          <fieldset>
            <legend>Ajouter des fichiers joints</legend>
            <div class="row">
              <div class="col-md-1">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_9_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_10_recep" />
                </span>
              </div>
            </div>
          </fieldset>
          <!-- </div> -->
          <!-- <div class="tab"> -->
          <h1 style="text-align:center;">Plaintes du client</h1>
          <textarea class="form-control" id="travo_effec" rows="6" name="travo_effec"></textarea>
          <fieldset>
            <legend>Ajouter des fichiers joints</legend>
            <div class="row">
              <div class="col-md-1">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_11_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_12_recep" />
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
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6_recep" />
                </span>
              </div>
            </div>
          </fieldset>
          <br>
          <fieldset>
            <legend>Ajouter le résultat du scanner français en fichier joint</legend>
            <div class="row">
              <div class="col-md-1">
                <span class="btn btn-file btn btn-primary">Ajouter fichier de scanner français<input type="file" name="pj_scanner_fr" id="pj_scanner_fr" />
                </span>
              </div>
              <!-- <div class="col-md-1">
                                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_scanner_electrique" />
                                </span>
                            </div> -->
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
    <span class="step"></span>
  </div>

  </section>
  </form>
  <div id="client-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">×</a>
          <h3>Formulaire d'ajout d'un client</h3>
        </div>
        <form id="clientForm" name="client" role="form" enctype="multipart/form-data" method="POST">
          <div class="modal-body">
            <div class="form-group">
              <label for="type_client"><span style="color:red;">*</span> Type de client :</label>
              <select class='form-control' id="type_client" name="type_client">
                <option value="">--Sélectionner le type du client--</option>
                <option value="Société">Société</option>
                <option value="Particulier">Particulier</option>
                <option value="Autre">Autre</option>
              </select>
            </div>
            <div class="form-group">
              <label for="civilite_client"><span style="color:red;">*</span> Civilité du client :</label>
              <select class='form-control' id="civilite_client" name="civilite_client">
                <option value="">--Sélectionner la civilité du client--</option>
                <option value="Monsieur">Monsieur (M)</option>
                <option value="Madame">Madame (Mme)</option>
                <option value="Mademoiselle">Mademoiselle (Mlle)</option>
              </select>
            </div>
            <div class="form-group">
              <label for="txtCName"><span style="color:red;">*</span> Nom & prenom:</label>
              <input type="text" name="txtCName" value="" id="txtCName" class="form-control" />
            </div>
            <div class="form-group">
              <label for="princ_tel"><span style="color:red;">*</span> Téléphone principal :<span style="color:red;">(ce numéro de téléphone est le mot de passe)</span></label>
              <input onkeyup="verifTelClient(this.value);" type="text" name="princ_tel" maxlength="10" value="" id="princ_tel" class="form-control" placeholder="Saisissez votre numéro de téléphone principal" /><span id="telclibox"></span>
              <!-- <input onkeyup="verifImma(this.value);" onchange="loadMarqueModeleVoiture(this.value);" type="text" name="immat" id="immat" class="form-control" placeholder="Rechercher un véhicule en saisissant son immatriculation"><span id="immabox"></span> -->
            </div>
            <div class="form-group">
              <label for="txtCEmail"> <span style="color:red;">*</span>Email :<span style="color:red;">(cet e-mail ou ce numéro de téléphone est l'identifiant)</span></label>
              <input onkeyup="verifEmailClient(this.value);" type="text" name="txtCEmail" value="" id="txtCEmail" class="form-control" placeholder="Saisissez votre e-mail ou votre numéro de téléphone" /><span id="emailclibox"></span>
            </div>

            <div class="form-group">
              <label for="txtCAddress"> Addresse :</label>
              <textarea name="txtCAddress" id="txtCAddress" class="form-control"></textarea>
            </div>

            <fieldset>
              <legend>Ajouter des fichiers joints</legend>
              <div class="row">
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1_client" id="pj_1_client" />
                  </span>
                </div>
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2_client" id="pj_2_client" />
                  </span>
                </div>
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3_client" id="pj_3_client" />
                  </span>
                </div>
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4_client" id="pj_4_client" />
                  </span>
                </div>
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5_client" id="pj_5_client" />
                  </span>
                </div>
                <div class="col-sm-2">
                  <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6_client" id="pj_6_client" />
                  </span>
                </div>
              </div>
            </fieldset>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            <button type="submit" class="btn btn-success" id="submit">Valider</button>
          </div>

          <input type="hidden" value="" name="txtCPassword" />
          <input type="hidden" value="" name="tel_wa" />
          <input type="hidden" value="<?php echo $cus_id; ?>" name="customer_id" />
          <input type="hidden" value="<?php echo $model_post_token; ?>" name="submit_token" />

        </form>
      </div>
    </div>
  </div>
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

    // Récupération des éléments à partir du nom de leur balise
    const elt_elec_recep_vehi = document.getElementsByTagName('elec_recep_vehi');
    const elt_meca_recep_vehi = document.getElementsByTagName('meca_recep_vehi');
    const elt_pb_electro_recep_vehi = document.getElementsByTagName('pb_electro_recep_vehi');
    const elt_pb_demar_recep_vehi = document.getElementsByTagName('pb_demar_recep_vehi');
    const elt_pb_meca_recep_vehi = document.getElementsByTagName('pb_meca_recep_vehi');
    const elt_sup_adblue_recep_vehi = document.getElementsByTagName('sup_adblue_recep_vehi');
    const elt_sup_fil_parti_recep_vehi = document.getElementsByTagName('sup_fil_parti_recep_vehi');
    const elt_sup_vanne_egr_recep_vehi = document.getElementsByTagName('sup_vanne_egr_recep_vehi');
    const elt_dupli_cle_recep_vehi = document.getElementsByTagName('dupli_cle_recep_vehi');

    const elt_voyant_1 = document.getElementsByTagName('voyant_1');
    const elt_voyant_2 = document.getElementsByTagName('voyant_2');
    const elt_voyant_3 = document.getElementsByTagName('voyant_3');
    const elt_voyant_4 = document.getElementsByTagName('voyant_4');
    const elt_voyant_5 = document.getElementsByTagName('voyant_5');
    const elt_voyant_6 = document.getElementsByTagName('voyant_6');
    const elt_voyant_7 = document.getElementsByTagName('voyant_7');
    const elt_voyant_8 = document.getElementsByTagName('voyant_8');
    const elt_voyant_9 = document.getElementsByTagName('voyant_9');
    const elt_voyant_10 = document.getElementsByTagName('voyant_10');
    const elt_voyant_11 = document.getElementsByTagName('voyant_11');
    const elt_voyant_12 = document.getElementsByTagName('voyant_12');
    const elt_voyant_13 = document.getElementsByTagName('voyant_13');
    const elt_voyant_14 = document.getElementsByTagName('voyant_14');
    const elt_voyant_15 = document.getElementsByTagName('voyant_15');
    const elt_voyant_16 = document.getElementsByTagName('voyant_16');
    const elt_voyant_17 = document.getElementsByTagName('voyant_17');
    const elt_voyant_18 = document.getElementsByTagName('voyant_18');
    const elt_voyant_19 = document.getElementsByTagName('voyant_19');
    const elt_voyant_20 = document.getElementsByTagName('voyant_20');
    const elt_voyant_21 = document.getElementsByTagName('voyant_21');
    const elt_voyant_22 = document.getElementsByTagName('voyant_22');
    const elt_voyant_23 = document.getElementsByTagName('voyant_23');
    const elt_voyant_24 = document.getElementsByTagName('voyant_24');

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

      // console.log('currentTab = ' + currentTab);
      // console.log('n = ' + n);
      // console.log($('input[name=nivo_carbu_recep_vehi]'));

      // console.log($('#carte_grise_recep_vehi_non').is(':checked'));

      if (n == 1 && currentTab == 1 && !validateMe_2()) return false;

      if (n == 1 && currentTab == 2 && !validateMe_3()) return false;

      // Hide the current tab:
      x[currentTab].style.display = "none";
      // Increase or decrease the current tab by 1:
      currentTab = currentTab + n;

      // if you have reached the end of the form...
      if (currentTab >= x.length) {
        // ... the form gets submitted:
        document.getElementById("regForm").submit();
        // submitRecepForm();
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
        } else if (y[i].type == "text") { // Traitement des champs de type text

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
                  // valid = true;
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
              // valid = true;
            }

          }

        } else if (y[i].type == "radio") {

          if (y[i].name == "nivo_carbu_recep_vehi") {
            if (y[i].checked == false) {
              valid = false;
            }
          }

          if (y[i].name == "etat_proprete_arrivee") {
            if (y[i].checked == false) {
              valid = false;
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

    function validateMe_3() {
      // déclaration des variables
      var j, z1, z2, z3, z4, z5, z6, z7, z8, z9, z10, z11, z12, z13, z14, z15, z16, z17, z18, z19,
        z20, z21, z22, z23, z24, z25, z26, z27, z28, z29, z30, z31, z32, z33, z34, z35, z36, z37, z38,
        z39, z40, z41, z42, z43, z44, z45, z46;

      // initialisation des variables
      j = 0;
      z1 = $('input[name=pare_brise_avant]');
      z2 = $('input[name=etat_proprete_arrivee]');
      z3 = $('input[name=etat_vehi_arrive]');
      z4 = $('input[name=phare_gauche]');
      z5 = $('input[name=clignotant_droit]');
      z6 = $('input[name=pare_choc_avant]');
      z7 = $('input[name=feu_avant]');
      z8 = $('input[name=vitre_avant]');
      z9 = $('input[name=poignet_avant]');
      z10 = $('input[name=plaque_avant]');
      z11 = $('input[name=feu_brouillard]');
      z12 = $('input[name=balai_essuie_glace]');
      z13 = $('input[name=retroviseur_gauche]');
      z14 = $('input[name=symbole_avant]');
      z15 = $('input[name=poignet_capot]');
      z16 = $('input[name=alternateur]');
      z17 = $('input[name=climatisation]');
      z18 = $('input[name=pare_brise_arriere]');
      z19 = $('input[name=phare_droit]');
      z20 = $('input[name=clignotant_gauche]');
      z21 = $('input[name=pare_choc_arriere]');
      z22 = $('input[name=feu_arriere]');
      z23 = $('input[name=vitre_arriere]');
      z24 = $('input[name=poignet_arriere]');
      z25 = $('input[name=plaque_arriere]');
      z26 = $('input[name=controle_pneu]');
      z27 = $('input[name=batterie]');
      z28 = $('input[name=retroviseur_droit]');
      z29 = $('input[name=symbole_arriere]');
      z30 = $('input[name=cache_moteur]');
      z31 = $('input[name=suspension]');
      z32 = $('input[name=etat_carosserie]');
      z33 = $('input[name=poste_auto]');
      z34 = $('input[name=coffre_gant]');
      z35 = $('input[name=tapis_plafond]');
      z36 = $('input[name=ecran_bord]');
      z37 = $('input[name=retroviseur_interne]');
      z38 = $('input[name=bouton_vitre_arriere]');
      z39 = $('input[name=tableau_bord]');
      z40 = $('input[name=tapis_sol]');
      z41 = $('input[name=commutateur_central]');
      z42 = $('input[name=ampoule_interieure]');
      z43 = $('input[name=bouton_vitre_avant]');
      z44 = $('input[name=bouton_siege]');
      z45 = $('input[name=frein_main]');
      z46 = $('input[name=bouton_detresse]');

      // console.log(z1);

      if (z2[j].checked == false && z2[j + 1].checked == false) {
        alert("Veuillez cocher l'état de propreté du véhicule SVP !!!");
        $('input[name=etat_proprete_arrivee]').focus();
        return false;
      } else if (z3[j].checked == false && z3[j + 1].checked == false) {

        alert("Veuillez cocher l'état du véhicule à l'arrivé SVP !!!");
        $('input[name=etat_vehi_arrive]').focus();
        return false;

      } else if ($('textarea#remarque_etat_vehi_arrive').val() == '') {
        alert("Veuillez saisir une remarque s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#remarque_etat_vehi_arrive').focus();
        return false;
      } else if (z1[j].checked == false && z1[j + 1].checked == false && z1[j + 2].checked == false && z1[j + 3].checked == false) {
        alert("Veuillez cocher l'état du pare brise avant SVP !!!");
        $('input[name=pare_brise_avant]').focus();
        return false;
      } else if (z4[j].checked == false && z4[j + 1].checked == false && z4[j + 2].checked == false && z4[j + 3].checked == false) {
        alert("Veuillez cocher l'état du phare gauche SVP !!!");
        $('input[name=phare_gauche]').focus();
        return false;
      } else if (z5[j].checked == false && z5[j + 1].checked == false && z5[j + 2].checked == false && z5[j + 3].checked == false) {
        alert("Veuillez cocher l'état du clignotant droit SVP !!!");
        $('input[name=clignotant_droit]').focus();
        return false;
      } else if (z6[j].checked == false && z6[j + 1].checked == false && z6[j + 2].checked == false && z6[j + 3].checked == false) {
        alert("Veuillez cocher l'état du pare choc avant SVP !!!");
        $('input[name=pare_choc_avant]').focus();
        return false;
      } else if (z7[j].checked == false && z7[j + 1].checked == false && z7[j + 2].checked == false && z7[j + 3].checked == false) {
        alert("Veuillez cocher l'état du feu avant SVP !!!");
        $('input[name=feu_avant]').focus();
        return false;
      } else if (z8[j].checked == false && z8[j + 1].checked == false && z8[j + 2].checked == false && z8[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la vitre avant SVP !!!");
        $('input[name=vitre_avant]').focus();
        return false;
      } else if (z9[j].checked == false && z9[j + 1].checked == false && z9[j + 2].checked == false && z9[j + 3].checked == false) {
        alert("Veuillez cocher l'état du poignet avant SVP !!!");
        $('input[name=poignet_avant]').focus();
        return false;
      } else if (z10[j].checked == false && z10[j + 1].checked == false && z10[j + 2].checked == false && z10[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la plaque avant SVP !!!");
        $('input[name=plaque_avant]').focus();
        return false;
      } else if (z11[j].checked == false && z11[j + 1].checked == false && z11[j + 2].checked == false && z11[j + 3].checked == false) {
        alert("Veuillez cocher l'état du feu brouillard SVP !!!");
        $('input[name=feu_brouillard]').focus();
        return false;
      } else if (z12[j].checked == false && z12[j + 1].checked == false && z12[j + 2].checked == false && z12[j + 3].checked == false) {
        alert("Veuillez cocher l'état des balaies d'essuie glace SVP !!!");
        $('input[name=balai_essuie_glace]').focus();
        return false;
      } else if (z13[j].checked == false && z13[j + 1].checked == false && z13[j + 2].checked == false && z13[j + 3].checked == false) {
        alert("Veuillez cocher l'état du rétroviseur gauche SVP !!!");
        $('input[name=retroviseur_gauche]').focus();
        return false;
      } else if (z14[j].checked == false && z14[j + 1].checked == false && z14[j + 2].checked == false && z14[j + 3].checked == false) {
        alert("Veuillez cocher l'état du symbole avant SVP !!!");
        $('input[name=symbole_avant]').focus();
        return false;
      } else if (z15[j].checked == false && z15[j + 1].checked == false && z15[j + 2].checked == false && z15[j + 3].checked == false) {
        alert("Veuillez cocher l'état du poignet de capot SVP !!!");
        $('input[name=poignet_capot]').focus();
        return false;
      } else if (z16[j].checked == false && z16[j + 1].checked == false && z16[j + 2].checked == false && z16[j + 3].checked == false) {
        alert("Veuillez cocher l'état de l'alternateur SVP !!!");
        $('input[name=alternateur]').focus();
        return false;
      } else if (z18[j].checked == false && z18[j + 1].checked == false && z18[j + 2].checked == false && z18[j + 3].checked == false) {
        alert("Veuillez cocher l'état du pare brise arrière SVP !!!");
        $('input[name=pare_brise_arriere]').focus();
        return false;
      } else if (z17[j].checked == false && z17[j + 1].checked == false && z17[j + 2].checked == false && z17[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la climatisation SVP !!!");
        $('input[name=climatisation]').focus();
        return false;
      } else if (z19[j].checked == false && z19[j + 1].checked == false && z19[j + 2].checked == false && z19[j + 3].checked == false) {
        alert("Veuillez cocher l'état du phare droit SVP !!!");
        $('input[name=phare_droit]').focus();
        return false;
      } else if (z20[j].checked == false && z20[j + 1].checked == false && z20[j + 2].checked == false && z20[j + 3].checked == false) {
        alert("Veuillez cocher l'état du clignotant gauche SVP !!!");
        $('input[name=clignotant_gauche]').focus();
        return false;
      } else if (z21[j].checked == false && z21[j + 1].checked == false && z21[j + 2].checked == false && z21[j + 3].checked == false) {
        alert("Veuillez cocher l'état du pare choc arrière SVP !!!");
        $('input[name=pare_choc_arriere]').focus();
        return false;
      } else if (z22[j].checked == false && z22[j + 1].checked == false && z22[j + 2].checked == false && z22[j + 3].checked == false) {
        alert("Veuillez cocher l'état du feu arrière SVP !!!");
        $('input[name=feu_arriere]').focus();
        return false;
      } else if (z23[j].checked == false && z23[j + 1].checked == false && z23[j + 2].checked == false && z23[j + 3].checked == false) {

        alert("Veuillez cocher l'état de la vitre arrière SVP !!!");
        $('input[name=vitre_arriere]').focus();
        return false;

      } else if (z24[j].checked == false && z24[j + 1].checked == false && z24[j + 2].checked == false && z24[j + 3].checked == false) {
        alert("Veuillez cocher l'état du poignet arrière SVP !!!");
        $('input[name=poignet_arriere]').focus();
        return false;

      } else if (z25[j].checked == false && z25[j + 1].checked == false && z25[j + 2].checked == false && z25[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la plaque arrière SVP !!!");
        $('input[name=plaque_arriere]').focus();
        return false;
      } else if (z26[j].checked == false && z26[j + 1].checked == false && z26[j + 2].checked == false && z26[j + 3].checked == false) {

        alert("Veuillez cocher l'état du contrôle pneu SVP !!!");
        $('input[name=controle_pneu]').focus();
        return false;

      } else if (z27[j].checked == false && z27[j + 1].checked == false && z27[j + 2].checked == false && z27[j + 3].checked == false) {

        alert("Veuillez cocher l'état de la batterie SVP !!!");
        $('input[name=batterie]').focus();
        return false;
      } else if (z28[j].checked == false && z28[j + 1].checked == false && z28[j + 2].checked == false && z28[j + 3].checked == false) {

        alert("Veuillez cocher l'état du retroviseur droit SVP !!!");
        $('input[name=retroviseur_droit]').focus();
        return false;

      } else if (z29[j].checked == false && z29[j + 1].checked == false && z29[j + 2].checked == false && z29[j + 3].checked == false) {

        alert("Veuillez cocher l'état du symbole arrière SVP !!!");
        $('input[name=symbole_arriere]').focus();
        return false;

      } else if (z30[j].checked == false && z30[j + 1].checked == false && z30[j + 2].checked == false && z30[j + 3].checked == false) {

        alert("Veuillez cocher l'état du cache moteur SVP !!!");
        $('input[name=cache_moteur]').focus();
        return false;

      } else if (z31[j].checked == false && z31[j + 1].checked == false && z31[j + 2].checked == false && z31[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la suspension SVP !!!");
        $('input[name=suspension]').focus();
        return false;
      } else if (z32[j].checked == false && z32[j + 1].checked == false && z32[j + 2].checked == false && z32[j + 3].checked == false) {
        alert("Veuillez cocher l'état de la carosserie SVP !!!");
        $('input[name=etat_carosserie]').focus();
        return false;
      } else if ($('#dim_pneu').val() == '') {
        alert("Veuillez saisir la dimension du pneu SVP !!!");
        $('#dim_pneu').focus();
        return false;
      } else if ($('textarea#remarque_aspect_ext').val() == '') {
        alert("Veuillez saisir une remarque s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#remarque_aspect_ext').focus();
        return false;
      } else if (z33[j].checked == false && z33[j + 1].checked == false && z33[j + 2].checked == false && z33[j + 3].checked == false) {

        alert("Veuillez cocher l'état du poste auto SVP !!!");
        $('input[name=poste_auto]').focus();
        return false;

      } else if (z34[j].checked == false && z34[j + 1].checked == false && z34[j + 2].checked == false && z34[j + 3].checked == false) {

        alert("Veuillez cocher l'état du coffre à gant SVP !!!");
        $('input[name=coffre_gant]').focus();
        return false;

      } else if (z35[j].checked == false && z35[j + 1].checked == false && z35[j + 2].checked == false && z35[j + 3].checked == false) {

        alert("Veuillez cocher l'état du tapis de plafond !!!");
        $('input[name=tapis_plafond]').focus();
        return false;

      } else if (z36[j].checked == false && z36[j + 1].checked == false && z36[j + 2].checked == false && z36[j + 3].checked == false) {

        alert("Veuillez cocher l'état de l'écran de bord !!!");
        $('input[name=ecran_bord]').focus();
        return false;

      } else if (z37[j].checked == false && z37[j + 1].checked == false && z37[j + 2].checked == false && z37[j + 3].checked == false) {

        alert("Veuillez cocher l'état du retroviseur interne SVP !!!");
        $('input[name=retroviseur_interne]').focus();
        return false;

      } else if (z38[j].checked == false && z38[j + 1].checked == false && z38[j + 2].checked == false && z38[j + 3].checked == false) {

        alert("Veuillez cocher l'état du bouton de vitre arrière SVP !!!");
        $('input[name=bouton_vitre_arriere]').focus();
        return false;

      } else if (z39[j].checked == false && z39[j + 1].checked == false && z39[j + 2].checked == false && z39[j + 3].checked == false) {

        alert("Veuillez cocher l'état du tableau de bord SVP !!!");
        $('input[name=tableau_bord]').focus();
        return false;

      } else if (z40[j].checked == false && z40[j + 1].checked == false && z40[j + 2].checked == false && z40[j + 3].checked == false) {

        alert("Veuillez cocher l'état du tapis de sol SVP !!!");
        $('input[name=tapis_sol]').focus();
        return false;

      } else if (z41[j].checked == false && z41[j + 1].checked == false && z41[j + 2].checked == false && z41[j + 3].checked == false) {

        alert("Veuillez cocher l'état du commutateur central SVP !!!");
        $('input[name=commutateur_central]').focus();
        return false;

      } else if (z42[j].checked == false && z42[j + 1].checked == false && z42[j + 2].checked == false && z42[j + 3].checked == false) {

        alert("Veuillez cocher l'état de l'ampoule intérieure SVP !!!");
        $('input[name=ampoule_interieure]').focus();
        return false;

      } else if (z43[j].checked == false && z43[j + 1].checked == false && z43[j + 2].checked == false && z43[j + 3].checked == false) {

        alert("Veuillez cocher l'état du bouton vitre avant SVP !!!");
        $('input[name=bouton_vitre_avant]').focus();
        return false;

      } else if (z44[j].checked == false && z44[j + 1].checked == false && z44[j + 2].checked == false && z44[j + 3].checked == false) {

        alert("Veuillez cocher l'état du bouton siege SVP !!!");
        $('input[name=bouton_siege]').focus();
        return false;

      } else if (z45[j].checked == false && z45[j + 1].checked == false && z45[j + 2].checked == false && z45[j + 3].checked == false) {

        alert("Veuillez cocher l'état du frein à main SVP !!!");
        $('input[name=frein_main]').focus();
        return false;

      } else if (z46[j].checked == false && z46[j + 1].checked == false && z46[j + 2].checked == false && z46[j + 3].checked == false) {

        alert("Veuillez cocher l'état du bouton de détresse SVP !!!");
        $('input[name=bouton_detresse]').focus();
        return false;

      } else if ($('textarea#remarque_aspect_int').val() == '') {
        alert("Veuillez saisir une remarque s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#remarque_aspect_int').focus();
        return false;
      } else if ($('textarea#travo_effec').val() == '') {
        alert("Veuillez saisir les plaintes du client s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#travo_effec').focus();
        return false;
      } else if ($('textarea#autres_obs').val() == '') {
        alert("Veuillez saisir les autres observations s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#autres_obs').focus();
        return false;
      } else if ($('input[name="pj_scanner_fr"]').val() == '') {
        alert("Le fichier du résultat du scanner est obligatoire, veuillez l'ajouter SVP !!!");
        $($('input[name="pj_scanner_fr"]')).focus();
        return false;
      } else {
        return true;
      }

    }

    function validateMe_2() {

      // déclaration des variables
      var i, y, etat_vehi_arrive

      // initialisation des variables
      i = 0;
      y = $('input[name=nivo_carbu_recep_vehi]');
      etat_vehi_arrive = "<?php echo $etat_vehi_arrive ?>";

      y1 = $('input[name=carte_grise_recep_vehi]');
      y2 = $('input[name=cric_levage_recep_vehi]');
      y3 = $('input[name=cle_roue]');
      y4 = $('input[name=rallonge_roue_recep_vehi]');
      y5 = $('input[name=pneu_secours]');
      y6 = $('input[name=anneau_remorquage_recep_vehi]');
      y7 = $('input[name=triangle]');
      y8 = $('input[name=boite_pharma]');
      y9 = $('input[name=extincteur]');
      y10 = $('input[name=remarque_access_vehi]');

      y11 = $('input[name=elec_recep_vehi]');
      y12 = $('input[name=meca_recep_vehi]');
      y13 = $('input[name=pb_electro_recep_vehi]');
      y14 = $('input[name=pb_demar_recep_vehi]');
      y15 = $('input[name=pb_meca_recep_vehi]');
      y16 = $('input[name=conf_cle_recep_vehi]');
      y17 = $('input[name=sup_adblue_recep_vehi]');
      y18 = $('input[name=sup_fil_parti_recep_vehi]');
      y19 = $('input[name=dupli_cle_recep_vehi]');
      y20 = $('input[name=sup_vanne_egr_recep_vehi]');

      // if (etat_vehi_arrive == "conduit") {

      y21 = $('input[name=voyant_1]');
      y22 = $('input[name=voyant_2]');
      y23 = $('input[name=voyant_3]');
      y24 = $('input[name=voyant_4]');
      y25 = $('input[name=voyant_5]');
      y26 = $('input[name=voyant_6]');
      y27 = $('input[name=voyant_7]');
      y28 = $('input[name=voyant_8]');
      y29 = $('input[name=voyant_9]');
      y30 = $('input[name=voyant_10]');
      y31 = $('input[name=voyant_11]');
      y32 = $('input[name=voyant_12]');
      y33 = $('input[name=voyant_13]');
      y34 = $('input[name=voyant_14]');
      y35 = $('input[name=voyant_15]');
      y36 = $('input[name=voyant_16]');
      y37 = $('input[name=voyant_17]');
      y38 = $('input[name=voyant_18]');
      y39 = $('input[name=voyant_19]');
      y40 = $('input[name=voyant_20]');
      y41 = $('input[name=voyant_21]');
      y42 = $('input[name=voyant_22]');
      y43 = $('input[name=voyant_23]');
      y44 = $('input[name=voyant_24]');

      // }

      y46 = $('input[name=remarque_motif_depot]');
      // y47 = $('input[name="carte_grise_numero"]');
      y48 = $('input[name="pj_carte_grise"]');

      // y49 = $('input[name="visite_tech_numero"]');
      y50 = $('input[name="add_date_visitetech_car"]');
      y51 = $('input[name="pj_visite_tech"]');
      y52 = $('input[name="visitetech_recep_vehi"]');

      y53 = $('input[name="assur_recep_vehi"]');
      // y54 = $('input[name="assurance_numero"]');
      y55 = $('input[name="assurance_vehi_recep"]');
      y56 = $('input[name="add_date_assurance_car"]');
      y57 = $('input[name="add_date_assurance_fin"]');
      y58 = $('input[name="pj_assurance"]');

      y59 = $('input[name="pj_assurance_cedeao"]');
      y60 = $('input[name="pj_contrat_assurance"]');

      y61 = $('input[name="otre_piece_numero"]');
      y62 = $('input[name="date_otre_piece_recep_vehi"]');
      y63 = $('input[name="pj_otre_piece"]');

      y64 = $('input[name="assurance_cedeao_recep_vehi"]');
      y65 = $('input[name="contrat_assurance_recep_vehi"]');

      y66 = $('input[name="otre_piece_recep_vehi"]');

      // console.log(z1);

      if ($("#km_reception_vehi").val() == '' && etat_vehi_arrive == "conduit") {
        alert("Le kilométrage du véhicule est obligatoire !!!");
        $("#km_reception_vehi").focus();
        return false;
      } else if ((etat_vehi_arrive == "conduit") && (y[i].checked == false) && (y[i + 1].checked == false) && (y[i + 2].checked == false) && (y[i + 3].checked == false) && (y[i + 4].checked == false)) {

        alert("Veuillez cocher le niveau de carburant SVP !!!");
        $('input[name=nivo_carbu_recep_vehi]').focus();
        return false;

      } else if ($("#cle_recep_vehi_text").val() == '') {
        alert("Le nombre de clé du véhicule est obligatoire !!!");
        $("#cle_recep_vehi_text").focus();
        return false;
      } else if ($("#cle_recep_vehi").prop("checked") == false) {
        alert("Veuillez cocher la case clé du véhicule !!!");
        $("#cle_recep_vehi").focus();
        return false;
      } else if (y1[i].checked == false && y1[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une carte grise !!!");
        y1.focus();
        return false;
      } 
      // else if (y47.val() == '' && $('#carte_grise_recep_vehi_oui').is(':checked')) {
      //   y47.focus();
      //   alert("Saisissez le numéro de la carte grise SVP !!!");
      //   return false;
      // } 
      else if (y48.val() == '' && $('#carte_grise_recep_vehi_oui').is(':checked')) {
        y48.focus();
        alert("Ajouter l'image de la carte grise du véhicule !!!");
        return false;
      } else if (y52[i].checked == false && y52[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une visite technique !!!");
        y52.focus();
        return false;
      } 
      // else if (y49.val() == '' && $('#visite_tech_recep_vehi_oui').is(':checked')) {
      //   y49.focus();
      //   alert("Saisissez le numéro de la visite technique SVP !!!");
      //   return false;
      // } 
      else if (y50.val() == '' && $('#visite_tech_recep_vehi_oui').is(':checked')) {
        y50.focus();
        alert("Ajouter la date de la prochaine visite technique du véhicule !!!");
        return false;
      } else if (y51.val() == '' && $('#visite_tech_recep_vehi_oui').is(':checked')) {
        y51.focus();
        alert("Ajouter l'image de la visite technique du véhicule !!!");
        return false;
      } else if (y53[i].checked == false && y53[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une assurance !!!");
        y53.focus();
        return false;
      } 
      // else if (y54.val() == '' && $('#assurance_recep_vehi_oui').is(':checked')) {
      //   y54.focus();
      //   alert("Saisissez le numéro de l'assurance SVP !!!");
      //   return false;
      // } 
      else if (y55.val() == '' && $('#assurance_recep_vehi_oui').is(':checked')) {
        y55.focus();
        alert("Saisissez le nom de l'assurance SVP !!!");
      } else if (y56.val() == '' && $('#assurance_recep_vehi_oui').is(':checked')) {
        alert("La date de début de l'assurance du véhicule est obligatoire, saisissez la !!!");
        y56.focus();
        return false;
      } else if (y57.val() == '' && $('#assurance_recep_vehi_oui').is(':checked')) {
        alert("La date de fin de l'assurance du véhicule est obligatoire, saisissez la !!!");
        y57.focus();
        return false;
      } else if (y58.val() == '' && $('#assurance_recep_vehi_oui').is(':checked')) {
        y58.focus();
        alert("Ajouter l'image de l'assurance du véhicule !!!");
        return false;
      } else if (y64[i].checked == false && y64[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une assurance CEDEAO !!!");
        y64.focus();
        return false;
      } else if (y59.val() == '' && $('#assurance_cedeao_recep_vehi_oui').is(':checked')) {
        y59.focus();
        alert("Ajouter l'image de l'assurance CEDEAO du véhicule SVP !!!");
        return false;
      } else if (y65[i].checked == false && y65[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un contrat d'assurance !!!");
        y65.focus();
        return false;
      } else if (y60.val() == '' && $('#contrat_assurance_recep_vehi_oui').is(':checked')) {
        y60.focus();
        alert("Ajouter l'image du contrat d'assurance du véhicule SVP !!!");
        return false;
      } else if (y66[i].checked == false && y66[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une autre pièce !!!");
        y66.focus();
        return false;
      } else if (y61.val() == '' && $('#otre_piece_recep_vehi_oui').is(':checked')) {
        y61.focus();
        alert("Saisissez le numéro de la pièce SVP !!!");
        return false;
      } else if (y62.val() == '' && $('#otre_piece_recep_vehi_oui').is(':checked')) {
        y62.focus();
        alert("Sélectionnez la date d'expiration de la pièce !!!");
        return false;
      } else if (y63.val() == '' && $('#otre_piece_recep_vehi_oui').is(':checked')) {
        y63.focus();
        alert("Ajouter l'image de la pièce du véhicule !!!");
        return false;
      } else if (y2[i].checked == false && y2[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un cric de levage !!!");
        y2.focus();
        return false;
      } else if (y3[i].checked == false && y3[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une clé de roue !!!");
        y3.focus();
        return false;
      } else if (y4[i].checked == false && y4[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une rallonge de roue !!!");
        y4.focus();
        return false;
      } else if (y5[i].checked == false && y5[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un pneu secours !!!");
        y5.focus();
        return false;
      } else if (y6[i].checked == false && y6[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un anneau de remorquage !!!");
        y6.focus();
        return false;
      } else if (y7[i].checked == false && y7[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un triangle !!!");
        y7.focus();
        return false;
      } else if (y8[i].checked == false && y8[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a une boite à pharmacie !!!");
        y8.focus();
        return false;
      } else if (y9[i].checked == false && y9[i + 1].checked == false) {
        alert("Veuillez cocher OUI ou NON s'il y'a un extincteur !!!");
        y9.focus();
        return false;
      } else if ($('textarea#remarque_access_vehi').val() == '') {
        alert("Veuillez saisir une remarque s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#remarque_access_vehi').focus();
        return false;
      } else if ($('input[name="pj_access_1"]').val() == '') {
        alert("Veuillez ajouter la photo du 1er accessoire du véhicule SVP !!!");
        $($('input[name="pj_access_1"]')).focus();
        return false;
      } else if ($('input[name="pj_access_2"]').val() == '') {
        alert("Veuillez ajouter la photo du 2ème accessoire du véhicule SVP !!!");
        $($('input[name="pj_access_2"]')).focus();
        return false;
      }
      // else if ($('input[name="pj_access_3"]').val() == '') {
      //   alert("Veuillez ajouter la photo du 3ème accessoire du véhicule SVP !!!");
      //   $($('input[name="pj_access_3"]')).focus();
      //   return false;
      // } else if ($('input[name="pj_access_4"]').val() == '') {
      //   alert("Veuillez ajouter la photo du 4ème accessoire du véhicule SVP !!!");
      //   $($('input[name="pj_access_4"]')).focus();
      //   return false;
      // } else if ($('input[name="pj_access_5"]').val() == '') {
      //   alert("Veuillez ajouter la photo du 5ème accessoire du véhicule SVP !!!");
      //   $($('input[name="pj_access_5"]')).focus();
      //   return false;
      // } else if ($('input[name="pj_access_6"]').val() == '') {
      //   alert("Veuillez ajouter la photo du 6ème accessoire du véhicule SVP !!!");
      //   $($('input[name="pj_access_6"]')).focus();
      //   return false;
      // } 
      else if ($("#scanner_recep_vehi").prop("checked") == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher la case du scanner !!!");
        $("#scanner_recep_vehi").focus();
        return false;
      } else if (y11[i].checked == false && y11[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est électrique !!!");
        y11.focus();
        return false;
      } else if (y12[i].checked == false && y12[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est mécanique !!!");
        y12.focus();
        return false;
      } else if (y13[i].checked == false && y13[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour un problème électronique !!!");
        y13.focus();
        return false;
      } else if (y14[i].checked == false && y14[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour un problème de démarrage !!!");
        y14.focus();
        return false;
      } else if (y15[i].checked == false && y15[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour un problème mécanique !!!");
        y15.focus();
        return false;
      } else if (y16[i].checked == false && y16[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour une confection de clé !!!");
        y16.focus();
        return false;
      } else if (y17[i].checked == false && y17[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour une suppression adblue !!!");
        y17.focus();
        return false;
      } else if (y18[i].checked == false && y18[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour une suppression de filtre à particule !!!");
        y18.focus();
        return false;
      } else if (y19[i].checked == false && y19[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour une duplication de clé !!!");
        y19.focus();
        return false;
      } else if (y20[i].checked == false && y20[i + 1].checked == false) {
        alert("Veuillez cocher si OUI ou NON le motif de dépot est pour suppression de vanne EGR !!!");
        y20.focus();
        return false;
      } else if (y21[i].checked == false && y21[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 1 est allumé !!!");
        y21.focus();
        return false;
      } else if (y22[i].checked == false && y22[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 2 est allumé !!!");
        y22.focus();
        return false;
      } else if (y23[i].checked == false && y23[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 3 est allumé !!!");
        y23.focus();
        return false;
      } else if (y24[i].checked == false && y24[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 4 est allumé !!!");
        y24.focus();
        return false;
      } else if (y25[i].checked == false && y25[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 5 est allumé !!!");
        y25.focus();
        return false;
      } else if (y26[i].checked == false && y26[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 6 est allumé !!!");
        y26.focus();
        return false;
      } else if (y27[i].checked == false && y27[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 7 est allumé !!!");
        y27.focus();
        return false;
      } else if (y28[i].checked == false && y28[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 8 est allumé !!!");
        y28.focus();
        return false;
      } else if (y29[i].checked == false && y29[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 9 est allumé !!!");
        y29.focus();
        return false;
      } else if (y30[i].checked == false && y30[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 10 est allumé !!!");
        y30.focus();
        return false;
      } else if (y31[i].checked == false && y31[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 11 est allumé !!!");
        y31.focus();
        return false;
      } else if (y32[i].checked == false && y32[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 12 est allumé !!!");
        y32.focus();
        return false;
      } else if (y33[i].checked == false && y33[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 13 est allumé !!!");
        y33.focus();
        return false;
      } else if (y34[i].checked == false && y34[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 14 est allumé !!!");
        y34.focus();
        return false;
      } else if (y35[i].checked == false && y35[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 15 est allumé !!!");
        y35.focus();
        return false;
      } else if (y36[i].checked == false && y36[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 16 est allumé !!!");
        y36.focus();
        return false;
      } else if (y37[i].checked == false && y37[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 17 est allumé !!!");
        y37.focus();
        return false;
      } else if (y38[i].checked == false && y38[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 18 est allumé !!!");
        y38.focus();
        return false;
      } else if (y39[i].checked == false && y39[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 19 est allumé !!!");
        y39.focus();
        return false;
      } else if (y40[i].checked == false && y40[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 20 est allumé !!!");
        y40.focus();
        return false;
      } else if (y41[i].checked == false && y41[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 21 est allumé !!!");
        y41.focus();
        return false;
      } else if (y42[i].checked == false && y42[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 22 est allumé !!!");
        y42.focus();
        return false;
      } else if (y43[i].checked == false && y43[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 23 est allumé !!!");
        y43.focus();
        return false;
      } else if (y44[i].checked == false && y44[i + 1].checked == false && etat_vehi_arrive == "conduit") {
        alert("Veuillez cocher si OUI ou NON le voyant 24 est allumé !!!");
        y44.focus();
        return false;
      } else if ($('textarea#remarque_motif_depot').val() == '') {
        alert("Veuillez saisir une remarque s'il y en a ou NEANT s'il n'y en a pas !!!");
        $('textarea#remarque_motif_depot').focus();
        return false;
      } else if ($('input[name="pj_voyants_1"]').val() == '') {
        alert("Veuillez ajouter une 1ère photo du tableau de bord SVP !!!");
        $($('input[name="pj_voyants_1"]')).focus();
        return false;
      } else if ($('input[name="pj_voyants_2"]').val() == '') {
        alert("Veuillez ajouter une 2ème photo du tableau de bord SVP !!!");
        $($('input[name="pj_voyants_2"]')).focus();
        return false;
      } else {
        return true;
      }
    }

    function validateMe() {

      if ($("#vin").val() == '') {
        alert("L'immatriculation du véhicule est obligatoire, saisissez la !!!");
        $("#vin").focus();
        return false;
      } else if ($("#ddlMake").val() == '') {
        alert("La marque du véhicule est obligatoire, saisissez la !!!");
        $("#ddlMake").focus();
        return false;
      } else if ($("#ddl_model").val() == '') {
        alert("Le modèle du véhicule est obligatoire, saisissez le !!!");
        $("#ddl_model").focus();
        return false;
      }
      // else if ($("#assurance_vehi_recep").val() == '') {
      //   alert("L'assurance du véhicule est obligatoire, saisissez la !!!");
      //   $("#assurance_vehi_recep").focus();
      //   return false;
      // } 
      else if ($("#ddlCustomerList").val() == '') {
        alert("Le nom du client est obligatoire, saisissez le !!!");
        $("#ddlCustomerList").focus();
        return false;

      } else if ($("#car_chasis_no").val() == '') {
        alert("Le numéro de chasis du véhicule est obligatoire, saisissez le !!!");
        $("#car_chasis_no").focus();
        return false;
      } else if ($("#add_date_mise_circu").val() == '') {
        alert("La date de mise en circulation du véhicule est obligatoire, saisissez la !!!");
        $("#add_date_mise_circu").focus();
        return false;
      } else if ($("#add_date_imma").val() == '') {
        alert("La date d'immatriculation du véhicule est obligatoire, saisissez la !!!");
        $("#add_date_imma").focus();
        return false;
      }
      // else if ($("#add_date_assurance").val() == '') {
      //   alert("La date de début de l'assurance du véhicule est obligatoire, saisissez la !!!");
      //   $("#add_date_assurance").focus();
      //   return false;
      // } else if ($("#add_date_assurance_fin").val() == '') {
      //   alert("La date de fin de l'assurance du véhicule est obligatoire, saisissez la !!!");
      //   $("#add_date_assurance_fin").focus();
      //   return false;
      // } 
      // else if ($("#add_date_visitetech").val() == '') {
      //   alert("La date de la prochaine visite technique du véhicule est obligatoire, saisissez la !!!");
      //   $("#add_date_visitetech").focus();
      //   return false;

      // } 
      else if ($("#genre_vehi_recep").val() == '') {
        alert("Le genre du véhicule est obligatoire !!!");
        $("#genre_vehi_recep").focus();
        return false;
      } else if ($("#energie_vehi_recep").val() == '') {
        alert("L'énergie du véhicule est obligatoire !!!");
        $("#energie_vehi_recep").focus();
        return false;
      } else if ($("#boite_vitesse_vehi_recep").val() == '') {
        alert("La boite de vitesse du véhicule est obligatoire !!!");
        $("#boite_vitesse_vehi_recep").focus();
        return false;
      } else if ($("#nb_cylindre").val() == '') {
        alert("Le nombre de cylindre du véhicule est obligatoire !!!");
        $("#nb_cylindre").focus();
        return false;
      } else if ($("#couleur_vehi").val() == '') {
        alert("La couleur du véhicule est obligatoire !!!");
        $("#couleur_vehi").focus();
        return false;
      } else if ($("#fisc_vehi").val() == '') {
        alert("La puissance fiscale du véhicule est obligatoire !!!");
        $("#fisc_vehi").focus();
        return false;
      } else if ($('input[name="uploaded_file"]').val() == '') {
        alert("Veuillez ajouter l'image du véhicule !!!");
        $('input[name="uploaded_file"]').focus();
        return false;
      } else if ($('input[name="pj_1_car"]').val() == '') {
        alert("Ajouter la 1ère pièce jointe du véhicule !!!");
        $('input[name="pj_1_car"]').focus();
        return false;
      } else if ($('input[name="pj_2_car"]').val() == '') {
        alert("Ajouter la 2ème pièce jointe du véhicule !!!");
        $('input[name="pj_2_car"]').focus();
        return false;
      }
      // else if ($('input[name="pj_3_car"]').val() == '') {
      //   alert("Ajouter la 3ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_3_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_4_car"]').val() == '') {
      //   alert("Ajouter la 4ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_4_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_5_car"]').val() == '') {
      //   alert("Ajouter la 5ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_5_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_6_car"]').val() == '') {
      //   alert("Ajouter la 6ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_6_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_7_car"]').val() == '') {
      //   alert("Ajouter la 7ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_7_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_8_car"]').val() == '') {
      //   alert("Ajouter la 8ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_8_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_9_car"]').val() == '') {
      //   alert("Ajouter la 9ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_9_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_10_car"]').val() == '') {
      //   alert("Ajouter la 10ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_10_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_11_car"]').val() == '') {
      //   alert("Ajouter la 11ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_11_car"]').focus();
      //   return false;
      // } else if ($('input[name="pj_12_car"]').val() == '') {
      //   alert("Ajouter la 12ème pièce jointe du véhicule !!!");
      //   $('input[name="pj_12_car"]').focus();
      //   return false;
      // } 
      else {
        return true;
      }
    }

    // On chargement de la page web (HTML)
    $(document).ready(function() {

      // Lorsque le véhicule est conduit, on cache tous les voyants
      var etat_vehi_arrive, scanner_mecanique, scanner_electrique;

      etat_vehi_arrive = "<?php echo $etat_vehi_arrive ?>";
      scanner_mecanique = "<?php echo $scanner_mecanique ?>";
      scanner_electrique = "<?php echo $scanner_electrique ?>";

      if (scanner_mecanique == "OUI" && scanner_electrique == "") {

        $("#scanner_recep_vehi").prop("checked", true);
        $("#scanner_recep_vehi").prop("disabled", true);

        $("#meca_recep_vehi_oui").prop("checked", true);
        $("#elec_recep_vehi_non").prop("checked", true);
        $('input[name="meca_recep_vehi"]').prop("disabled", true);
        $('input[name="elec_recep_vehi"]').prop("disabled", true);
      }

      if (scanner_mecanique == "OUI" && scanner_electrique == "OUI") {

        $("#scanner_recep_vehi").prop("checked", true);
        $("#scanner_recep_vehi").prop("disabled", true);

        $("#meca_recep_vehi_oui").prop("checked", true);
        $("#elec_recep_vehi_oui").prop("checked", true);
        $('input[name="meca_recep_vehi"]').prop("disabled", true);
        $('input[name="elec_recep_vehi"]').prop("disabled", true);

      }

      if (scanner_mecanique == "" && scanner_electrique == "OUI") {

        $("#scanner_recep_vehi").prop("checked", true);
        $("#scanner_recep_vehi").prop("disabled", true);
        $("#meca_recep_vehi_non").prop("checked", true);
        $("#elec_recep_vehi_oui").prop("checked", true);
        $('input[name="meca_recep_vehi"]').prop("disabled", true);
        $('input[name="elec_recep_vehi"]').prop("disabled", true);

      }

      if (etat_vehi_arrive != "conduit") {

        $('#voyant_box').hide();
        $('#voyant_box').css('display', 'none');

      }

      // console.log($('#carte_grise_recep_vehi_non').is(':checked'));

      // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
      $('#carte_grise_box').hide();
      $('#visite_tech_box').hide();
      $('#assurance_box').hide();
      $('#assurance_cedeao_box').hide();
      $('#otre_piece_box').hide();
      $('#contrat_assurance_box').hide();

      /****************
       *  CARTE GRISE
       ***************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#carte_grise_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        // if ($(this).is(':checked').val() == 'Carte grise')

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#carte_grise_box').show();

          // Si la valeur de ces éléments est vide, on déclenche une alerte
          // if ($('input[name="carte_grise_numero"]').val() == '') {
          //   $('input[name="carte_grise_numero"]').focus();
          //   alert("Saisissez le numéro de la carte grise SVP !!!");
          // }

          // if ($('input[name="pj_carte_grise"]').val() == '') {
          //   $('input[name="pj_carte_grise"]').focus();
          //   alert("Ajouter la photocopie de la carte grise du véhicule !!!");
          // }

        }

      })

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#carte_grise_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#carte_grise_box').hide();
          $('#carte_grise_box').css('display', 'none');

        }

      })

      /**********************
       *  VISITE TECHNIQUE
       **********************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#visite_tech_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#visite_tech_box').show();

          // Si la valeur de ces éléments est vide, on déclenche une alerte
          // if ($('input[name="visite_tech_numero"]').val() == '') {
          //   $('input[name="visite_tech_numero"]').focus();
          //   alert("Saisissez le numéro de la visite technique SVP !!!");
          // }

          // if ($('input[name="add_date_visitetech_car"]').val() == '') {
          //   $('input[name="add_date_visitetech_car"]').focus();
          //   alert("Choisissez la date de la prochaine visite technique SVP !!!");
          // }

          // if ($('input[name="pj_visite_tech"]').val() == '') {
          //   $('input[name="pj_visite_tech"]').focus();
          //   alert("Ajouter la photocopie de la visite technique du véhicule !!!");
          // }

        }

      });

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#visite_tech_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#visite_tech_box').hide();
          $('#visite_tech_box').css('display', 'none');

        }

      });

      /**************
       *  ASSURANCE
       **************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#assurance_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#assurance_box').show();

          // Si la valeur de ces éléments est vide, on déclenche une alerte
          // if ($('input[name="assurance_numero"]').val() == '') {
          //   $('input[name="assurance_numero"]').focus();
          //   alert("Saisissez le numéro de l'assurance SVP !!!");
          // }

          // if ($('input[name="assurance_vehi_recep"]').val() == '') {
          //   $('input[name="assurance_vehi_recep"]').focus();
          //   alert("Saisissez le nom de l'assurance SVP !!!");
          // }

          // if ($('input[name="add_date_assurance"]').val() == '') {
          //   $('input[name="add_date_assurance"]').focus();
          //   alert("Choisissez la date de debut de l'assurance SVP !!!");
          // }

          // if ($('input[name="add_date_assurance_fin"]').val() == '') {
          //   $('input[name="add_date_assurance_fin"]').focus();
          //   alert("Choisissez la date de fin de l'assurance SVP !!!");
          // }

          // if ($('input[name="pj_assurance"]').val() == '') {
          //   $('input[name="pj_assurance"]').focus();
          //   alert("Ajouter l'image de l'assurance du véhicule en pièce jointe SVP !!!");
          // }

        }

      });

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#assurance_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#assurance_box').hide();
          $('#assurance_box').css('display', 'none');

        }

      });

      /********************
       *  ASSURANCE CEDEAO
       *********************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#assurance_cedeao_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#assurance_cedeao_box').show();

          // if ($('input[name="pj_assurance_cedeao"]').val() == '') {
          //   $('input[name="pj_assurance_cedeao"]').focus();
          //   alert("Ajouter l'image de l'assurance CEDEAO du véhicule en pièce jointe SVP !!!");
          // }

        }

      });

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#assurance_cedeao_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#assurance_cedeao_box').hide();
          $('#assurance_cedeao_box').css('display', 'none');

        }

      });

      /**********************
       *  CONTRAT ASSURANCE
       *********************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#contrat_assurance_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#contrat_assurance_box').show();


          // if ($('input[name="pj_contrat_assurance"]').val() == '') {
          //   $('input[name="pj_contrat_assurance"]').focus();
          //   alert("Ajouter l'image du contrat d'assurance du véhicule en pièce jointe SVP !!!");
          // }

        }

      });

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#contrat_assurance_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#contrat_assurance_box').hide();
          $('#contrat_assurance_box').css('display', 'none');

        }

      });

      /**********************
       *  AUTRES PIECES
       *********************/

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#otre_piece_recep_vehi_oui').click(function() {

        // Si l'élément en question est coché, 

        if ($(this).is(':checked')) {

          // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout du scan de la carte grise
          $('#otre_piece_box').show();

          // if ($('input[name="otre_piece_numero"]').val() == '') {
          //   $('input[name="otre_piece_numero"]').focus();
          //   alert("Saisissez le numéro de la pièce SVP !!!");
          // }

          // if ($('input[name="date_otre_piece_recep_vehi"]').val() == '') {
          //   $('input[name="date_otre_piece_recep_vehi"]').focus();
          //   alert("Sélectionnez la date d'expiration de la pièce SVP !!!");
          // }

          // if ($('input[name="pj_otre_piece"]').val() == '') {
          //   $('input[name="pj_otre_piece"]').focus();
          //   alert("Ajouter l'image de la pièce SVP !!!");
          // }

        }

      });

      // Lorsqu'on clic sur l'élément ayant cet Id
      $('#otre_piece_recep_vehi_non').click(function() {

        // Si l'élément en question est coché, 
        // On cache le conteneur qui contient le champ de saisi et le bouton d'ajout
        if ($(this).is(':checked')) {

          $('#otre_piece_box').hide();
          $('#otre_piece_box').css('display', 'none');

        }

      });

    });

    $(document).ready(function() {

      $('#regForm').bootstrapValidator({
        message: 'Cette valeur n\'est pas valide',
        feedbackIcons: {
          valid: 'glyphicon glyphicon-ok',
          invalid: 'glyphicon glyphicon-remove',
          validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          car_chasis_no: {
            validators: {
              notEmpty: {
                message: 'Le numéro de chasis est obligatoire !'
              },
              stringLength: {
                min: 14,
                message: 'Le numéro de chasis doit être supérieur à 14 caractères'
              }
            }
          },
          // carte_grise_numero: {
          //   validators: {
          //     notEmpty: {
          //       message: 'Le numéro de la carte grise est obligatoire !'
          //     }
          //   }
          // },
          // visite_tech_numero: {
          //   validators: {
          //     notEmpty: {
          //       message: 'Le numéro de la visite technique est obligatoire !'
          //     }
          //   }
          // },
          // assurance_numero: {
          //   validators: {
          //     notEmpty: {
          //       message: 'Le numéro de l\'assurance est obligatoire !'
          //     }
          //   }
          // },
          assurance_vehi_recep: {
            validators: {
              notEmpty: {
                message: 'Le nom de l\'assurance est obligatoire !'
              }
            }
          }
        }
      });
    });

    $(document).ready(function() {

      // Cette fonction anonyme va écouter l'évènement de soumission du formulaire de réception d'un véhicule
      $("#regForm").submit(function(event) {
        // submitRecepForm();
        return false;
      });

    });

    function submitRecepForm() {

      // On sélectionne le 1er formulaire (formulaire de réception) et on extrait ses données
      var form = $('form')[0]
      // var formData = new FormData(form);
      var form_data = new FormData(form);
      var web_url = "http://application.luxurygarage.ci/";
      // var web_url = "http://127.0.0.1:8181/smartgarage-github/";
      var file_data = $('input[type=file]').prop('files')[0];
  
      form_data.append('file', file_data);

      // alert(form_data);

      $.ajax({
        url: "../ajax/addcar_reception_traitement.php",
        dataType: 'text', // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        type: 'post',
        success: function(php_script_response) {
          // Avant le traitement on fait une redirection
          window.location.href = web_url + "recep_panel/recep_dashboard.php?m=reception_success";
        }
      });

      // On transmet les données du formulaire au fichier de traitement 
      // $.ajax({ // Instanciation de l'objet XHR
      //   type: "POST",
      //   url: "../ajax/addcar_reception_traitement.php",
      //   cache: false,
      //   data: formData,
      //   contentType: false,
      //   processData: false,
      //   success: function() {
      //     // Avant le traitement on fait une redirection
      //     window.location.href = web_url + "recep_panel/recep_dashboard.php?m=reception_success";
      //     // $("#client-modal").modal('hide');
      //     // $("#ddlCustomerList").focus();
      //   }
      // });
    }
  </script>

</body>

</html>

<?php include('../footer.php'); ?>