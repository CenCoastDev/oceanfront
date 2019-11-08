/**
 * mynewacct.js
 * 
 * @description Create a new acct
 * 
 * @author Mark Whitcomb
 * @copyright 11/6/2019
 * 
 */
'use strict'

let theSubmit = document.getElementById("formNewAcct");
theSubmit.addEventListener("click", doSomething);

function doSomething() {

    // Last check to see if fields are ok
    if (($("#userid").valid() == false) ||
        ($("#pass").valid() == false)) {
        return;
    }

    // Get values from the input fields
    let $userid = $('#userid').val();
    let $pass = $('#pass').val();
    let $first = $('#first').val();
    let $last = $('#last').val();
    let $email = $('#email').val();
    let $street = $('#street').val();
    let $city = $('#city').val();
    let $state = $('#state').val();
    let $zip = $('#zip').val();
    let $phone = $('#phone').val();

    // Build json data
    let data = {
        "userid": $userid,
        "pass": $pass,
        "first": $first,
        "last": $last,
        "email": $email,
        "street": $street,
        "city": $city,
        "state": $state,
        "zip": $zip,
        "phone": $phone
    };

    fetch("php/newUser.php", {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        .then(function(response) {
            if (!response.ok) {
                if (response.status == 404) {
                    console.log("can't get php program");
                } else {
                    console.log("fetch failed, response=" + response.status);
                }
                return '{"return":"err","msg":"Failed php call"}';
            }
            return response.text();
        })
        .then(function(response) {
            let dataFromPhp = {};
            try {
                dataFromPhp = JSON.parse(response);
            } catch (error) {
                console.log(error);
                if (response.substring(0, 1) == "<") {
                    $('.results-textarea').text("Something went wrong.  Tough shit.");
                } else {
                    $('.results-textarea').text(response);
                }
                return;
            }
            if (dataFromPhp.return === 'ok') {
                $('.results-textarea').text('Login ID ' +
                    dataFromPhp.retid +
                    ' ' +
                    dataFromPhp.retname);
            } else {
                console.log(dataFromPhp.msg);
                $('.results-textarea').text("Something went wrong.  Tough shit.");
            }
        })
        .catch(function(error) {
            console.log(error);
            $('.results-textarea').text("Something went wrong.  Tough shit.");
        });

}