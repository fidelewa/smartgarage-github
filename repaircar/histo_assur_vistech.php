<?php
include('../header.php');

if (isset($_GET['car_id']) && $_GET['car_id'] != '') {

    // On récupère les infos de
    $row = $wms->getRepairCarInfoByRepairCarId($link, $_GET['car_id']);

    // var_dump($row);

    // die();

    // Traitement de l'assurance
    if (isset($row['add_date_assurance']) && $row['add_date_assurance_fin'] != '') {

        // On récupère les données d'historisation du véhicule courant
        $rows = $wms->getHistoAssurVehi($link, $row['add_date_assurance'], $row['add_date_assurance_fin'], $_GET['car_id']);

        // Si aucun enregistrement ne correspond à notre recherche
        if (empty($rows)) {

            // On insère le nouvel enregistrement dans la table d'historisation des assurances
            $query = "INSERT INTO tbl_histo_assurance (date_debut_assurance, date_fin_assurance, duree_assurance, car_id) 
        VALUES('$row[add_date_assurance]','$row[add_date_assurance_fin]',null,'$_GET[car_id]')";

            // Exécution de la requête
            $result_histo_assurance = mysql_query($query, $link);

            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
            // if (!$result_histo_assurance) {
            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
            //     $message .= 'Whole query: ' . $query;
            //     die($message);
            // }
        }
    }

    // Traitement de la visite technique
    if (isset($row['add_date_visitetech'])) {

        // On récupère les données d'historisation du véhicule courant
        $rows = $wms->getHistoVistechVehi($link, $row['add_date_visitetech'], $_GET['car_id']);

        // Si aucun enregistrement ne correspond à notre recherche
        if (empty($rows)) {

            // On insère le nouvel enregistrement dans la table d'historisation des assurances
            $query = "INSERT INTO tbl_histo_visite_technique (date_prochaine_visitetech, duree_visitetech, car_id) 
        VALUES('$row[add_date_visitetech]',null, '$_GET[car_id]')";

            // Exécution de la requête
            $result_histo_visetech = mysql_query($query, $link);

            // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
            // if (!$result_histo_visetech) {
            //     $message  = 'Invalid query: ' . mysql_error() . "\n";
            //     $message .= 'Whole query: ' . $query;
            //     die($message);
            // }
        }
    }
}

?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> Historique des assurances et des visites techniques</h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li class="active">Car Setting</li>
        <li class="active">Make/Model/Year</li> -->
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div align="right" style="margin-bottom:1%;"> 
                <a class="btn btn-success" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/histo_assur_vistech.php?car_id=<?php echo $_GET['car_id']; ?>" data-original-title="Re-charger la page"><i class="fa fa-refresh"></i></a> 
                <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>repaircar/carlist.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
            </div>
            <div class="box box-success">
                <div class="box-body">
                    <div class="box-header">
                        <h3 class="box-title">Historique des assurances du véhicule</h3>
                    </div>
                    <br>
                    <div>
                        <table class="table sakotable table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <!-- <th>#</th> -->
                                    <th>Date de début de l'assurance</th>
                                    <th>Date de fin de l'assurance</th>
                                    <!-- <th>Délai de validité de l'assurance</th> -->
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                $result = $wms->getHistoAssurListByCarId($link, $_GET['car_id']);

                                foreach ($result as $ligne) { ?>
                                    <tr>
                                        <!-- <td><?php echo $ligne['assurance_id']; ?></td> -->
                                        <td><?php echo $ligne['date_debut_assurance']; ?></td>
                                        <td><?php echo $ligne['date_fin_assurance']; ?></td>
                                        <!-- <td><?php echo $ligne['duree_assurance']; ?></td> -->
                                        <!-- <td>
                                                <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/prestationsetting.php?psid=<?php echo $row['presta_serv_id']; ?>" data-original-title="Modifier la prestation de services"><i class="fa fa-edit"></i></a>
                                                <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/prestationsetting.php?psdelid=<?php echo $row['presta_serv_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                            </td> -->
                                    </tr>
                                <?php }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <div class="box box-success" id="box_model">
                <form method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="box-header">
                            <h3 class="box-title">Historique des visites techniques du véhicule</h3>
                        </div>
                        <br>
                        <div>
                            <table class="table table-bordered table-striped dt-responsive">
                                <thead>
                                    <tr>
                                        <!-- <th>#</th> -->
                                        <th>Date de la prochaine visite technique</th>
                                        <!-- <th>Date de fin de la visite technique</th> -->
                                        <!-- <th>Délai de validité de la visite technique</th> -->
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $result = $wms->getHistoVisetechListByCarId($link, $_GET['car_id']);
                                    foreach ($result as $ligne) { ?>
                                        <tr>
                                            <!-- <td><?php echo $ligne['visitetech_id']; ?></td> -->
                                            <td><?php echo $ligne['date_prochaine_visitetech']; ?></td>
                                            <!-- <td><?php echo $ligne['date_fin_visitetech']; ?></td> -->
                                            <!-- <td><?php echo $ligne['duree_visitetech']; ?></td> -->
                                            <!-- <td>
                                                    <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>setting/prestationsetting.php?ppsid=<?php echo $row['prix_presta_serv_id']; ?>#box_model" data-original-title="Modifier le prix de la prestation"><i class="fa fa-edit"></i></a>
                                                    <a class="btn btn-danger" data-toggle="tooltip" onClick=deleteMe("<?php echo WEB_URL; ?>setting/prestationsetting.php?ppsdelid=<?php echo $row['prix_presta_serv_id']; ?>"); href="javascript:;" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                                </td> -->
                                        </tr>
                                    <?php }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
    </div>
    <!-- /.row -->
    <?php include('../footer.php'); ?>