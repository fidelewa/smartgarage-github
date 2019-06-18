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
        <!-- Full Width boxes (Stat box) -->
        <div class="row">
            <div class="col-md-12">
            <!-- <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i>
                </button>
                <h4><i class="icon fa fa-check"></i> Success!</h4>
                <?php echo $msg; ?>
            </div> -->
                <div class="box box-success">
                    <ul class="list-group list-group-flush">

                        <?php
                        $result = $wms->getAllSuppliers($link);
                        foreach ($result as $row) { ?>
                            <a href="<?php echo WEB_URL ?>supplier/supplierManageData.php?supplier_id=<?php echo $row['supplier_id'] ?>"><li class="list-group-item"><?php echo $row['s_name'] ?></li></a>
                        <?php } ?>
                        <ul>
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