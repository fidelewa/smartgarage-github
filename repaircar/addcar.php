<?php
include('../header.php');
$success = "none";
$cus_id = 0;
$car_names = '';
$c_name = '';
$c_make = 0;
$c_model = 0;
$year = "";
$c_chasis_no = '';
$vin = '';
$c_registration = '';
$c_note = '';
$c_add_date = date('d/m/Y');
$nb_cylindre = "";
$couleur_vehi = "";

$car_pneu_av = '';
$car_gente_ar = '';
$car_pneu_ar = '';
$car_gente_av = '';
$add_date_visitetech = '';
$add_date_assurance  = '';
$add_date_ctr_tech = '';
$add_date_assurance  = '';
$add_date_assurance_fin  = '';
$add_date_mise_circu = '';
$add_date_imma = '';

$fisc_vehi = '';

$title = 'Ajouter une nouvelle voiture';
$button_text = "Enregistrer information";
$successful_msg = "Add Voiture de réparation Successfully";
$form_url = WEB_URL . "repaircar/addcar.php";
$id = "";
$hdnid = "0";
$image_cus = WEB_URL . 'img/no_image.jpg';
$img_track = '';
$model_post_token = 0;

$invoice_id = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

/*added my*/
$cus_id = 0;
if (isset($_GET['cid']) && (int)$_GET['cid'] > 0) {
  $cus_id = $_GET['cid'];
}


