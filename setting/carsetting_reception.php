<?php
include('../header.php');

/*variables*/
$delinfo = 'none';
$addinfo = 'none';
$msg = '';
$del_msg = '';
$make_name = '';
$model_name = '';
$make_id = 0;
$make_id_year = 0;
$model_id = 0;
$year_name = '';
$make_button_label = 'Enregistrer la marque';
$model_button_label = 'Enregistrer le modèle';
$year_button_label = 'Enregistrer  Année';
$make_post_token = 0;
$model_post_token = 0;
$year_post_token = 0;
//
if (isset($_POST['form_token'])) {
  if ($_POST['form_token'] == 'make') {
    $wms->saveUpdateMakeSetup($link, $_POST);
    if ($_POST['submit_token'] == '0') {
      $addinfo = 'block';
      $msg = "Make Inserted Successfuly";
    } else {
      $addinfo = 'block';
      $msg = "Make Updated Successfuly";
    }
  } else if ($_POST['form_token'] == 'model') {

    // On récupérer la liste des modèles de véhicule en fonction de la marque et du modèle
    $rows = $wms->get_model_make_list_by_make($link, $_POST['ddlMake'], $_POST['txtModelName']);

    // var_dump($rows);
    // die();

    // Si le nom du modèle saisi pour la marque choisie existe déja, on n'insère pas le nouveau modèle saisi en BDD
    // Dans le cas contraire on insère le nouveau modèle saisi
    if(empty($rows)){
      $wms->saveUpdateModelSetup($link, $_POST);

      if ($_POST['submit_token'] == '0') {
        $addinfo = 'block';
        $msg = "Model Inserted Successfuly";
      } else {
        $addinfo = 'block';
        $msg = "Model Updated Successfuly";
      }
    } else {
        $interinfo = 'block';
        $inter_msg = "Ce modèle de marque de voiture existe déjà";
    }
    
  } else if ($_POST['form_token'] == 'year') {
    $wms->saveUpdateYearSetup($link, $_POST);
    if ($_POST['submit_token'] == '0') {
      $addinfo = 'block';
      $msg = "Year Inserted Successfuly";
    } else {
      $addinfo = 'block';
      $msg = "Year Updated Successfuly";
    }
  }
}


/************************ Make edit and delete ***************************/
if (isset($_GET['mid']) && $_GET['mid'] != '') {
  $row = $wms->getCarMakeDataByMakeId($link, $_GET['mid']);
  if (!empty($row)) {
    $make_name = $row['make_name'];
  }
  $make_button_label = 'Update Make';
  $make_post_token = $_GET['mid'];
}
if (isset($_GET['mdelid']) && $_GET['mdelid'] != '') {
  $wms->deleteMakeData($link, $_GET['mdelid']);
  $delinfo = 'block';
  $del_msg = "Make Delete Successfuly";
}

/************************ Model edit and delete ***************************/
if (isset($_GET['moid']) && $_GET['moid'] != '') {
  //view
  $row = $wms->getCarModelDataByModelId($link, $_GET['moid']);
  if (!empty($row)) {
    $make_id = $row['make_id'];
    $model_name = $row['model_name'];
  }
  $model_button_label = 'Update Model';
  $model_post_token = $_GET['moid'];
  //mysql_close($link);
}

if (isset($_GET['modelid']) && $_GET['modelid'] != '') {
  $wms->deleteModelData($link, $_GET['modelid']);
  $delinfo = 'block';
  $del_msg = "Model Delete Successfuly";
}

/************************ Year edit and delete ***************************/
if (isset($_GET['yid']) && $_GET['yid'] != '') {
  $row = $wms->getCarYearDataByYearId($link, $_GET['yid']);
  if (!empty($row)) {
    $make_id_year = $row['make_id'];
    $model_id = $row['model_id'];
    $year_name = $row['year_name'];
  }
  $year_button_label = 'Update Year';
  $year_post_token = $_GET['yid'];
}

