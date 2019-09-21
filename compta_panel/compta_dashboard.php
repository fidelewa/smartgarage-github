<?php
include('../header.php');

$delinfo = 'none';
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deleteRecuScanner($link, $_GET['id']);
  $delinfo = 'block';
}

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

      <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
        <h4><i class="icon fa fa-ban"></i> Annulé!</h4>
        Annulation du reçu de paiement du scanner réussi.
      </div>

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
                <th>Personne ayant enregistré le client</th>
                <th>Téléphone du client</th>
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
                  <td><?php echo $row['usr_name']; ?></td>
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
                      <a class="btn btn-info" data-toggle="tooltip" href="<?php echo WEB_URL; ?>servcli_panel/recu_paiement_scanner.php?nbr_aleatoire=<?php echo $row['nbr_aleatoire']; ?>&recu_scanning_id=<?php echo $row['id']; ?>&validation_recu_scanning=<?php echo $row['validation_recu_scanning']; ?>" data-original-title="Afficher le reçu de paiement du scanner">Visualiser le reçu de paiement du scanner</a>
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
<script type="text/javascript">
  // Définition de la locale en français
  numeral.register('locale', 'fr', {
    delimiters: {
      thousands: ' ',
      decimal: ','
    },
    abbreviations: {
      thousand: 'k',
      million: 'm',
      billion: 'b',
      trillion: 't'
    },
    currency: {
      symbol: 'FCFA'
    }
  });

  // Sélection de la locale en français
  numeral.locale('fr');

  // Initialisation des variables
  var frais_scanner = "<?php echo $row['frais_scanner']; ?>";

  // analyse de la chaîne de caractères JSON et 
  // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
  var scanner_data_obj = JSON.parse('<?= $scanner_data_json; ?>');

  // console.log(scanner_data_obj);

  // Déclaration et initialisation de l'objet itérateur
  var iterateur = scanner_data_obj.keys();

  // Déclaration et initialisation de l'indice ou compteur
  var row = iterateur.next().value;

  // Parcours du tableau d'objet
  for (const key of scanner_data_obj) {

    // Conversion en flottant
    key.frais_scanner = parseFloat(key.frais_scanner);

    console.log(numeral(key.frais_scanner).format('0,0 $'));

    // Affectation des nouvelles valeurs
    $("#frais_scanner_" + row).html(numeral(key.frais_scanner).format('0,0 $'));

    // incrémentation du compteur
    row++;

  }

  // Conversion des variables en flottant
  frais_scanner = parseFloat(frais_scanner);

  // console.log(numeral(frais_scanner).format('0,0 $'));

  // console.log($("#salaire_base_scanner"));

  $("#frais_scanner").html(numeral(frais_scanner).format('0,0 $'));

  function deleteSupplier(Id) {
    var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
    if (iAnswer) {
      window.location = '<?php echo WEB_URL; ?>user/userlist.php?id=' + Id;
    }
  }

  $(document).ready(function() {
    setTimeout(function() {
      $("#me").hide(8000);
      $("#his").hide(8000);
    }, 8000);
  });
</script>
<!-- /.content -->
<?php include('../footer.php'); ?>