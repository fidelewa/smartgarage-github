<?php
include_once('../header.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
  $wms->deletePersoInfo($link, $_GET['id']);
  $delinfo = 'block';
}
//	add success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'add') {
  $addinfo = 'block';
  $msg = "Informations d'un membre du personnel ajouté avec succès";
  unset($_SESSION['token']);
}
//	update success
if (isset($_SESSION['token']) && $_SESSION['token'] == 'up') {
  $addinfo = 'block';
  $msg = "Informations d'un membre du personnel modifiées avec succès";
  unset($_SESSION['token']);
}
if (isset($_GET['m']) && $_GET['m'] == 'add') {
  $_SESSION['token'] = 'add';
  $url = WEB_URL . 'user/listepersonnel.php';
  header("Location: $url");
}
if (isset($_GET['m']) && $_GET['m'] == 'up') {
  $_SESSION['token'] = 'up';
  $url = WEB_URL . 'user/listepersonnel.php';
  header("Location: $url");
}

if (isset($_GET['m']) && $_GET['m'] == 'up_worktool') {
  $addinfo = 'block';
  $msg = "Outil de travail modifié avec succès";
}

if (isset($_GET['m']) && $_GET['m'] == 'add_worktool') {
  $addinfo = 'block';
  $msg = "Outil de travail ajouté avec succès";
}

// if (isset($_GET['m']) && $_GET['m'] == 'prime_perso') {
//   $addinfo = 'block';
//   $msg = "Prime attribuée avec succès";
// }

// if (isset($_GET['m']) && $_GET['m'] == 'avance_perso') {
//   $addinfo = 'block';
//   $msg = "Avance attribuée avec succès";
// }

$i = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
  <script src="<?php echo WEB_URL; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
</head>