if (isset($_GET['ydelid']) && $_GET['ydelid'] != '') {
  $wms->deleteYearData($link, $_GET['ydelid']);
  $delinfo = 'block';
  $del_msg = "Year Delete Successfuly";
}
/**************************************************************/

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1> Page Paramètres de marque/modèle/année </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Car Setting</li>
    <li class="active">Make/Model/Year</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <!-- Full Width boxes (Stat box) -->
  <div class="row">
    <div class="col-md-12">
      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
        <?php echo $del_msg; ?>
      </div>
      <?php if(isset($interinfo) && isset($inter_msg)) { ?>
      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $interinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Interdit!</h4>
        <?php echo $inter_msg; ?>
      </div>
      <?php } ?>
      <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        <?php echo $msg; ?>
      </div>
      <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting.php" data-original-title="Refresh Page"><i class="fa fa-refresh"></i></a> &nbsp;<a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar_reception.php" data-original-title="Back"><i class="fa fa-reply"></i></a></div>
      <div class="box box-success">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout Marque</h3>
            </div>
            <div class="form-group col-md-10">
              <input type="text" placeholder="Nom de la marque" value="<?php echo $make_name; ?>" name="txtMakeName" id="txtMakeName" class="form-control" required />
            </div>
            <div class="form-group col-md-2">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $make_button_label; ?>" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Marque</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_make_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['make_name']; ?></td>
                      <td><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting.php?mid=<?php echo $row['make_id']; ?>" data-original-title="Ajouter votre voiture"><i class="fa fa-edit"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/carsetting.php?mdelid=<?php echo $row['make_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="make" name="form_token" />
          <input type="hidden" value="<?php echo $make_post_token; ?>" name="submit_token" />
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-success" id="box_model">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout Modèle</h3>
            </div>
            <div class="form-group col-md-4">
              <select class="form-control" name="ddlMake" required>
                <option value=''>--Sélectionnez Marque--</option>
                <?php
                $result = $wms->get_all_make_list($link);
                foreach ($result as $row) {
                  if ($make_id > 0 && $make_id == $row['make_id']) {
                    echo "<option selected value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                  } else {
                    echo "<option value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                  }
                } ?>
              </select>
            </div>
            <div class="form-group col-md-4">
              <input type="text" placeholder="Model Name" name="txtModelName" id="txtModelName" value="<?php echo $model_name; ?>" class="form-control" required />
            </div>
            <div class="form-group col-md-4">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $model_button_label; ?>" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Nom de la marque</th>
                    <th>Modèle de la marque</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_model_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['make_name']; ?></td>
                      <td><?php echo $row['model_name']; ?></td>
                      <td><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting.php?moid=<?php echo $row['model_id']; ?>#box_model" data-original-title="Ajouter votre voiture"><i class="fa fa-edit"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/carsetting.php?modelid=<?php echo $row['model_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="model" name="form_token" />
          <input type="hidden" value="<?php echo $model_post_token; ?>" name="submit_token" />
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-success" id="box_year">
        <form method="post" enctype="multipart/form-data">
          <div class="box-body">
            <div class="box-header">
              <h3 class="box-title">Ajout Année</h3>
            </div>
            <div class="form-group col-md-3">
              <select onchange="loadYear(this.value);" class="form-control" name="ddlMake" required>
                <option value="">--Sélectionnez Marque--</option>
                <?php
                $result = $wms->get_all_make_list($link);
                foreach ($result as $row) {
                  if ($make_id_year > 0 && $make_id_year == $row['make_id']) {
                    echo "<option selected value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                  } else {
                    echo "<option value='" . $row['make_id'] . "'>" . $row['make_name'] . "</option>";
                  }
                } ?>
              </select>
            </div>
            <div class="form-group col-md-3">
              <select class="form-control" name="ddlModel" id="ddl_model" required>
                <option value="">--Choisir un modèle--</option>
                <?php
                if ($make_id_year > 0 && $model_id > 0) {
                  $result = $wms->get_all_model_list($link);
                  foreach ($result as $row) {
                    if ($model_id > 0 && $model_id == $row['model_id']) {
                      echo "<option selected value='" . $row['model_id'] . "'>" . $row['model_name'] . "</option>";
                    } else {
                      echo "<option value='" . $row['model_id'] . "'>" . $row['model_name'] . "</option>";
                    }
                  }
                }
                ?>
              </select>
            </div>
            <div class="form-group col-md-3">
                <select class='form-control' id="txtYear" name="txtYear">
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
                </select>
              <!-- <input type="text" placeholder="Year Name" value="<?php echo $year_name; ?>" name="txtYear" id="txtYear" class="form-control" required /> -->
            </div>
            <div class="form-group col-md-3">
              <input type="submit" name="submit" class="btn btn-success" value="<?php echo $year_button_label; ?>" />
              <input type="hidden" value="<?php echo $year_post_token; ?>" name="submit_token" />
            </div>
            <br>
            <br>
            <br>
            <br>
            <div>
              <table class="table sakotable table-bordered table-striped dt-responsive">
                <thead>
                  <tr>
                    <th>Nom de la marque</th>
                    <th>Nom Modèle</th>
                    <th>Année</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $result = $wms->get_all_year_list($link);
                  foreach ($result as $row) { ?>
                    <tr>
                      <td><?php echo $row['make_name']; ?></td>
                      <td><?php echo $row['model_name']; ?></td>
                      <td><?php echo $row['year_name']; ?></td>
                      <td><a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/carsetting.php?yid=<?php echo $row['year_id']; ?>#box_year" data-original-title="Ajouter votre voiture"><i class="fa fa-edit"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/carsetting.php?ydelid=<?php echo $row['year_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a></td>
                    </tr>
                  <?php } 
                ?>
                </tbody>
              </table>
            </div>
          </div>
          <input type="hidden" value="year" name="form_token" />
        </form>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
  <!-- /.row -->
  <?php include('../footer.php'); ?>