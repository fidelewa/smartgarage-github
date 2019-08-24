<?php include('../header.php');
$button_text = "Enregistrer";

if (isset($_POST) && !empty($_POST)) {

    // var_dump($_POST);
    // die();

    // échappement des données saisies
    if (!empty($_POST['sortie_remarq_recep_vehi_text'])) {
        $_POST['sortie_remarq_recep_vehi_text'] = mysql_real_escape_string($_POST['sortie_remarq_recep_vehi_text']);
    }

    if (!empty($_POST['remarque_etat_vehi_sortie'])) {
        $_POST['remarque_etat_vehi_sortie'] = mysql_real_escape_string($_POST['remarque_etat_vehi_sortie']);
    }

    // var_dump($_POST);
    // die();

    $query = "UPDATE tbl_recep_vehi_repar 
SET etat_reparation_sortie='" . $_POST[etat_reparation_sortie] . "' ,
etat_proprete_sortie='" . $_POST[etat_proprete_sortie] . "' ,
sortie_remarq_recep_vehi='" . $_POST[sortie_remarq_recep_vehi] . "' ,
sortie_remarq_recep_vehi_text='" . $_POST[sortie_remarq_recep_vehi_text] . "',
remarque_etat_vehi_sortie='" . $_POST[remarque_etat_vehi_sortie] . "',
status_sortie_vehicule=1
WHERE car_id='" . (int) $_GET['cid'] . "'";

    // Exécution de la requête
    $result = mysql_query($query, $link);

    // Vérification du résultat de la requête et affichage d'un message en cas d'erreur
    // if ($result) {
    // Redirection vers la liste des devis
    $url = WEB_URL . 'reception/repaircar_reception_list.php?m=etat_vehi_sortie';
    header("Location: $url");
    // }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etat du véhicule à la sortie</title>
    <style>
        button {
            background-color: #4CAF50;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 17px;
            font-family: Raleway;
            cursor: pointer;
        }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <!-- <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo WEB_URL ?>dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo WEB_URL ?>customer.customerlist.php">Client</a></li>
            <li class="active">Add/Update Client</li>
        </ol>
    </section> -->
    <!-- Main content -->
    <form onSubmit="return validateMe();" action="" method="post" enctype="multipart/form-data">
        <section class="content">
            <!-- Full Width boxes (Stat box) -->
            <div class="row">
                <div class="col-md-12">

                    <div align="right" style="margin-bottom:1%;">
                        <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/repaircar_reception_list.php" data-original-title="Retour"><i class="fa fa-reply"></i></a>
                    </div>

                    <div class="box box-success">
                        <div class="box-body">

                            <h1 style="text-align:center;">Etat du véhicule à la sortie</h1>
                            <p style="color:red; font-style:italic">NB: Veuillez sélectionner l'état correspondant à votre véhicule</p>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input required type="radio" id="etat_reparation_sortie" name="etat_reparation_sortie" value="Réparé">
                                    <label for="repare">Réparé</label>
                                </div>
                                <div class="col-md-6">
                                    <input required type="radio" id="etat_reparation_sortie" name="etat_reparation_sortie" value="Non-réparé">
                                    <label for="non_repare">Non-réparé</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input required type="radio" id="etat_proprete_sortie" name="etat_proprete_sortie" value="Propre">
                                    <label for="propre">Propre</label>
                                </div>
                                <div class="col-md-6">
                                    <input required type="radio" id="etat_proprete_sortie" name="etat_proprete_sortie" value="Poussiereuse">
                                    <label for="poussiereuse">Poussièreuse</label>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-3">
                                    <input type="checkbox" id="sortie_remarq_recep_vehi" name="sortie_remarq_recep_vehi" value="Remorqué">
                                    <label for="remarque">Remorqué</label>
                                </div>
                                <div class="col-md-9" style="padding-left:0px;">
                                    <input type="text" name="sortie_remarq_recep_vehi_text" id="sortie_remarq_recep_vehi_text" class="form-control">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="remarque_etat_vehi_sortie" class="col-md-2 col-form-label">Remarque :</label>
                                <div class="col-md-10" style="padding-left:0px;">
                                    <textarea class="form-control" id="remarque_etat_vehi_sortie" rows="4" name="remarque_etat_vehi_sortie"></textarea>
                                </div>
                            </div>

                        </div>
                        <!-- <input type="hidden" value="<?php echo $hdnid; ?>" name="customer_id" /> -->
                        <!-- /.box-body -->

                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <div class="pull-right">
            <button type="submit" class="btn btn-success btnsp"><i class="fa fa-save fa-2x"></i><br />
                <?php echo $button_text; ?></button>&emsp;
            <!-- <a class="btn btn-warning btnsp" data-toggle="tooltip" href="<?php echo WEB_URL; ?>reception/receptionnistelist.php" data-original-title="Retour"><i class="fa fa-reply  fa-2x"></i><br />
                            Retour</a>  -->
        </div>
    </form>
</body>

</html>

<?php include('../footer.php'); ?>