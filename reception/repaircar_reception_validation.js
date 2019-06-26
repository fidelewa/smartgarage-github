$(document).ready(function() {
    $('#nextBtn').bootstrapValidator({        
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            immat: {
                validators: {
                        notEmpty: {
                        message: "veuillez saisir l'immatriculation"
                    }
                }
            },             
        }
    });
});