<body>
  <!-- Content Header (Page header) -->

  <section class="content-header">
    <h1> Liste du personnel </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Liste du personnel</li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!-- Full Width boxes (Stat box) -->
    <div class="row">
      <div class="col-xs-12">
        <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
          <h4><i class="icon fa fa-ban"></i> Supprimé!</h4>
          Suppression des informations du personnel réussi.
        </div>
        <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
          <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
          <h4><i class="icon fa fa-check"></i> Ajouté!</h4>
          <?php echo $msg; ?>
        </div>
        <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php" data-original-title="Ajouter un nouveau personnel"><i class="fa fa-plus"></i></a> <a class="btn btn-warning" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="Dashboard"><i class="fa fa-dashboard"></i></a> </div>
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Liste du personnel</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>N° maticule</th>
                  <th>Nom</th>
                  <th>Téléphone</th>
                  <th>Fonction</th>
                  <th>Salaire</th>
                  <th>Type de contrat</th>
                  <th>Date d'embauche</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $results = $wms->getAllPersoData($link);
                foreach ($results as $row) {
                  $image = WEB_URL . 'img/no_image.jpg';
                  // if(file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != ''){
                  // 	$image = WEB_URL . 'img/upload/' . $row['image'];
                  // }

                  // var_dump($row);
                  ?>
                  <tr>
                    <td><?php echo $row['per_mat']; ?></td>
                    <td><?php echo $row['per_name']; ?></td>
                    <td><?php echo $row['per_telephone']; ?></td>
                    <td><?php echo $row['per_fonction']; ?></td>
                    <td id="salaire_brute_perso_<?php echo $i; ?>"><?php echo $row['per_sal']; ?></td>
                    <td><?php echo $row['per_type_contrat']; ?></td>
                    <td><?php echo $row['per_date_emb']; ?></td>
                    <td>
                      <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#employe_info_modal_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="Voir la description de l'employé"><i class="fa fa-eye"></i></a>

                      <!-- <a class="btn btn-success" style="background-color:blue;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#prime_modal_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="Donner une prime à l'employé"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-success" style="background-color:yellow;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#avance_modal_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="Donner une avance à l'employé"><i class="fa fa-pencil"></i></a> -->

                      <a class="btn btn-primary" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/addpersonnel.php?id=<?php echo $row['per_id']; ?>" data-original-title="Modifier"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-danger" data-toggle="tooltip" onClick="deletePersonnel(<?php echo $row['per_id']; ?>);" href="javascript:;" data-original-title="Supprimer"><i class="fa fa-trash-o"></i></a>
                      <!-- <a class="btn btn-success" style="background-color:orange;color:#ffffff;" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['per_id']; ?>').modal('show');" data-original-title="Voir l'historique des avances sur salaire de l'employé"><i class="fa fa-eye"></i></a> -->
                      <a class="btn btn-success" style="background-color:gray;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/histo_avance_prime_emp.php?per_id=<?php echo $row['per_id']; ?>" data-original-title="Voir l'historique des avances et des primes du salarié"><i class="fa fa-eye"></i></a>
                      <a class="btn btn-info" style="background-color:#9bd500;color:#ffffff;" target="_blank" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/workToolspersonnel.php?per_id=<?php echo $row['per_id']; ?>" data-original-title="Enregister un outil de travail pour l'employé"><i class="fa fa-plus"></i></a>
                      <a class="btn btn-success" style="background-color:#CF7B00;color:#ffffff;" data-toggle="tooltip" href="<?php echo WEB_URL; ?>user/workToolspersonnel_list.php?per_id=<?php echo $row['per_id']; ?>" data-original-title="Afficher la liste des outils de travail de l'employé"><i class="fa fa-list"></i></a>
                    </td>
                  </tr>
                  <div id="employe_info_modal_<?php echo $row['per_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <a class="close" data-dismiss="modal">×</a>
                          <h3>Détail des informations d'un employé</h3>
                        </div>

                        <div class="modal-body">
                          <form id="infoPersForm" name="info_pers" role="form" enctype="multipart/form-data" method="POST" action="">

                            <!-- <?php var_dump($row['per_id']); ?> -->

                            <div class="row">
                              <div class="col-md-3"><b>Nom de l'employé :</b></div>
                              <div class="col-md-9"><?php echo $row['per_name']; ?></div>
                            </div>

                            <div class="row">
                              <div class="col-md-3"><b>N° téléphone :</b></div>
                              <div class="col-md-9"><?php echo $row['per_telephone']; ?></div>
                            </div>

                            <div class="row">
                              <div class="col-md-3"><b>Fonction :</b></div>
                              <div class="col-md-9"><?php echo $row['per_fonction']; ?></div>
                            </div>

                            <div class="row">
                              <div class="col-md-3"><b>Salaire de base :</b></div>
                              <div class="col-md-9" id="salaire_base_perso"><?php echo $row['per_sal']; ?></div>
                            </div>

                          </form>
                        </div>

                      </div>
                    </div>
                  </div>
                  <!-- <div id="prime_modal_<?php echo $row['per_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <a class="close" data-dismiss="modal">×</a>
                          <h3>Formulaire de l'attribution de la prime</h3>
                        </div>

                        <form id="primeSalForm" name="prime_sal" role="form" enctype="multipart/form-data" method="POST" action="prime_process.php">

                          <div class="modal-body">

                            <div class="form-group">
                              <label for="txtCName"> Prime :</label>
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="number" class='form-control' name="prime_sal" id="prime_sal" placeholder="Saisissez le montant de la prime" onfocus="">
                                </div>
                              </div>
                            </div>

                            <input type="hidden" name="prime_pers_id" value="<?php echo $row['per_id']; ?>">
                            <input type="hidden" name="prime_pers_telephone" value="<?php echo $row['per_telephone']; ?>">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success" id="submit">Valider</button>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div>
                  <div id="avance_modal_<?php echo $row['per_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <a class="close" data-dismiss="modal">×</a>
                          <h3>Formulaire de l'attribution de l'avance sur salaire</h3>
                        </div>

                        <form id="avanceSalForm" name="avance_sal" role="form" enctype="multipart/form-data" method="POST" action="avance_process.php">

                          <div class="modal-body">

                            <div class="form-group">
                              <label for="txtCName"> Avance sur salaire :</label>
                              <div class="row">
                                <div class="col-md-12">
                                  <input type="number" class='form-control' name="avance_sal" id="avance_sal" placeholder="Saisissez le montant de l'avance" onfocus="">
                                </div>
                              </div>
                            </div>

                            <input type="hidden" name="avance_pers_id" value="<?php echo $row['per_id']; ?>">
                            <input type="hidden" name="avance_pers_telephone" value="<?php echo $row['per_telephone']; ?>">
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-success" id="submit">Valider</button>
                          </div>
                        </form>

                      </div>
                    </div>
                  </div> -->
                  <?php
                  $i++;
                }
                // On retourne la représentation JSON du tableau
                $perso_data_json = json_encode($results, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

              
                ?>
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->

    </div>

  </section>
  <!-- /.row -->
</body>

</html>


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
  var per_sal = "<?php echo $row['per_sal']; ?>";

  // analyse de la chaîne de caractères JSON et 
  // construction de la valeur JavaScript ou l'objet décrit par cette chaîne
  var perso_data_obj = JSON.parse('<?= $perso_data_json; ?>');

  // console.log(perso_data_obj);

  // Déclaration et initialisation de l'objet itérateur
  var iterateur = perso_data_obj.keys();

  // Déclaration et initialisation de l'indice ou compteur
  var row = iterateur.next().value;

  // Parcours du tableau d'objet
  for (const key of perso_data_obj) {

    // Conversion en flottant
    key.per_sal = parseFloat(key.per_sal);

    // Affectation des nouvelles valeurs
    $("#salaire_brute_perso_" + row).html(numeral(key.per_sal).format('0,0 $'));

    // incrémentation du compteur
    row++;

  }

  // Conversion des variables en flottant
  per_sal = parseFloat(per_sal);

  // console.log(numeral(per_sal).format('0,0 $'));

  // console.log($("#salaire_base_perso"));

  $("#salaire_base_perso").html(numeral(per_sal).format('0,0 $'));

  function deletePersonnel(Id) {
    var iAnswer = confirm("Êtes-vous sûr de vouloir supprimer ce personnel ?");
    if (iAnswer) {
      window.location = '<?php echo WEB_URL; ?>user/listepersonnel.php?id=' + Id;
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