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
} 
else {
  $recep_id = 0;
}


// var_dump($_SESSION);

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
                <input type="text" name="vin" value="<?php echo $vin ?>" id="vin" class="form-control" placeholder="Saisissez l'immatriculation de la voiture" />
              </div>
              <div class="form-group">
                <label for="ddlMake"><span style="color:red;">*</span> Marque :</label>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class='form-control' name="ddlMake" id="ddlMake" placeholder="Saisissez la marque de la voiture">
                    <!-- <select class="form-control" onchange="loadYear(this.value);" name="ddlMake" id="ddlMake" onfocus="getAllMarque();">
                      <option value=''>--Sélectionnez Marque--</option>
                      <?php
                      $result = $wms->get_all_make_list($link);
                      foreach ($result as $row) {
                        if ($c_make > 0 && $c_make == $row['make_id']) {
                          echo "<option selected value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                        } else {
                          echo "<option value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                        }
                      } ?>
                    </select> -->
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
                    <input type="text" class='form-control' name="ddlModel" id="ddl_model" placeholder="Saisissez le modèle de la voiture">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="assurance_vehi_recep"><span style="color:red;">*</span> Assurance :</label>
                <div class="row">
                  <div class="col-md-12">
                    <input type="text" class='form-control' name="assurance_vehi_recep" id="assurance_vehi_recep" placeholder="Saisissez l'assurance de la voiture">
                    <!-- <select class='form-control' id="assurance_vehi_recep" name="assurance_vehi_recep">
                      <option value="">--Sélectionner l'assurance du véhicule--</option>
                      <?php
                      $result = $wms->get_all_assurance_vehicule_list($link);
                      foreach ($result as $row) {
                        echo "<option value='" . $row['assur_vehi_libelle'] . "'>" . $row['assur_vehi_libelle'] . "</option>";
                      } ?>
                    </select> -->
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="assurance_vehi_recep"><span style="color:red;">*</span> Client :<span style="color:red;"> (si le client n'existe pas encore, veuillez cliquer sur le bouton "+" pour l'enregistrer)</span></label>
                <div class="row">
                  <div class="col-md-11">
                    <input onkeyup="verifClient(this.value);" type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client s'il existe déja" onfocus=""><span id="clientbox"></span>
                    <!-- <select class='form-control' id="ddlCustomerList" name="ddlCustomerList">
                      <option value="">--Saisissez ou sélectionnez un client--</option>
                      <?php
                      $customer_list = $wms->getAllCustomerList($link);
                      foreach ($customer_list as $crow) {
                        if ($cus_id > 0 && $cus_id == $crow['customer_id']) {
                          echo '<option selected value="' . $crow['customer_id'] . '">' . $crow['c_name'] . '</option>';
                        } else {
                          echo '<option value="' . $crow['customer_id'] . '">' . $crow['c_name'] . '</option>';
                        }
                      }
                      ?>
                    </select> -->
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
                <input type="text" name="car_chasis_no" value="<?php echo $c_chasis_no; ?>" id="car_chasis_no" class="form-control" placeholder="Saisissez le numéro de chasis de la voiture">
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
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de début de l'assurance:</label>
                <input type="text" name="add_date_assurance_car" value="" id="add_date_assurance" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de fin de l'assurance:</label>
                <input type="text" name="add_date_assurance_fin" value="" id="add_date_assurance_fin" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de la prochaine visite technique:</label>
                <input type="text" name="add_date_visitetech_car" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
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

              <div class="form-group">
                <label for="km_last_vidange"> Kilométrage de dernière vidange :</label>
                <input type="text" id="km_last_vidange" maxlength="6" name="km_last_vidange" class='form-control' value="<?php echo $km_last_vidange; ?>" placeholder="Veuillez saisir le kilométrage de la dernière vidange" />
              </div>
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
              <input type="text" name="add_date" value="<?php echo $c_add_date; ?>" id="add_date" class="form-control datepicker" placeholder="Saisissez la date de reception du véhicule" />
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
                <input type="checkbox" id="cle_recep_vehi" name="cle_recep_vehi" value="Clé du véhicule" class="form-check-input" />
                <label for="clé du véhicule"> Clé du véhicule</label>
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


          <input type="hidden" name="add_date_assurance" value="<?php echo $add_date_assurance; ?>" id="add_date_assurance" class="datepicker form-control" />
          <input type="hidden" name="add_date_visitetech" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="datepicker form-control" />

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
                <label for="visite technique"><span style="color:red;">*</span> Visite technique</label>
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
              <input type="checkbox" id="anneau_remorquage_recep_vehi" name="anneau_remorquage_recep_vehi" value="Anneau de remorquage">
              <label for="anneau_remorquage_recep_vehi">Anneau de remorquage</label>
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
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2_recep" />
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
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3_recep" />
                </span>
              </div>
              <div class="col-md-1 col-md-onset-10">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4_recep" />
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

              <!-- Climatisation -->
              <div class="form-group row">
                <label for="climatisation" class="col-md-6 col-form-label">Climatisation</label>
                <div class="col-md-2 form-check" style="padding-left:0px;">
                  <input class="form-check-input" type="radio" name="climatisation" id="climatisation" value="Bon" checked>
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
          <h1 style="text-align:center;">Travaux à effectuer</h1>
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
          <input type="hidden" value="<?php echo $hdnid; ?>" name="customer_id" />
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
      if (n == 1 && !validateForm() && !validateMe()) return false;
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
      } else if ($("#assurance_vehi_recep").val() == '') {
        alert("L'assurance du véhicule est obligatoire, saisissez la !!!");
        $("#assurance_vehi_recep").focus();
        return false;
      } else if ($("#ddlCustomerList").val() == '') {
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
      } else if ($("#add_date_assurance").val() == '') {
        alert("La date de début de l'assurance du véhicule est obligatoire, saisissez la !!!");
        $("#add_date_assurance").focus();
        return false;
      } else if ($("#add_date_assurance_fin").val() == '') {
        alert("La date de fin de l'assurance du véhicule est obligatoire, saisissez la !!!");
        $("#add_date_assurance_fin").focus();
        return false;

      } else if ($("#add_date_visitetech").val() == '') {
        alert("La date de la prochaine visite technique du véhicule est obligatoire, saisissez la !!!");
        $("#add_date_visitetech").focus();
        return false;

      } else if ($("#genre_vehi_recep").val() == '') {
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
      } else if ($("#cle_recep_vehi_text").val() == '') {
        alert("Le nombre de clé du véhicule est obligatoire !!!");
        $("#cle_recep_vehi_text").focus();
        return false;
      } else if ($("#cle_recep_vehi_text").val() == '') {
        alert("Le nombre de clé du véhicule est obligatoire, saisissez le !!!");
        $("#cle_recep_vehi_text").focus();
        return false;
      } else if ($("#km_reception_vehi").val() == '') {
        alert("Le kilométrage du véhicule est obligatoire !!!");
        $("#km_reception_vehi").focus();
        return false;
      } else {
        return true;
      }
    }
  </script>

</body>

</html>

<?php include('../footer.php'); ?>