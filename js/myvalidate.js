/**
 * My form validations
 */
$(document).ready(function() {
    $("#dhPrep").validate({
        rules: {
            modPSize: {
                min: 1,
                max: 4096,
                maxlength: 4
            },
            aSecret: {
                min: 1,
                maxlength: 64,
                digits: true
            },
            bSecret: {
                min: 1,
                maxlength: 64
            }
        }
    });

    $("#login").validate({
        rules: {
            userid: {
                maxlength: 64
            },
            pw: {
                maxlength: 64
            }
        }
    });

});