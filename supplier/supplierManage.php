<?php
include('../header.php');

if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = "La voiture a été ajoutée à la liste des véhicules réceptionnés";
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = "La voiture receptionnée a été modifiée";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des fournisseurs</title>
</head>

<body>
    <section class="content">
    <h3> <i class="fa fa-list"></i> Liste des fournisseurs gérés</h3>
        <!-- Full Width boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-success">

                    <div class="box-body">
                        <table class="table sakotable table-bordered table-striped dt-responsive">
                            <thead>
                                <tr>
                                    <th>Nom des fournisseurs</th>
                                    <!-- <th>Action</th> -->
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $result = $wms->getAllSuppliers($link);
                                foreach ($result as $row) { ?>

                                    <tr>
                                        <td>
                                            <a href="<?php echo WEB_URL ?>supplier/supplierManageData.php?supplier_id=<?php echo $row['supplier_id'] ?>">
                                                <?php echo $row['s_name'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php }
                                mysql_close($link); ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>
    </section>
</body>

</html>
<?php
include('../footer.php'); ?>