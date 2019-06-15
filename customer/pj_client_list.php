<?php include('../header.php') ?>
<?php
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteRepairCar($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Deleted Voiture de réparation information successfully";
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "Added Voiture de réparation Information Successfully";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "Updated Voiture de réparation Information Successfully";
}

$row = $wms->getAllPjByCustomer($link, $_GET['cid']);

// var_dump($row);

// die();

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Liste des pièces jointes appartenant à un client</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des pièces jointes appartenant à un client</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Deleted!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php" data-original-title="Add Voiture de réparation"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-list"></i>
                        Liste des pièces jointes appartenant au client
                        <?php
                        if (isset($row) && !empty($row)) {
                            echo $row['c_name'];
                        }
                        ?></h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <?php

                                // Déclaration d'un array (liste) de pièces jointes vide
                                $pj_list = array();

                                if (isset($row['pj1_url']) && !empty($row['pj1_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj1_url'];
                                }
                                if (isset($row['pj2_url']) && !empty($row['pj2_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj2_url'];
                                }
                                if (isset($row['pj3_url']) && !empty($row['pj3_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj3_url'];
                                }
                                if (isset($row['pj4_url']) && !empty($row['pj4_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj4_url'];
                                }
                                if (isset($row['pj5_url']) && !empty($row['pj5_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj5_url'];
                                }
                                if (isset($row['pj6_url']) && !empty($row['pj6_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj6_url'];
                                }
                                if (isset($row['pj7_url']) && !empty($row['pj7_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj7_url'];
                                }
                                if (isset($row['pj8_url']) && !empty($row['pj8_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj8_url'];
                                }
                                if (isset($row['pj9_url']) && !empty($row['pj9_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj9_url'];
                                }
                                if (isset($row['pj10_url']) && !empty($row['pj10_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj10_url'];
                                }
                                if (isset($row['pj11_url']) && !empty($row['pj11_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj11_url'];
                                }
                                if (isset($row['pj12_url']) && !empty($row['pj12_url'])) {
                                    // echo "<th>Pièce jointe #1</th>";
                                    $pj_list[] = $row['pj12_url'];
                                }
                                ?>
                                <th>Image</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Maison Tel</th>
                                <th>Travail Tel</th>
                                <th>Mobile Tel</th>
                                <th>Liste des pièces jointes</th>
                                <!-- <th>Attribué à</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // $row = $wms->getAllRepairCarList($link);
                            //   $row = $wms->getAllRepairCarListByCustomer($link, $_GET['cid']);

                            $image = WEB_URL . 'img/no_image.jpg';
                            if (file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != '') {
                                $image = WEB_URL . 'img/upload/' . $row['image'];
                            }

                            ?>
                            <tr>

                                <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                                <td><?php echo $row['c_name']; ?></td>
                                <td><?php echo $row['c_email']; ?></td>
                                <td><?php echo $row['c_home_tel']; ?></td>
                                <td><?php echo $row['c_work_tel']; ?></td>
                                <td><?php echo $row['c_mobile']; ?></td>
                                <td><?php

                                    if (!empty($pj_list)) {

                                        foreach ($pj_list as $pj_name) {

                                            // Adresse de la pièce jointe sur le serveur
                                            // $pj_url = './img/upload/docs/' . $pj_name;
                                            if (file_exists(ROOT_PATH . '/img/upload/docs/' . $pj_name) && $pj_name != '') { ?>
                                                <p>
                                                    <a href="<?php echo WEB_URL ?>img/upload/docs/<?php echo $pj_name ?>"><?php echo $pj_name ?></a>
                                                </p>
                                            <?php }
                                    }
                                } else {
                                    echo "<p>Ce client n'a aucune pièces jointes</p>";
                                }
                                ?>
                                </td>
                                <td>
                                    <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['car_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a> <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/addcar.php?id=<?php echo $row['car_id']; ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteCustomer(<?php echo $row['car_id']; ?>);" href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a> -->
                                    <!-- <div id="nurse_view_<?php echo $row['car_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> -->
                                    <!-- <div class="modal-dialog"> -->
                                    <!-- <div class="modal-content">
                                                      <div class="modal-header orange_header">
                                                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                                                        <h3 class="modal-title">Repair Détails de la voiture</h3>
                                                      </div>
                                                      <div class="modal-body model_view" align="center">&nbsp;
                                                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                                                        <div class="model_title"><?php echo $row['car_name']; ?></div>
                                                        <div style="color:#fff;font-size:15px;font-weight:bold;">Facture No: <?php echo $row['repair_car_id']; ?></div>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h3 style="text-decoration:underline;">Détails de la voiture Information</h3>
                                                        <div class="row">
                                                          <div class="col-xs-12">
                                                            <b>Nom de la voiture :</b> <?php echo $row['car_name']; ?><br />
                                                            <b>Réparation automobile ID :</b> <?php echo $row['repair_car_id']; ?><br />
                                                            <b>Marque voiture :</b> <?php echo $row['make_name']; ?><br />
                                                            <b>Modèle de voiture:</b> <?php echo $row['model_name']; ?><br />
                                                            <b>Année :</b> <?php echo $row['year_name']; ?><br />
                                                            <b>Chasis No :</b> <?php echo $row['chasis_no']; ?><br />
                                                            <b>Enregistrement No :</b> <?php echo $row['car_reg_no']; ?><br />
                                                            <b>VIN No :</b> <?php echo $row['VIN']; ?><br />
                                                            <b>Note :</b> <?php echo $row['note']; ?><br />
                                                            <b> Date d'Ajout:</b> <?php echo date('d/m/Y h:m:s', strtotime($row['added_date'])); ?><br />
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div> -->
                                    <!-- /.modal-content -->
                                    <!-- <div class="modal-content">
                                                      <div class="modal-header orange_header">
                                                        <h3 class="modal-title">Détails du client</h3>
                                                      </div>
                                                      <div class="modal-body model_view" align="center">&nbsp;
                                                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image_customer;  ?>" /></div>
                                                        <div class="model_title"><?php echo $row['c_name']; ?></div>
                                                      </div>
                                                      <div class="modal-body">
                                                        <h3 style="text-decoration:underline;">Détails du client Information</h3>
                                                        <div class="row">
                                                          <div class="col-xs-12">
                                                            <b>Nom du client :</b> <?php echo $row['c_name']; ?><br />
                                                            <b> Email Client :</b> <?php echo $row['c_email']; ?><br />
                                                            <b> Telephone Client :</b> <?php echo $row['c_mobile']; ?><br />

                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div> -->
                                    <!-- /.modal-content -->
                                    <!-- </div> -->
                                    <!-- </div> -->
                                </td>
                            </tr>
                            <?php
                            mysql_close($link); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    <script type="text/javascript">
        function deleteCustomer(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cette voiture ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>repaircar/carlist.php?id=' + Id;
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $("#me").hide(300);
                $("#you").hide(300);
            }, 3000);
        });
    </script>
    <?php include('../footer.php'); ?>