<?php
include_once('../header.php');
include_once('../helper/common.php');
$facture_client_list = array();
$token = 0;
$filter = array(
    'dateDebut'        => '',
    'dateFin'        => '',
    // 'status'    => '',
    // 'payment'    => ''
);

if (!empty($_POST)) {
    $filter = array(
        'dateDebut'        => '',
        'dateFin'        => '',
        // 'status'    => $_POST['ddlRepairStatus'],
        // 'payment'    => $_POST['ddlPayment']
    );
    if (!empty($_POST['txtDateDebut'])) {
        $filter['dateDebut'] = $_POST['txtDateDebut'];
    }
    if (!empty($_POST['txtDateFin'])) {
        $filter['dateFin'] = $_POST['txtDateFin'];
    }

    // var_dump($_POST);
    // die();

    $facture_client_list = $wms->getFactureClientForReport($link, $filter);

    $facture_simu_list = $wms->getFactureSimuForReport($link, $filter);

    $facture_four_list = $wms->getFactureFourForReport($link, $filter);

    // var_dump($facture_simu_list);
    // die();

    $token = 1;
}
?>
<!-- Content Header (Page header) -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rapport de synthèse de l'activité</title>
    <style>
        /* Echaffaudage #2 */
        /* [class*="col-"] {
            border: 1px dotted rgb(0, 0, 0);
            border-radius: 1px;
        } */
    </style>
</head>

<body>
    <section class="content-header">
        <h1><i class="fa fa-line-chart"></i> Rapport de synthèse de l'activité </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Rapport de synthèse de l'activité</li>
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
                            <!-- <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-search"></i> Trouver une voiture de réparation</h3>
                            </div> -->
                            <fieldset>
                                <legend>Période</legend>
                                <div class="form-group col-md-6">
                                    <label for="txtDateDebut">Date de début:</label>
                                    <input type="text" name="txtDateDebut" value="<?php echo !empty($filter['date']) ? $filter['date'] : ''; ?>" id="txtDateDebut" class="form-control datepicker" />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="txtDateFin">Date de fin:</label>
                                    <input type="text" name="txtDateFin" value="<?php echo !empty($filter['date']) ? $filter['date'] : ''; ?>" id="txtDateFin" class="form-control datepicker" />
                                </div>
                            </fieldset>
                            <!-- <div class="form-group  col-md-12" style="color:red; font-weight:bold;">** Sélectionnez la date de livraison ou le mois et Année ensemble ou le mois ou Année</div> -->

                            <!-- <div class="form-group col-md-12">
                                <label for="ddlPayment">Payment :</label>
                                <select class="form-control" name="ddlPayment" id="ddlPayment">
                                    <option <?php echo $filter['payment'] == '' ? 'selected' : ''; ?> value=''>--select--</option>
                                    <option <?php echo $filter['payment'] == 'due' ? 'selected' : ''; ?> value='due'>Dû</option>
                                    <option <?php echo $filter['payment'] == 'paid' ? 'selected' : ''; ?> value='paid'>Payé</option>
                                </select>
                            </div> -->
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-success btn-large btn-block"><b><i class="fa fa-filter"></i> RECHERCHE</b></button>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </form>
            </div>
            <!-- Si la liste des factures clients et/ou des factures simuation n'est pas vide -->
            <?php if (!empty($facture_client_list) || !empty($facture_simu_list) || !empty($facture_four_list)) { ?>
                <div class="col-xs-12 state-overview">
                    <div class="box box-success">
                        <div class="box-body">
                            <p style="font-size:13pt;">Rapport de synthèse de l'activité du <?php echo $filter['dateDebut']; ?> au <?php echo $filter['dateFin']; ?></p>
                            <h3>Facture des clients</h3>
                            <?php if (!empty($facture_client_list)) {
                                $total_pending = 0.00;
                                $total_paid = 0.00;
                                foreach ($facture_client_list as $rdata) {
                                    $total_pending += (float)$rdata['montant_du_piece_rechange_facture'];
                                    $total_paid += (float)$rdata['montant_paye_piece_rechange_facture'];
                                }

                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend>Facture des clients du garage</legend>
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div>
                                                        <h1 class=" count2"><?php echo number_format($total_pending, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des factures clients dues</p>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div>
                                                        <h1 class=" count2"><?php echo number_format($total_paid, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des factures clients payées</p>
                                                    </div>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($facture_simu_list)) {
                                $total_pending = 0.00;
                                $total_paid = 0.00;
                                foreach ($facture_simu_list as $rdata) {
                                    $total_pending += (float)$rdata['montant_du_piece_rechange_facture'];
                                    $total_paid += (float)$rdata['montant_paye_piece_rechange_facture'];
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <fieldset>
                                            <legend>Autres factures</legend>
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div>
                                                        <h1 class=" count2"><?php echo number_format($total_pending, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des autres factures dues</p>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div class="col-md-12">
                                                        <h1 class=" count2"><?php echo number_format($total_paid, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des autres factures payées</p>
                                                    </div>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (!empty($facture_four_list)) {

                                // var_dump($facture_four_list);

                                $total_pending = 0.00;
                                $total_paid = 0.00;
                                foreach ($facture_four_list as $rdata) {
                                    $total_pending += (float)$rdata['credit'];
                                    $total_paid += (float)$rdata['debit'];
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Factures des fournisseurs</h3>
                                        <fieldset>
                                            <!-- <legend>Factures des fournisseurs</legend> -->
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div class="col-md-12">
                                                        <h1 class=" count2"><?php echo number_format($total_pending, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des factures fournisseurs dues</p>
                                                    </div>
                                                </section>
                                            </div>
                                            <div class="col-lg-6 col-sm-6">
                                                <section class="panel">
                                                    <!-- <div class="symbol purple"> <i class="fa fa-usd" data-original-title="" title=""></i> </div> -->
                                                    <div class="col-md-12">
                                                        <h1 class=" count2"><?php echo number_format($total_paid, 2) . ' ' . $currency; ?></h1>
                                                        <p>Montant total des factures fornisseurs payées</p>
                                                    </div>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>

            <?php } ?>

            <?php if (empty($facture_client_list) && $token == '1') { ?>
                <div class="col-xs-12">
                    <div class="box box-success">
                        <!-- /.box-header -->
                        <div class="box-body empty_record">Aucun Enregistrement Trouvé.</div>
                    </div>
                </div>
            <?php } ?>
            <!-- /.col -->
        </div>
</body>

</html>
<!-- /.row -->
<?php include('../footer.php'); ?>