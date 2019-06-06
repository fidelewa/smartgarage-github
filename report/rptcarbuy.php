<?php 
include_once('../header.php');
include_once('../helper/common.php');
include('../helper/calculation.php');
$delivery_list = array();
$token = 0;
$filter = array(
	'date'		=> '',
	'month'		=> '',
	'year'		=> '',
	'status'	=> '1',
	'condition'	=> 'new',
	'payment'	=> ''
);
if(!empty($_POST)) {
	$filter = array(
		'date'		=> '',
		'month'		=> '',
		'year'		=> '',
		'status'	=> $_POST['ddlCarStatus'],
		'condition'	=> $_POST['ddlCondition'],
		'payment'	=> $_POST['ddlPayment']
	);
	if(!empty($_POST['txtBuyDate'])) {
		$filter['date'] = $_POST['txtBuyDate'];
	}
	if(!empty($_POST['ddlMonth'])) {
		$filter['month'] = $_POST['ddlMonth'];
	}
	if(!empty($_POST['ddlYear'])) {
		$filter['year'] = $_POST['ddlYear'];
	}
	$results = $wms->getAllBuyCarReportList($link, $filter);
	$token = 1;
}
$wmscalc = new wms_calculation();
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-line-chart"></i> Rapports d'achat de voiture </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Rapport d'achat de voiture</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <form id="frmcarstock" method="post" enctype="multipart/form-data">
      <div class="box box-success" id="box_model">
        <div class="box-body">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-search"></i> Trouver une voiture</h3>
          </div>
          <div class="form-group  col-md-12" style="color:red; font-weight:bold;">** Sélectionnez Date d'achat ou mois et année ensemble ou mois ou année.</div>
          <div class="form-group col-md-12">
            <label for="txtBuyDate">Date d'achat :</label>
            <input type="text" name="txtBuyDate" value="<?php echo !empty($filter['date']) ? $filter['date'] : ''; ?>" id="txtBuyDate" class="form-control datepicker" />
          </div>
          <div class="form-group col-md-6">
            <label for="ddlMonth">Select Month :</label>
            <select class="form-control" name="ddlMonth" id="ddlMonth">
              <option <?php echo $filter['month'] == '' ? 'selected' : ''; ?> value=''>--Select Month--</option>
              <option <?php echo $filter['month'] == '1' ? 'selected' : ''; ?> value='1'>January</option>
              <option <?php echo $filter['month'] == '2' ? 'selected' : ''; ?> value='2'>February</option>
              <option <?php echo $filter['month'] == '3' ? 'selected' : ''; ?> value='3'>March</option>
              <option <?php echo $filter['month'] == '4' ? 'selected' : ''; ?> value='4'>April</option>
              <option <?php echo $filter['month'] == '5' ? 'selected' : ''; ?> value='5'>May</option>
              <option <?php echo $filter['month'] == '6' ? 'selected' : ''; ?> value='6'>June</option>
              <option <?php echo $filter['month'] == '7' ? 'selected' : ''; ?> value='7'>July</option>
              <option <?php echo $filter['month'] == '8' ? 'selected' : ''; ?> value='8'>August</option>
              <option <?php echo $filter['month'] == '9' ? 'selected' : ''; ?> value='9'>September</option>
              <option <?php echo $filter['month'] == '10' ? 'selected' : ''; ?> value='10'>October</option>
              <option <?php echo $filter['month'] == '11' ? 'selected' : ''; ?> value='11'>November</option>
              <option <?php echo $filter['month'] == '12' ? 'selected' : ''; ?> value='12'>December</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="ddlYear">Sélectionnez Année :</label>
            <select class="form-control" name="ddlYear" id="ddlYear">
              <option <?php echo $filter['year'] == '' ? 'selected' : ''; ?> value=''>--Sélectionnez Année--</option>
              <?php for($i=2000;$i<=date('Y');$i++){
			  	if($filter['year'] == $i) {
					echo '<option selected value="'.$i.'">'.$i.'</option>';
				} else {
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			    }?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="ddlCarStatus">Statut de la voiture :</label>
            <select class="form-control" name="ddlCarStatus" id="ddlCarStatus">
              <option <?php echo $filter['status'] == '1' ? 'selected' : ''; ?> value='1'>Vendu</option>
              <option <?php echo $filter['status'] == '0' ? 'selected' : ''; ?> value='0'>Disponible</option>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="ddlCondition">Car Condition :</label>
            <select class="form-control" name="ddlCondition" id="ddlCondition">
              <option <?php echo $filter['condition'] == 'new' ? 'selected' : ''; ?> value='new'>Nouveau</option>
              <option <?php echo $filter['condition'] == 'old' ? 'selected' : ''; ?> value='old'>Ancien</option>
			  <option <?php echo $filter['condition'] == 'both' ? 'selected' : ''; ?> value='both'>tous les deux</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="ddlPayment">Payment :</label>
            <select class="form-control" name="ddlPayment" id="ddlPayment">
              <option <?php echo $filter['payment'] == '' ? 'selected' : ''; ?> value=''>--select--</option>
              <option <?php echo $filter['payment'] == 'due' ? 'selected' : ''; ?> value='due'>Dû</option>
              <option <?php echo $filter['payment'] == 'paid' ? 'selected' : ''; ?> value='paid'>Payé</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <button type="submit" class="btn btn-success btn-large btn-block"><b><i class="fa fa-filter"></i> RECHERCHE</b></button>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </form>
  </div>
  <?php if(!empty($results)) { ?>
  <?php
  $buy = 0.00;
  $due = 0.00;
  $paid = 0.00;
  foreach($results as $row) {
  	$buy += (float)$row['buy_price'];
	$due += (float)$row['buy_price'] - (float)$row['buy_given_amount'];
	$paid += (float)$row['buy_given_amount'];
  }
  ?>
  <div class="col-xs-12 state-overview">
    <div class="box box-success">
      <div class="box-body">
        <div class="col-lg-4 col-sm-4">
          <section class="panel">
            <div class="symbol terques"> <i class="fa fa-line-chart" data-original-title="" title=""></i> </div>
            <div class="value">
              <h1 class=" count2"><?php echo $currency.number_format($buy, 2);?></h1>
              <p>Total Price</p>
            </div>
          </section>
        </div>
        <div class="col-lg-4 col-sm-4">
          <section class="panel">
            <div class="symbol red"> <i class="fa fa-bar-chart-o" data-original-title="" title=""></i> </div>
            <div class="value">
              <h1 class=" count2"><?php echo $currency.number_format($due, 2);?></h1>
              <p>Montant dû</p>
            </div>
          </section>
        </div>
        <div class="col-lg-4 col-sm-4">
          <section class="panel">
            <div class="symbol purple"> <i class="fa fa-area-chart" data-original-title="" title=""></i> </div>
            <div class="value">
              <h1 class=" count2"><?php echo $currency.number_format($paid, 2);?></h1>
              <p>Montant payé</p>
            </div>
          </section>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xs-12">
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title">Liste d'achat de voiture</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th>Image</th>
              <th>Nom de la voiture</th>
              <th>Condition</th>
              <th>Statut de la voiture</th>
              <th>Paiement</th>
              <th>Date d'achat</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php
				foreach($results as $row) {				
					$image = WEB_URL . 'img/no_image.jpg';
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
					}
				?>
            <tr>
              <td><img class="img_size" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
              <td><?php echo $row['car_name']; ?></td>
              <td align="center"><span class="label label-success" style="text-transform:uppercase;"><?php echo $row['car_condition']; ?></span></td>
              <td align="center"><?php if($row['car_status'] == '0'){echo '<span class="label label-success">Available</span>';} else {echo '<span class="label label-danger">Sold</span>';} ?></td>
              <td><span class="label label-danger"><?php echo $currency; ?><?php echo $wmscalc->getResultFromTwoValues($row['buy_price'],$row['buy_given_amount'],'-'); ?></span></td>
              <td><?php echo $wms->mySqlToDatePicker($row['buy_date']); ?></td>
              <td><a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['buycar_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL;?>carstock/buycar.php?id=<?php echo $row['buycar_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['buycar_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                <div id="nurse_view_<?php echo $row['buycar_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header orange_header">
                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                        <h3 class="modal-title">Détails de la voiture</h3>
                      </div>
                      <div class="modal-body model_view" align="center">&nbsp;
                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                        <div class="model_title"><?php echo $row['car_name']; ?></div>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-xs-6">
                            <h3 style="text-decoration:underline;">Informations sur le propriétaire</h3>
                            <b>Nom propriétaire :</b> <?php echo $row['owner_name']; ?><br/>
                            <b>Mobile propriétaire:</b> <?php echo $row['owner_mobile']; ?><br/>
                            <b>Email :</b> <?php echo $row['owner_email']; ?><br/>
                            <b>NID :</b> <?php echo $row['nid']; ?><br/>
                            <b>Nom de la compagnie :</b> <?php echo $row['company_name']; ?><br/>
                            <b>Licence commerciale de l'entreprise :</b> <?php echo $row['ctl']; ?><br/>
                            <b>Address :</b> <?php echo $row['owner_address']; ?><br/>
                          </div>
                          <div class="col-xs-6">
                            <h3 style="text-decoration:underline;">Informations sur la voiture</h3>
                            <b>Nom de la voiture :</b> <?php echo $row['car_name']; ?><br/>
                            <b>Condition :</b> <?php echo $row['car_condition']; ?><br/>
                            <b>Couleur :</b> <?php echo $row['color_name']; ?><br/>
                            <b>No de porte</b> <?php echo $row['door_name']; ?><br/>
                            <b>Marque :</b> <?php echo $row['make_name']; ?><br/>
                            <b>Modèle :</b> <?php echo $row['model_name']; ?><br/>
                            <b>Année :</b> <?php echo $row['year_name']; ?><br/>
                            <b>Numéro d'enregistrement :</b> <?php echo $row['car_reg_no']; ?><br/>
                            <b>Date d'inscription :</b> <?php echo $row['car_reg_date']; ?><br/>
                            <b>Chasis No :</b> <?php echo $row['car_chasis_no']; ?><br/>
                            <b>Nom du moteur :</b> <?php echo $row['car_engine_name']; ?><br/>
                            <b>Kilométrage total de la voiture :</b> <?php echo $row['car_totalmileage']; ?><br/>
                            <b>Siège de voiture :</b> <?php echo $row['car_sit']; ?><br/>
                          </div>
                          <div class="col-xs-12">
                            <h3 style="text-decoration:underline;">Buying Information</h3>
                            <b>Prix d'achat :</b> <?php echo $currency; ?><?php echo $row['buy_price']; ?><br/>
                            <b>Prix de vente :</b> <?php echo $currency; ?><?php echo $row['asking_price']; ?><br/>
                            <b>Prix donné :</b> <?php echo $currency; ?><?php echo $row['buy_given_amount']; ?><br/>
                            <b>Montant dû :</b> <span class="label label-danger"><?php echo $currency; ?><?php echo $wmscalc->getResultFromTwoValues($row['buy_price'],$row['buy_given_amount'],'-'); ?></span><br/>
                            <b>Date d'achat:</b> <?php echo $row['buy_date']; ?><br/>
                            <b>Note :</b> <?php echo $row['buy_note']; ?><br/>
                            <b>Car Status :</b> <span class="label label-success">
                            <?php if($row['car_status'] == '0'){echo 'Available';} else {echo 'Sold';} ?>
                            </span> <br/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <?php } ?>
  <?php if(empty($results) && $token=='1') {?>
  <div class="col-xs-12">
    <div class="box box-success">
      <!-- /.box-header -->
      <div class="box-body empty_record">Aucun Enregistrement Trouvé.</div>
    </div>
  </div>
  <?php } ?>
  <!-- /.col -->
</div>
<!-- /.row -->
<?php include('../footer.php'); ?>
