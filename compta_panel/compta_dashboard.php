<?php
include('../header.php');

// var_dump($_SESSION);
$i = 0;

$settings = $wms->getWebsiteSettingsInformation($link);

?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1 style="text-transform:uppercase;font-weight:bold;color:#00a65a;"> <?php echo $settings['site_name'] . ' Dashboard'; ?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL; ?>dashboard.php"><i class="fa fa-dashboard"></i> Accueil</a></li>
    <li class="active">Dashboard</li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div align="right" style="margin-bottom:1%;">

        <!-- <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#infos_car_client_modal').modal('show');" data-original-title="Enregistrement du véhicule et du scanner">Délivrer un reçu</a> -->
        <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>customer/addcustomer.php" data-original-title="Enregistrer un nouveau client">Ajouter un nouveau client</a> -->
        <!-- <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> -->
      </div>

      <div class="box box-success">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-list"></i> Liste des derniers scanners enregistrés par véhicules</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table class="table sakotable table-bordered table-striped dt-responsive">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nom client</th>
                <th>Numéro téléphone</th>
                <th>Immatriculation</th>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Scanner mécanique</th>
                <th>Scanner électrique</th>
                <th>Frais de scanner</th>
                <th>Statut reçu scanner</th>
                <th>Statut scanner</th>
                <th>Statut reception</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $results = $wms->getCarScanning($link);
              foreach ($results as $row) {
                // $image = WEB_URL . 'img/no_image.jpg';
                // if(file_exists(ROOT_PATH . '/img/upload/' . $row['usr_image']) && $row['usr_image'] != ''){
                // 	$image = WEB_URL . 'img/upload/' . $row['usr_image'];
                // }
                ?>
              <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['c_name']; ?></td>
                <td><?php echo $row['princ_tel']; ?></td>
                <td><?php echo $row['imma_vehi_client']; ?></td>
                <td><?php echo $row['marque_vehi_client']; ?></td>
                <td><?php echo $row['model_vehi_client']; ?></td>
                <td><?php echo $row['scanner_mecanique']; ?></td>
                <td><?php echo $row['scanner_electrique']; ?></td>
                <td id="frais_scanner_<?php echo $i; ?>"><?php echo $row['frais_scanner']; ?></td>
                <td><?php
                      if ($row['validation_recu_scanning'] == null) {
                        echo "<span class='label label-default'>Non validé</span> <br/>";
                      } else if ($row['validation_recu_scanning'] == 1) {
                        echo "<span class='label label-success'>validé</span> <br/>";
                      }
                      ?></td>
                <td><?php
                      if ($row['statut_scannage'] == null) {
                        echo "<span class='label label-default'>En attente de scan</span> <br/>";
                      } else if ($row['statut_scannage'] == 1) {
                        echo "<span class='label label-success'>Scan effectué</span> <br/>";
                      }
                      ?></td>
                <td><?php
                      if ($row['statut_reception'] == null) {
                        echo "<span class='label label-default'>En attente de reception</span> <br/>";
                      } else if ($row['statut_reception'] == 1) {
                        echo "<span class='label label-success'>Reception effectuée</span> <br/>";
                      }
                      ?></td>
                <td>
                  <?php if ($_SESSION['login_type'] == 'comptable') { ?>
                  <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/recu_paiement_scanner.php?nbr_aleatoire=<?php echo $row['nbr_aleatoire']; ?>" data-original-title="Afficher le reçu de paiement du scanner">Imprimer le reçu de paiement du scanner</a>
                  <a class="btn btn-info" style="background-color:green;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>compta_panel/validation_recu_scanning.php?recu_scanning_id=<?php echo $row['id']; ?>" data-original-title="valider le reçu de paiement du scanner">Valider le reçu de paiement du scanner</a>
                  <?php } ?>
                </td>
              </tr>
              <?php
                $i++;
              }
              // On retourne la représentation JSON du tableau
              $scanner_data_json = json_encode($results, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
              ?>
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
  </div>
</section>
<!-- /.content -->
<?php include('../footer.php'); ?>