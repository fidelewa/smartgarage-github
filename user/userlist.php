<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $wms->deleteutilisateurInformation($link, $_GET['id']);
    $delinfo = 'block';
    $msg = "Informations de l'utilisateur supprimée avec succès";
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
    $addinfo = 'block';
    $msg = "Informations de l'utilisateur ajouté avec succès";
    unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
    $addinfo = 'block';
    $msg = "Informations de l'utilisateur modifiées avec succès";
    unset($_SESSION['token']);
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $_SESSION['token'] = 'add';
    $url = WEB_URL . 'user/userlist.php';
    header("Location: $url");
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $_SESSION['token'] = 'up';
    $url = WEB_URL . 'user/userlist.php';
    header("Location: $url");
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
    <h1> <i class="fa fa-list"></i> Liste des utilisateurs </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Liste des utilisateurs</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i> Suppression!</h4>
                <?php echo $msg; ?>
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> Succès!</h4>
                <?php echo $msg; ?>
            </div>
            <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/adduser.php" data-original-title="Ajouter un utilisateur"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
            <div class="box box-success">
                <!-- <div class="box-header">
                    <h3 class="box-title">Liste des utilisateurs</h3>
                </div> -->
                <!-- /.box-header -->
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Type utilisateur</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $results = $wms->getAllUserData($link);
                            foreach ($results as $row) {
                                $image = WEB_URL . 'img/no_image.jpg';
                                if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                                	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                                }
                                ?>
                                <tr>
                                    <td><img class="photo_img_round img_size" src="<?php echo $image;  ?>" /></td>
                                    <td><?php echo $row['usr_name']; ?></td>
                                    <td><?php echo $row['usr_email']; ?></td>
                                    <td><?php echo $row['usr_type']; ?></td>
                                    <td>
                                        <!-- <a class="btn btn-success" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['usr_id']; ?>').modal('show');" data-original-title="View"><i class="fa fa-eye"></i></a>  -->
                                        <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/adduser.php?id=<?php echo $row['usr_id']; ?>" data-original-title="Modifier"><i class="fa fa-pencil"></i></a> 
                                        <a class="btn btn-danger" data-toggle="tooltip" onClick="deleteSupplier(<?php echo $row['usr_id']; ?>);" href="javascript:;" data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                                        <div id="nurse_view_<?php echo $row['usr_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header orange_header">
                                                        <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                                                        <h3 class="modal-title">Détail de l'utilisateur</h3>
                                                    </div>
                                                    <div class="modal-body model_view" align="center">&nbsp;
                                                        <div><img class="photo_img_round" style="width:100px;height:100px;" src="<?php echo $image;  ?>" /></div>
                                                        <div class="model_title"><?php echo $row['r_name']; ?></div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                <h3 style="text-decoration:underline;">Details Information</h3>
                                                                <b>Name :</b> <?php echo $row['r_name']; ?><br />
                                                                <b>Email :</b> <?php echo $row['r_email']; ?><br />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- /.modal-content -->
                                                </div>
                                            </div>
                                    </td>
                                </tr>
                            <?php } ?>
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
        function deleteSupplier(Id) {
            var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
            if (iAnswer) {
                window.location = '<?php echo WEB_URL; ?>user/userlist.php?id=' + Id;
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