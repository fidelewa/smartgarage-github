<?php 
include_once('../header.php');
include_once('../helper/calculation.php');

/*variables*/
$delinfo = 'none';
$addinfo = 'none';
$savebtn='Enregistrer information';
$msg = '';
$del_msg = '';

$buyer_name='';
$mobile='';
$buyer_email='';
$buyer_nid='';
$company_name='';
$trade_licence='';
$present_address='';
$permanent_address='';
$selling_price='';
$advance_amount='';
$due_amount='0.00';
$selling_date='';
$sell_note='';
$carsell_id=0;
$service_warranty = 'N/A';

$carid=0;
$hdnid = 0;

$wmscalc = new wms_calculation();
if(isset($_GET['carid'])){
	$carid=$_GET['carid'];
}

$selling_date=date("d/m/Y");
$invoice_id = substr(number_format(time() * rand(),0,'',''),0,6);

/************************ Insert Query ***************************/
if(isset($_POST['txtBuyerName'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){	
		$wms->saveCarSaleInformatiom($link, $_POST);
		$url = WEB_URL . 'invoice/invoice_car_sell.php?invoice_id='.$_POST['invoice_id'];
		header("Location: $url");
	} else{
		$wms->updateCarSaleInformatiom($link, $_POST);
		$url = WEB_URL . 'carstock/sellcarlist.php?m=up';
		header("Location: $url");
	}
}

if(isset($_GET['sellid']) && $_GET['sellid'] != ''){
	$row = $wms->carSoldDetailsBasedOnSellId($link, $_GET['sellid']);
	if(!empty($row)) {
		$buyer_name=$row['buyer_name'];
		$mobile=$row['buyer_mobile'];
		$buyer_email=$row['buyer_email'];
		$buyer_nid=$row['sellernid'];
		$company_name=$row['company_name'];
		$trade_licence=$row['ctl'];
		$present_address=$row['present_address'];
		$permanent_address=$row['permanent_address'];
		$selling_price=$row['selling_price'];
		$advance_amount=$row['advance_amount'];
		$selling_date=$this->mySqlToDatePicker($row['selling_date']);
		$sell_note=$row['sell_note'];
		$carsell_id=$row['carsell_id'];
		$invoice_id = $row['invoice_id'];
		$due_amount=$row['due_amount'];
		$service_warranty = $row['service_warranty'];
		$hdnid = $_GET['sellid'];
	}
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><i class="fa fa-car"></i> Vendre une voiture neuve / ancienne </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Car Find</li>
    <li class="active">Sell Car</li>
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
      <?php echo $del_msg; ?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> Success!</h4>
      <?php echo $msg; ?> </div>
    <form id="frmcarstock" onsubmit="return validateMe();" method="post" enctype="multipart/form-data">
      <div class="box box-success" id="box_model">
        <div class="box-body">
          <div class="col-md-12" style="padding-top:10px;">
            <div class="col-md-12">
              <input type="text" placeholder="Date de vente" style="color:red;font-weight:bold;text-align:center;font-size:20px;border:none;border-bottom:solid 1px #ccc;" name="txtSellDate" id="txtSellDate" value="<?php echo $selling_date; ?>" class="form-control datepicker"/>
            </div>
            <div class="text-center">
              <div style="font-size:25px;font-weight:bold;color:green;text-decoration:underline;">INVOICE: <?php echo $invoice_id; ?></div>
            </div>
            <div class="pull-right">
              <?php if(isset($_GET['sellid']) && $_GET['sellid'] != ''){ ?>
			  <button type="submit" name="btnSaveInvoive" class="btn btn-info btnsp"><i class="fa fa-save fa-2x"></i><br>
              Update Information</button>
			  <?php } else { ?>
			  <button type="submit" name="btnUpdateInvoive" class="btn btn-info btnsp"><i class="fa fa-print fa-2x"></i><br>
              Sell &amp; Generate Invoice</button>
			  <?php } ?>
                 <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>carstock/sellcarlist.php" data-original-title="Back"><i class="fa fa-reply fa-2x"></i><br/>
              Back To List</a> </div>
          </div>
        </div>
      </div>
      <div class="box box-success" id="box_model">
        <div class="box-body">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-car"></i> Car Stock Details</h3>
          </div>
          <?php
		    $sql = "SELECT *,cc.color_name,cd.door_name,m.make_name,mo.model_name,y.year_name FROM tbl_buycar bc left join tbl_carcolor cc on cc.color_id = bc.car_color left join tbl_cardoor cd on cd.door_id = bc.car_door left join tbl_make m on m.make_id = bc.make_id left join tbl_model mo on mo.model_id = bc.model_id left join tbl_year y on y.year_id = bc.year_id where bc.buycar_id = '".$_GET['carid']."'";
		    	$result = mysql_query($sql,$link);
				if($row = mysql_fetch_array($result)){ 
					$image = WEB_URL . 'img/no_image.jpg';
					if(file_exists(ROOT_PATH . '/img/upload/' . $row['car_image']) && $row['car_image'] != ''){
						$image = WEB_URL . 'img/upload/' . $row['car_image']; //car image
					}
					?>
          <div style="width:98%;height:auto;border:solid 1px #ccc;padding:10px;margin:10px;">
            <div class="col-md-4 text-center"><img class="img-responsive" style="width:300px;height:300px;" src="<?php echo $image; ?>" /></div>
            <div class="col-md-5 text-left">
              <div>
                <h4 style="font-weight:bold;"><?php echo $row['car_name']; ?></h4>
              </div>
              <div><b>Marque:</b><?php echo $row['make_name']; ?>; <b>Modèle:</b> <?php echo $row['model_name']; ?>; <b>Année:</b> <?php echo $row['year_name']; ?></div>
              <div><b>Color:</b> <span style="font-size:12px;" class="label label-danger"><?php echo $row['color_name']; ?></span></div>
              <div><b>Door:</b> <?php echo $row['door_name']; ?></div>
              <div><b>Condition:</b> <span style="font-size:12px;" class="label label-warning"><?php echo $row['car_condition']; ?></span></div>
              <div><b>Numéro d'enregistrement:</b> <?php echo $row['car_reg_no']; ?></div>
              <div><b>Date d'inscription:</b> <?php echo $row['car_reg_date']; ?></div>
              <div><b>Car Status:</b> <span style="font-size:12px;" class="label label-success">
                <?php if($row['car_status'] == '0'){echo 'Available';} else {echo 'Sold';} ?>
                </span></div>
            </div>
            <div class="col-md-3 text-left">
              <div>
                <h4 style="font-weight:bold;">&nbsp;</h4>
              </div>
              <div><b>Chasis No:</b> <?php echo $row['car_chasis_no']; ?></div>
              <div><b>Engine & CC:</b> <?php echo $row['car_engine_name']; ?></div>
              <div><b>Total Mileage:</b> <span class="label label-primary"><?php echo $row['car_totalmileage']; ?></span></div>
              <div><b>Buy Date:</b> <?php echo $row['buy_date']; ?></div>
              <br/>
              <br/>
              <div class="label label-danger" style="font-size:15px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Asking Price: <?php echo $currency; ?><?php echo number_format($row['asking_price'],2); ?></div>
              <br/>
              <br/>
              <div class="label label-success" style="font-size:15px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Prix d'achat: <?php echo $currency; ?><?php echo number_format($row['buy_price'],2); ?></div>
              <br/>
              <br/>
              <div class="label label-warning" style="font-size:15px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Montant payé: <?php echo $currency; ?><?php echo number_format($row['buy_given_amount'],2); ?></div>
              <br/>
              <br/>
              <div class="label label-primary" style="font-size:15px;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Due Price: <?php echo $currency; ?><?php echo number_format($wmscalc->getResultFromTwoValues($row['buy_price'],$row['buy_given_amount'],'-'),2); ?></div>
            </div>
            <div style="clear:both;"></div>
          </div>
          <?php } ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-success">
        <div class="box-body">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-user"></i> Informations sur l'acheteur</h3>
          </div>
          <div class="form-group col-md-4">
            <label for="txtBuyerName"><span style="color:red;">*</span> Nom de l'acheteur :</label>
            <input type="text" placeholder="Owner Name" value="<?php echo $buyer_name; ?>" name="txtBuyerName" id="txtBuyerName" class="form-control"/>
          </div>
          <div class="form-group col-md-4">
            <label for="txtMobile"><span style="color:red;">*</span> Mobile :</label>
            <input type="text" placeholder="Owner Mobile" value="<?php echo $mobile; ?>" name="txtMobile" id="txtMobile" class="form-control"/>
          </div>
          <div class="form-group col-md-4">
            <label for="txtEmail"><span style="color:red;">*</span> Email :</label>
            <input type="text" placeholder="Owner Email" value="<?php echo $buyer_email; ?>" name="txtEmail" id="txtEmail" class="form-control"/>
          </div>
          <div class="form-group col-md-12">
            <label for="txtNid"> National ID Card :</label>
            <input type="text" placeholder="NID Number" value="<?php echo $buyer_nid; ?>" name="txtNid" id="txtNid" class="form-control"/>
          </div>
          <div class="form-group col-md-6">
            <label for="txtCompanyname"> Nom de la compagnie:</label>
            <input type="text" placeholder="Nom de la compagnie" value="<?php echo $company_name; ?>" name="txtCompanyname" id="txtCompanyname" class="form-control"/>
          </div>
          <div class="form-group col-md-6">
            <label for="txtCTL"> Licence commerciale de l'entreprise:</label>
            <input type="text" placeholder="Trade License" value="<?php echo $trade_licence; ?>" name="txtCTL" id="txtCTL" class="form-control"/>
          </div>
          <div class="form-group col-md-6">
            <label for="txtprestAddress"><span style="color:red;">*</span> Adresse actuelle :</label>
            <textarea type="text" placeholder="Owner Address" name="txtprestAddress" id="txtprestAddress" class="form-control"><?php echo $present_address; ?></textarea>
          </div>
          <div class="form-group col-md-6">
            <label for="txtpermanentAddress">Adresse permanente :</label>
            <textarea type="text" placeholder="Owner Address" name="txtpermanentAddress" id="txtpermanentAddress" class="form-control"><?php echo $permanent_address; ?></textarea>
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
      <div class="box box-success" id="box_year">
        <div class="box-body">
          <div class="box-header">
            <h3 class="box-title"><i class="fa fa-info"></i> Informations de vente</h3>
          </div>
          <div class="form-group col-md-4">
            <label for="txtBuyPrice"><span style="color:red;">*</span> Selling Price :</label>
            <div class="input-group"> <span class="input-group-addon"><?php echo $currency; ?></span>
              <input type="text" placeholder="Buying Prie" value="<?php echo $selling_price; ?>" name="txtSellPrice" id="txtBuyPrice" class="form-control allownumberonly"/>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="txtGivamount"><span style="color:red;">*</span> Advance Amount :</label>
            <div class="input-group"> <span class="input-group-addon"><?php echo $currency; ?></span>
              <input type="text" placeholder="Given Amount" value="<?php echo $advance_amount; ?>" name="txtAdvanceamount" id="txtGivamount" class="form-control allownumberonly"/>
            </div>
          </div>
          <div class="form-group col-md-4">
            <label for="txtDue">Montant dû:</label>
            <div class="input-group"> <span class="input-group-addon"><?php echo $currency; ?></span>
              <input type="text" disabled="disabled" placeholder="Due" value="<?php echo $wmscalc->getResultFromTwoValues($selling_price,$advance_amount,'-'); ?>" name="txtDue" id="txtDue" class="form-control" required/>
            </div>
          </div>
          <div class="form-group col-md-12">
            <label for="ddlServiceWarranty">Service Warranty:</label>
            <select name="ddlServiceWarranty" class="form-control" id="ddlServiceWarranty">
              <option <?php if($service_warranty == 'N/A'){echo 'selected';}?> value="N/A">N/A</option>
              <option <?php if($service_warranty == '1 Month'){echo 'selected';}?> value="1 Month">1 Month</option>
              <option <?php if($service_warranty == '2 Months'){echo 'selected';}?> value="2 Months">2 Months</option>
              <option <?php if($service_warranty == '3 Months'){echo 'selected';}?> value="3 Months">3 Months</option>
              <option <?php if($service_warranty == '4 Months'){echo 'selected';}?> value="4 Months">4 Months</option>
              <option <?php if($service_warranty == '5 Months'){echo 'selected';}?> value="5 Months">5 Months</option>
              <option <?php if($service_warranty == '6 Months'){echo 'selected';}?> value="6 Months">6 Months</option>
              <option <?php if($service_warranty == '7 Months'){echo 'selected';}?> value="7 Months">7 Months</option>
              <option <?php if($service_warranty == '8 Months'){echo 'selected';}?> value="8 Months">8 Months</option>
              <option <?php if($service_warranty == '9 Months'){echo 'selected';}?> value="9 Months">9 Months</option>
              <option <?php if($service_warranty == '10 Months'){echo 'selected';}?> value="10 Months">10 Months</option>
              <option <?php if($service_warranty == '11 Months'){echo 'selected';}?> value="11 Months">11 Months</option>
              <option <?php if($service_warranty == '12 Months'){echo 'selected';}?> value="12 Months">12 Months</option>
              <option <?php if($service_warranty == '1 Year'){echo 'selected';}?> value="1 Year">1 Year</option>
              <option <?php if($service_warranty == '2 Years'){echo 'selected';}?> value="2 Years">2 Years</option>
              <option <?php if($service_warranty == '3 Years'){echo 'selected';}?> value="3 Years">3 Years</option>
              <option <?php if($service_warranty == '4 Years'){echo 'selected';}?> value="4 Years">4 Years</option>
              <option <?php if($service_warranty == '5 Years'){echo 'selected';}?> value="5 Years">5 Years</option>
              <option <?php if($service_warranty == '6 Years'){echo 'selected';}?> value="6 Years">6 Years</option>
              <option <?php if($service_warranty == '7 Years'){echo 'selected';}?> value="7 Years">7 Years</option>
              <option <?php if($service_warranty == '8 Years'){echo 'selected';}?> value="8 Years">8 Years</option>
              <option <?php if($service_warranty == '9 Years'){echo 'selected';}?> value="9 Years">9 Years</option>
              <option <?php if($service_warranty == '10 Years'){echo 'selected';}?> value="10 Years">10 Years</option>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="txtSellnote">Note :</label>
            <textarea name="txtSellnote" placeholder="Note" id="txtSellnote" class="form-control"><?php echo $sell_note;?></textarea>
          </div>
          <input type="hidden" value="<?php echo $row['car_name']; ?>" name="_car_name"/>
          <input type="hidden" value="<?php echo $row['make_name']; ?>" name="_make"/>
          <input type="hidden" value="<?php echo $row['model_name']; ?>" name="_model"/>
          <input type="hidden" value="<?php echo $row['year_name']; ?>" name="_year"/>
          <input type="hidden" value="<?php echo $row['color_name']; ?>" name="_color"/>
          <input type="hidden" value="<?php echo $row['door_name']; ?>" name="_door"/>
          <input type="hidden" value="<?php echo $row['car_condition']; ?>" name="_condition"/>
          <input type="hidden" value="<?php echo $row['car_totalmileage']; ?>" name="_total_mileage"/>
          <input type="hidden" value="<?php echo $row['car_chasis_no']; ?>" name="_chasis_no"/>
          <input type="hidden" value="<?php echo $row['car_engine_name']; ?>" name="_engine_name"/>
          <input type="hidden" value="<?php echo $due_amount; ?>" name="due_amount" id="hdn_due_amount"/>
          <input type="hidden" value="<?php echo $hdnid; ?>" id="sell_car_id" name="hdn"/>
          <input type="hidden" value="<?php echo $carid; ?>" name="carid"/>
          <input type="hidden" value="<?php echo $invoice_id; ?>" name="invoice_id"/>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </form>
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#txtBuyerName").val() == ''){
		alert("Nom de l'acheteur est Obligatoire !!!");
		$("#txtBuyerName").focus();
		return false;
	}
	else if($("#txtMobile").val() == ''){
		alert("Mobile est Obligatoire !!!");
		$("#txtMobile").focus();
		return false;
	}
	else if($("#txtEmail").val() == ''){
		alert("Email est Obligatoire !!!");
		$("#txtEmail").focus();
		return false;
	}
	else if($("#txtprestAddress").val() == ''){
		alert("Adresse actuelle est Obligatoire !!!");
		$("#txtprestAddress").focus();
		return false;
	}
	else if($("#txtBuyPrice").val() == ''){
		alert("Prix de vente est Obligatoire !!!");
		$("#txtBuyPrice").focus();
		return false;
	}
	else if($("#txtGivamount").val() == ''){
		alert("Advance amount est Obligatoire !!!");
		$("#txtGivamount").focus();
		return false;
	}	
	else{
		if($("#sell_car_id").val() == '0') {
			if(confirm('Are you sure you want to save sell information and generate sell invoice ?')) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}
</script>
<?php include('../footer.php'); ?>
