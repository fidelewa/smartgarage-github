$(document).ready(function () {
    $("#assuranceForm").submit(function (event) {
        submitAssuranceForm();
        getAllAssur();
        return false;
    });
    $("#marqueForm").submit(function (event) {
        submitMarqueForm();
        getAllMarque();
        return false;
    });
    $("#modelForm").submit(function (event) {
        submitModelForm();
        getAllModel();
        return false;
    });
    $("#clientForm").submit(function (event) {
        submitClientForm();
        getAllClient();
        return false;
    });

    // Cette fonction anonyme va écouter l'évènement de soumission du formulaire de réception d'un véhicule
    // $("#regForm").submit(function (event) {
    //     submitRecepForm();
    //     return false;
    // });
});

function submitAssuranceForm() {
    $.ajax({
        type: "POST",
        url: "../ajax/saveAssurance.php",
        cache: false,
        data: $('form#assuranceForm').serialize(),
        success: function (response) {
            $("#assurance").html(response)
            $("#assurance-modal").modal('hide');
        },
        error: function () {
            alert("Error");
        }
    });
}

function submitMarqueForm() {
    $.ajax({
        type: "POST",
        url: "../ajax/saveMarque.php",
        cache: false,
        data: $('form#marqueForm').serialize(),
        success: function (response) {
            $("#marque").html(response)
            $("#marque-modal").modal('hide');
        },
        error: function () {
            alert("Error");
        }
    });
}

function submitModelForm() {
    $.ajax({
        type: "POST",
        url: "../ajax/saveModel.php",
        cache: false,
        data: $('form#modelForm').serialize(),
        success: function (response) {
            $("#model").html(response)
            $("#model-modal").modal('hide');
        },
        error: function () {
            alert("Error");
        }
    });
}

// function submitRecepForm() {

//     // On sélectionne le 1er formulaire (formulaire de réception) et on extrait ses données
//     var form = $('form')[0]
//     var formData = new FormData(form);
//     var web_url = "http://127.0.0.1:8181/smartgarage-github/";

//     // On récupère toutes les images du formulaire
//     formData.append('image', $('input[type=file]')[0].files[0]);

//     console.log(formData);

//     // On transmet les données du formulaire au fichier de traitement 
//     $.ajax({
//         type: "POST",
//         url: "../ajax/addcar_reception_traitement.php",
//         cache: false,
//         data: formData,
//         contentType: false,
//         processData: false,
//         success: function () {
//             // Avant le traitement on fait une redirection
//             window.location.href = web_url + "recep_panel/recep_dashboard.php?m=reception_success";
//             // $("#client-modal").modal('hide');
//             // $("#ddlCustomerList").focus();
//         },
//         error: function () {
//             alert("Error");
//         },
//         beforeSend: function() {
//             // Avant le traitement on fait une redirection
//             window.location.href = web_url + "recep_panel/recep_dashboard.php?m=reception_processing";
//             // window.location.href = web_url + "repaircar/repaircar_doc_gene.php?car_id=" + car_id + "&etat=" + etat + "&sign=" + signataire + "&image=" + image_url+ "&login_type=" + login_type;
//         }
//     });
// }

function submitClientForm() {

    // On sélectionne le deuxième formulaire (formulaire des clients) et on extrait ses données
    var form = $('form')[1]
    var formData = new FormData(form);

    // On récupère les images du formulaire
    formData.append('image', $('input[type=file]')[0].files[0]);

    // On transmet les données du formulaire au fichier de traitement 
    $.ajax({
        type: "POST",
        url: "../ajax/saveClient.php",
        cache: false,
        data: formData,
        contentType: false,
        processData: false,
        success: function () {
            $("#client-modal").modal('hide');
            $("#ddlCustomerList").focus();
        },
        error: function () {
            alert("Error");
        }
    });
}

function getAllAssur() {

    $.ajax({
        url: '../ajax/getstate.php',
        type: 'POST',
        data: 'token=getallassur',
        dataType: 'html',
        success: function (data) {
            // On défini le contenu html de l'élément avec des données
            $("#assurance_vehi_recep").html(data);
        }
    });
}

function getAllMarque() {

    $.ajax({
        url: '../ajax/getstate.php',
        type: 'POST',
        data: 'token=getallmarque',
        dataType: 'html',
        success: function (data) {
            // On défini le contenu html de l'élément avec des données
            $("#ddlMake").html(data);
        }
    });
}

function getAllModel() {

    $.ajax({
        url: '../ajax/getstate.php',
        type: 'POST',
        data: 'token=getallmodel',
        dataType: 'html',
        success: function (data) {
            // On défini le contenu html de l'élément avec des données
            $("#ddl_model").html(data);
        }
    });
}

function getAllClient() {

    $.ajax({
        url: '../ajax/getstate.php',
        type: 'POST',
        data: 'token=getallclient',
        dataType: 'html',
        success: function (data) {
            // On défini le contenu html de l'élément avec des données
            // $("#ddlCustomerList").html(data);
        }
    });
}
