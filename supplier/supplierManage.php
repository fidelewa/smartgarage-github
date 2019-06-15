<?php
include('../header.php'); ?>
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