if (isset($_POST['car_names'])) {

  // var_dump($_POST);
  // die();

  // TRAITEMENT DES PIECES JOINTES

  // Récupération des URL des pièces jointes
  if (isset($_FILES["pj_1"]) && !empty($_FILES["pj_1"])) {
    $_POST['pj1_url'] = uploadPJ_1();
  }
  if (isset($_FILES["pj_2"]) && !empty($_FILES["pj_2"])) {
    $_POST['pj2_url'] = uploadPJ_2();
  }
  if (isset($_FILES["pj_3"]) && !empty($_FILES["pj_3"])) {
    $_POST['pj3_url'] = uploadPJ_3();
  }
  if (isset($_FILES["pj_4"]) && !empty($_FILES["pj_4"])) {
    $_POST['pj4_url'] = uploadPJ_4();
  }
  if (isset($_FILES["pj_5"]) && !empty($_FILES["pj_5"])) {
    $_POST['pj5_url'] = uploadPJ_5();
  }
  if (isset($_FILES["pj_6"]) && !empty($_FILES["pj_6"])) {
    $_POST['pj6_url'] = uploadPJ_6();
  }
  if (isset($_FILES["pj_7"]) && !empty($_FILES["pj_7"])) {
    $_POST['pj7_url'] = uploadPJ_7();
  }
  if (isset($_FILES["pj_8"]) && !empty($_FILES["pj_8"])) {
    $_POST['pj8_url'] = uploadPJ_8();
  }
  if (isset($_FILES["pj_9"]) && !empty($_FILES["pj_9"])) {
    $_POST['pj9_url'] = uploadPJ_9();
  }
  if (isset($_FILES["pj_10"]) && !empty($_FILES["pj_10"])) {
    $_POST['pj10_url'] = uploadPJ_10();
  }
  if (isset($_FILES["pj_11"]) && !empty($_FILES["pj_11"])) {
    $_POST['pj11_url'] = uploadPJ_11();
  }
  if (isset($_FILES["pj_12"]) && !empty($_FILES["pj_12"])) {
    $_POST['pj12_url'] = uploadPJ_12();
  }

  $image_url = uploadImage();
  if (empty($image_url)) {
    $image_url = $_POST['img_exist'];
  }

  // Récupération du nom de la marque qui a pour id la valeur retourné par le component $_POST['ddlMake']
  $query = "SELECT make_name FROM tbl_make WHERE make_id='" . (int)$_POST['ddlMake'] . "'";

  // On teste le résultat de la requête pour vérifier qu'il n'y a pas d'erreur
  $result = mysql_query($query, $link);

  if (!$result) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query;
    die($message);
  }

  // On retourne le nom de la marque dans un tableau associatif
  $row = mysql_fetch_array($result);

  // On affecte le nom de la marque à la variable $_POST['car_names']
  $_POST['car_names'] = $row['make_name'];


  if (empty($_POST['car_gente_av'])) {
    $_POST['car_gente_av'] = "";
  }
  if (empty($_POST['car_gente_ar'])) {
    $_POST['car_gente_ar'] = "";
  }
  if (empty($_POST['car_pneu_av'])) {
    $_POST['car_pneu_av'] = "";
  }
  if (empty($_POST['car_pneu_ar'])) {
    $_POST['car_pneu_ar'] = "";
  }

  // On insère la nouvelle valeur de la colonne car_name en BDD
  $wms->saveUpdateRepairCarInformation($link, $_POST, $image_url);
  if ((int)$_POST['repair_car'] > 0) {

    // var_dump($_POST);
    // die();

    $url = WEB_URL . 'repaircar/carlist.php?m=up';
    header("Location: $url");
  } else {
    $url = WEB_URL . 'repaircar/carlist.php?m=add';
    header("Location: $url");
  }
  exit();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
  $row = $wms->getRepairCarInfoByRepairCarId($link, $_GET['id']);

  // var_dump($row);
  // die();

  if (!empty($row)) {

    $genre = $row['genre'];
    $energie = $row['energie'];
    $assurance = $row['assurance'];
    $type_boite_vitesse = $row['type_boite_vitesse'];
    $add_date_mise_circu = $row['add_date_mise_circu'];

    $add_date_imma = $row['add_date_imma'];
    $nb_cylindre = $row['nb_cylindre'];
    $couleur_vehi = $row['couleur_vehi'];
    $fisc_vehi = $row['fisc_vehi'];

    $cus_id = (int)$row['customer_id'];
    $car_names = $row['car_name'];
    $c_make = $row['car_make'];
    $c_model = $row['car_model'];
    $year = $row['year'];
    $c_chasis_no = $row['chasis_no'];

    $vin = $row['VIN'];

    $c_add_date = $row['added_date'];

    $add_date_visitetech = $row['add_date_visitetech'];
    $add_date_assurance  = $row['add_date_assurance'];
    $add_date_assurance_fin  = $row['add_date_assurance_fin'];
    $add_date_mise_circu = $row['add_date_mise_circu'];
    $add_date_imma = $row['add_date_imma'];

    if ($row['image'] != '') {
      $image_cus = WEB_URL . 'img/upload/' . $row['image'];
      $img_track = $row['image'];
    }
    $invoice_id = $row['repair_car_id'];
    $hdnid = $_GET['id'];
    $title = 'Modification des informations de la voiture';
    $button_text = "Modifier les informations";

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

function uploadPJ_1()
{
  if ((!empty($_FILES["pj_1"])) && ($_FILES['pj_1']['error'] == 0)) {
    $filename = basename($_FILES['pj_1']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_1"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_1"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_1"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_1"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_1"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_1"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_2()
{
  if ((!empty($_FILES["pj_2"])) && ($_FILES['pj_2']['error'] == 0)) {
    $filename = basename($_FILES['pj_2']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_2"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_2"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_2"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_2"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_2"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_2"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_3()
{
  if ((!empty($_FILES["pj_3"])) && ($_FILES['pj_3']['error'] == 0)) {
    $filename = basename($_FILES['pj_3']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_3"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_3"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_3"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_3"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_3"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_3"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_4()
{
  if ((!empty($_FILES["pj_4"])) && ($_FILES['pj_4']['error'] == 0)) {
    $filename = basename($_FILES['pj_4']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_4"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_4"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_4"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_4"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_4"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_4"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_5()
{
  if ((!empty($_FILES["pj_5"])) && ($_FILES['pj_5']['error'] == 0)) {
    $filename = basename($_FILES['pj_5']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_5"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_5"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_5"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_5"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_5"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_5"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_6()
{
  if ((!empty($_FILES["pj_6"])) && ($_FILES['pj_6']['error'] == 0)) {
    $filename = basename($_FILES['pj_6']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_6"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_6"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_6"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_6"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_6"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_6"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_7()
{
  if ((!empty($_FILES["pj_7"])) && ($_FILES['pj_7']['error'] == 0)) {
    $filename = basename($_FILES['pj_7']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_7"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_7"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_7"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_7"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_7"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_7"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_8()
{
  if ((!empty($_FILES["pj_8"])) && ($_FILES['pj_8']['error'] == 0)) {
    $filename = basename($_FILES['pj_8']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_8"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_8"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_8"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_8"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_8"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_8"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_9()
{
  if ((!empty($_FILES["pj_9"])) && ($_FILES['pj_9']['error'] == 0)) {
    $filename = basename($_FILES['pj_9']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_9"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_9"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_9"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_9"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_9"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_9"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_10()
{
  if ((!empty($_FILES["pj_10"])) && ($_FILES['pj_10']['error'] == 0)) {
    $filename = basename($_FILES['pj_10']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_10"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_10"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_10"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_10"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_10"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_10"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_11()
{
  if ((!empty($_FILES["pj_11"])) && ($_FILES['pj_11']['error'] == 0)) {
    $filename = basename($_FILES['pj_11']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_11"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_11"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_11"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_11"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_11"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_11"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

function uploadPJ_12()
{
  if ((!empty($_FILES["pj_12"])) && ($_FILES['pj_12']['error'] == 0)) {
    $filename = basename($_FILES['pj_12']['name']);
    $ext = substr($filename, strrpos($filename, '.') + 1);
    if (($ext == "jpg" && $_FILES["pj_12"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["pj_12"]["type"] == 'image/png')
      || ($ext == "gif" && $_FILES["pj_12"]["type"] == 'image/gif') || ($ext == "pdf" && $_FILES["pj_12"]["type"] == 'application/pdf') || ($ext == "docx")
    ) {
      $temp = explode(".", $_FILES["pj_12"]["name"]);
      $newfilename = NewGuid() . '.' . end($temp);
      move_uploaded_file($_FILES["pj_12"]["tmp_name"], ROOT_PATH . '/img/upload/car/' . $newfilename);
      return $newfilename;
    } else {
      return '';
    }
  }
  return '';
}

$msg = '';
$addinfo = 'none';
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $addinfo = 'block';
  $msg = "Ajout des informations sur la voiture de réparation avec succès";
}
if (isset($_GET['m']) && $_GET['m'] == 'add_customer') {
  $addinfo = 'block';
  $msg = "Ajout du client réussi";
}
if (isset($_GET['m']) && $_GET['m'] == 'add_assurance') {
  $addinfo = 'block';
  $msg = "Assurance insérée avec succès";
}

?>
<!-- Content Header (Page header) -->

<div class="container">

  <section class="content-header">
    <h1> Création de véhicule</h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="<?php echo WEB_URL ?>repaircar/carlist.php"> Création de véhicule</a></li>
      <li class="active">Création de véhicule</li>
    </ol>
  </section>

  <!-- Main content -->
  <form method="post" enctype="multipart/form-data">
    <section class="content">
      <!-- Full Width boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
          <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
            <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            <?php echo $msg; ?>
          </div>

          <!-- <div class="box box-success" id="box_model"> -->

          <!-- </div> -->
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
                <label for="assurance_vehi_recep"><span style="color:red;">*</span> Client :</label>
                <div class="row">
                  <div class="col-md-11">
                    
                    <!-- <input type="text" class='form-control' name="ddlCustomerList" id="ddlCustomerList" placeholder="Saisissez le nom du client" onfocus=""> -->
                    <select class='form-control' id="ddlCustomerList" name="ddlCustomerList">
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
                    </select>
                  </div>
                  <div class="col-md-1" id="client">
                    <a class="btn btn-success" data-toggle="modal" data-target="#client-modal" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a>
                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer_reception.php" data-original-title="Ajouter un nouveau client"><i class="fa fa-plus"></i></a> -->
                  </div>
                </div>
              </div>
              <input type="hidden" value="<?php echo $car_names; ?>" name="car_names" />
              <div class="form-group">
                <label for="ddlYear"><span style="color:red;">*</span> Année :</label>
                <input type="text" class='form-control' value="<?php echo $year; ?>" name="ddlYear" id="ddlYear" placeholder="Saisissez l'année de la voiture" required>
                <!-- <div class="form-group col-md-3"> -->
                <!-- <select required class='form-control' name="ddlYear" id="ddlYear">
                  <?php
                  if (isset($year)) {
                    echo "<option selected value='" . $year . "'>" . $year . "</option>";
                  } else { ?>

                                <option value="">--Sélectionner l'année de votre voiture--</option>
                                <option value="2020">2020</option>
                                <option value="2019">2019</option>
                                <option value="2018">2018</option>
                                <option value="2017">2017</option>
                                <option value="2016">2016</option>
                                <option value="2015">2015</option>
                                <option value="2014">2014</option>
                                <option value="2013">2013</option>
                                <option value="2012">2012</option>
                                <option value="2011">2011</option>
                                <option value="2010">2010</option>
                                <option value="2009">2009</option>
                                <option value="2008">2008</option>
                                <option value="2007">2007</option>
                                <option value="2006">2006</option>
                                <option value="2005">2005</option>
                                <option value="2004">2004</option>
                                <option value="2003">2003</option>
                                <option value="2002">2002</option>
                                <option value="2001">2001</option>
                                <option value="2000">2000</option>
                                <option value="1999">1999</option>
                                <option value="1998">1998</option>
                                <option value="1997">1997</option>
                                <option value="1996">1996</option>
                                <option value="1995">1995</option>
                                <option value="1994">1994</option>
                                <option value="1993">1993</option>
                                <option value="1992">1992</option>
                                <option value="1991">1991</option>
                                <option value="1990">1990</option>
                                <option value="1999">1989</option>
                                <option value="1998">1988</option>
                                <option value="1997">1987</option>
                                <option value="1996">1986</option>
                                <option value="1995">1985</option>
                                <option value="1994">1984</option>
                                <option value="1993">1983</option>
                                <option value="1992">1982</option>
                                <option value="1991">1981</option>
                                <option value="1990">1980</option>
                                <option value="1999">1979</option>
                                <option value="1998">1978</option>
                                <option value="1997">1977</option>
                                <option value="1996">1976</option>
                                <option value="1995">1975</option>
                                <option value="1994">1974</option>
                                <option value="1993">1973</option>
                                <option value="1992">1972</option>
                                <option value="1991">1971</option>
                                <option value="1990">1970</option>
                                <option value="1999">1969</option>
                                <option value="1998">1968</option>
                                <option value="1997">1967</option>
                                <option value="1996">1966</option>
                                <option value="1995">1965</option>
                                <option value="1994">1964</option>
                                <option value="1993">1963</option>
                                <option value="1992">1962</option>
                                <option value="1991">1961</option>
                                <option value="1990">1960</option>

                  <?php } ?>
                </select> -->
                <!-- <input type="text" placeholder="Year Name" value="<?php echo $year_name; ?>" name="txtYear" id="txtYear" class="form-control" required /> -->
                <!-- </div> -->
              </div>
              <div class="form-group">
                <label for="car_chasis_no"><span style="color:red;">*</span> Chasis No :</label>
                <input required type="text" name="car_chasis_no" value="<?php echo $c_chasis_no; ?>" id="car_chasis_no" class="form-control" placeholder="Saisissez le numéro de chasis de la voiture">
              </div>
              <!-- <div class="form-group">
                <label for="car_note">Note :</label>
                <textarea type="text" name="car_note" value="" id="car_note" class="form-control"><?php echo $c_note; ?></textarea>
              </div> -->
              <div class="form-group">
                <label for="add_date">Date d'enregistrement:</label>
                <input type="text" name="add_date" value="<?php echo $c_add_date; ?>" id="add_date" class="form-control datepicker" placeholder="veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de mise en circulation:</label>
                <input required type="text" name="add_date_mise_circu" value="<?php echo $add_date_mise_circu; ?>" id="add_date_mise_circu" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date d'immatriculation:</label>
                <input required type="text" name="add_date_imma" value="<?php echo $add_date_imma; ?>" id="add_date_imma" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de début de l'assurance:</label>
                <input required type="text" name="add_date_assurance" value="<?php echo $add_date_assurance; ?>" id="add_date_assurance" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <div class="form-group">
                <label for="add_date"><span style="color:red;">*</span> Date de fin de l'assurance:</label>
                <input required type="text" name="add_date_assurance_fin" value="<?php echo $add_date_assurance_fin; ?>" id="add_date_assurance_fin" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <!-- <div class="form-group">
                <label for="duree_assurance"><span style="color:red;">*</span> Durée de l'assurance :</label>
                <select required class='form-control' id="duree_assurance" name="duree_assurance">
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
                <label for="add_date"><span style="color:red;">*</span> Date de la prochaine visite technique:</label>
                <input required type="text" name="add_date_visitetech" value="<?php echo $add_date_visitetech; ?>" id="add_date_visitetech" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div>
              <!-- <div class="form-group">
                <label for="add_date_ctr_tech"><span style="color:red;">*</span> Date du contrôle technique:</label>
                <input required type="text" name="add_date_ctr_tech" value="<?php echo $add_date_ctr_tech; ?>" id="add_date_ctr_tech" class="form-control datepicker" placeholder="Veuillez cliquer pour choisir une date" />
              </div> -->
              <!-- <div class="form-group">
                <label for="delai_ctr_tech"><span style="color:red;">*</span> Délai du contrôle technique :</label>
                <select required class='form-control' id="delai_ctr_tech" name="delai_ctr_tech">
                  <option value="">--Sélectionner le délai du contrôle technique du véhicule--</option>
                  <option value="P3M">3 mois</option>
                  <option value="P6M">6 mois</option>
                </select>
              </div> -->
              <div class="form-group">
                <label for="genre_vehi_recep"><span style="color:red;">*</span> Genre :</label>

                <select required class='form-control' id="genre_vehi_recep" name="genre_vehi_recep">

                  <option value="">--Sélectionner un genre de véhicule--</option>
                  <?php if (isset($genre) && ($genre == "particulier")) {
                    echo "<option selected value='" . $genre . "'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($genre) && ($genre == "utilitaire")) {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option selected value='" . $genre . "'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($genre) && ($genre == "berline")) {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option selected value='" . $genre . "'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($genre) && ($genre == "suv")) {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option selected value='" . $genre . "'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($genre) && ($genre == "pick-up")) {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option selected value='" . $genre . "'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($genre) && ($genre == "autre")) {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option selected value='" . $genre . "'>Autre</option>";
                  } else {
                    echo "<option value='particulier'>Particulier</option>";
                    echo "<option value='utilitaire'>Utilitaire</option>";
                    echo "<option value='berline'>Berline</option>";
                    echo "<option value='suv'>SUV</option>";
                    echo "<option value='pick-up'>Pick-up</option>";
                    echo "<option value='autre'>Autre</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="energie_vehi_recep"><span style="color:red;">*</span> Energie :</label>
                <select required class='form-control' id="energie_vehi_recep" name="energie_vehi_recep">
                  <option value="">--Sélectionner le type de carburant du véhicule--</option>
                  <?php if (isset($energie) && ($energie == "essence")) {
                    echo "<option selected value='" . $energie . "'>Essence</option>";
                    echo "<option value='gasoil'>Gasoil</option>";
                    echo "<option value='diesel'>Diesel</option>";
                    echo "<option value='hybride'>Hybride</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($energie) && ($energie == "gasoil")) {
                    echo "<option value='essence'>Essence</option>";
                    echo "<option selected value='" . $energie . "'>Gasoil</option>";
                    echo "<option value='diesel'>Diesel</option>";
                    echo "<option value='hybride'>Hybride</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($energie) && ($energie == "diesel")) {
                    echo "<option value='essence'>Essence</option>";
                    echo "<option value='gasoil'>Gasoil</option>";
                    echo "<option selected value='" . $energie . "'>Diesel</option>";
                    echo "<option value='hybride'>Hybride</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($energie) && ($energie == "hybride")) {
                    echo "<option value='essence'>Essence</option>";
                    echo "<option value='gasoil'>Gasoil</option>";
                    echo "<option value='diesel'>Diesel</option>";
                    echo "<option selected value='" . $energie . "'>Hybride</option>";
                    echo "<option value='autre'>Autre</option>";
                  } elseif (isset($energie) && ($energie == "autre")) {
                    echo "<option value='essence'>Essence</option>";
                    echo "<option value='gasoil'>Gasoil</option>";
                    echo "<option value='diesel'>Diesel</option>";
                    echo "<option value='hybride'>Hybride</option>";
                    echo "<option selected value='" . $energie . "'>Autre</option>";
                  } else {
                    echo "<option value='essence'>Essence</option>";
                    echo "<option value='gasoil'>Gasoil</option>";
                    echo "<option value='diesel'>Diesel</option>";
                    echo "<option value='hybride'>Hybride</option>";
                    echo "<option value='autre'>Autre</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="boite_vitesse_vehi_recep"><span style="color:red;">*</span> Boite vitesse :</label>
                <select required class='form-control' id="boite_vitesse_vehi_recep" name="boite_vitesse_vehi_recep">
                  <option value="">--Sélectionner le type de boite de vitesse--</option>
                  <?php if (isset($type_boite_vitesse) && ($type_boite_vitesse == "automatique")) {
                    echo "<option selected value='" . $type_boite_vitesse . "'>Automatique</option>";
                    echo "<option value='manuel'>Manuel</option>";
                  } elseif (isset($type_boite_vitesse) && ($type_boite_vitesse == "manuel")) {
                    echo "<option value='automatique'>Automatique</option>";
                    echo "<option selected value='" . $type_boite_vitesse . "'>Manuel</option>";
                  } else {
                    echo "<option value='automatique'>Automatique</option>";
                    echo "<option value='Manuel'>Manuel</option>";
                  }
                  ?>
                </select>
              </div>

              <div class="form-group">
                <label for="nb_cylindre"><span style="color:red;">*</span> Nombre de cylindre :</label>
                <input required type="number" id="nb_cylindre" value="<?php echo $nb_cylindre ?>" name="nb_cylindre" min="0" max="100" class='form-control'>
              </div>

              <div class="form-group">
                <label for="couleur_vehi"><span style="color:red;">*</span> Couleur :</label>
                <input type="text" name="couleur_vehi" value="<?php echo $couleur_vehi ?>" id="couleur_vehi" class="form-control" />
                <!-- <select required class='form-control' id="couleur_vehi" name="couleur_vehi">
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
                </select> -->
              </div>

              <div class="form-group">
                <label for="fisc_vehi"><span style="color:red;">*</span> Puissance fiscale</label>
                <input required type="text" name="fisc_vehi" value="<?php echo $fisc_vehi; ?>" id="fisc_vehi" class="form-control" />
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
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_7" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_8" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_9" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_10" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_11" onchange="loadFile(event)" />
                    </span>
                  </div>
                  <div class="col-md-1">
                    <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_12" onchange="loadFile(event)" />
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
          <!-- /.box -->
          <div class="pull-right">
            <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
              <?php echo $button_text; ?></button>&emsp;
            <?php if (isset($_GET['id']) && $_GET['id'] != '') { ?>
              <button type="button" onclick="javascript:window.print();" class="btn btn-danger btnsp"><i class="fa fa-print fa-2x"></i><br />
                Imprimer</button>&emsp;
            <?php } ?>
            <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/carlist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
              Retour</a> </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
  </form>
</div>
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
            <input type="text" name="princ_tel" value="" id="princ_tel" class="form-control" placeholder="Saisissez votre numéro de téléphone principal" />
          </div>
          <div class="form-group">
            <label for="txtCEmail"> <span style="color:red;">*</span>Email (ou numéro de téléphone si vous n'avez pas d'email):</label>
            <input type="text" name="txtCEmail" value="" id="txtCEmail" class="form-control" />
          </div>

          <div class="form-group">
            <label for="txtCAddress"> Addresse :</label>
            <textarea name="txtCAddress" id="txtCAddress" class="form-control"></textarea>
          </div>

          <fieldset>
            <legend>Ajouter des fichiers joints</legend>
            <div class="row">
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_1_client" id="pj_1_client" onchange="loadFile(event)" />
                </span>
              </div>
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_2_client" id="pj_2_client" onchange="loadFile(event)" />
                </span>
              </div>
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_3_client" id="pj_3_client" onchange="loadFile(event)" />
                </span>
              </div>
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_4_client" id="pj_4_client" onchange="loadFile(event)" />
                </span>
              </div>
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_5_client" id="pj_5_client" onchange="loadFile(event)" />
                </span>
              </div>
              <div class="col-sm-2">
                <span class="btn btn-file btn btn-primary">Ajouter<input type="file" name="pj_6_client" id="pj_6_client" onchange="loadFile(event)" />
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

<script type="text/javascript">
  function validateMe() {
    if ($("#ddlCustomerList").val() == '') {
      alert("Nom du client est Obligatoire !!!");
      $("#ddlCustomerList").focus();
      return false;
    } else if ($("#car_names").val() == '') {
      alert("Nom de la voiture est Obligatoire !!!");
      $("#car_names").focus();
      return false;
    } else if ($("#ddlMake").val() == '') {
      alert("Car Make est Obligatoire !!!");
      $("#ddlMake").focus();
      return false;
    } else if ($("#ddl_model").val() == '') {
      alert("Car Model est Obligatoire !!!");
      $("#ddl_model").focus();
      return false;
    } else if ($("#ddlYear").val() == '') {
      alert("Car Year est Obligatoire !!!");
      $("#ddlYear").focus();
      return false;
    } else if ($("#car_chasis_no").val() == '') {
      alert("Car Chasis no est Obligatoire !!!");
      $("#car_chasis_no").focus();
      return false;
    } else if ($("#registration").val() == '') {
      alert("Registration est Obligatoire !!!");
      $("#registration").focus();
      return false;
    } else {
      return true;
    }
  }
</script>
<?php include('../footer.php'); ?>