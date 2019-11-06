/**
 * dhPrep.js
 *
 * @description Process the form.
 *
 * @author Mark Whitcomb
 * @copyright 10/30/2018
 * 
 * Total rewrite 7/31/2019 
 * I want to use javascript instead of jquery.
 * This is also going to be an exercise in js scope.
 * 
 */
'use strict'
// Global variables
let errMsgObj = document.getElementById("errMsg");
let errMsg = "";

let theSubmit = document.getElementById("formSubmit");
theSubmit.addEventListener("click", doSomething);

function doSomething() {

    // I'm mixing jquery stuff ($("blabber")) with low level DOM
    // (document.getBlabber).  I should change the low level stuff
    // to use jquery but screw it.  It works.
    // Somewhere I read that getelementbyid is faster, so SUCKIT.
    let base_g = Number($("input[name='baseG']:checked").val());
    let mod_p_size = Number(document.getElementById("modPSize").value);
    let a_secret = Number(document.getElementById("aSecret").value);
    let b_secret = Number(document.getElementById("bSecret").value);

    // clear the error message.
    document.getElementById("errMsg").innerHTML = "";

    if (!validateFields()) {
        var text = document.createTextNode(errMsg);
        errMsgObj.appendChild(text);
        return;
    };

    let data = {
        "base_g": base_g,
        "mod_p_size": mod_p_size,
        "a_secret": a_secret,
        "b_secret": b_secret
    };

    let url = "php/dhCalc.php";

    console.log("doing ajax call");

    $.ajax({
        type: "POST",
        url: url,
        headers: {
            "Content-Type": "application/json"
        },
        data: JSON.stringify(data),
        success: function(returned) {
            let ret_data = JSON.parse(returned);
            $("#theReturn").html(
                ret_data.return2 + "\n" +
                ret_data.return3 + "\n" +
                ret_data.return4 + "\n" +
                ret_data.return5 + "\n" +
                ret_data.return6
            );
        },
        fail: function() {
            console.log("Ajax call didnt work");
        }
    });

    // Reset the button didn't work but putting focus on 
    // first field available did.
    // document.getElementById("formSubmit").disabled = false;
    document.getElementById("modPSize").focus();
}

function validateFields(base_g, mod_p_size, a_secret, b_secret) {

    let isErr = false;

    if (base_g == NaN) {
        errMsg = "Base G not a number";
        isErr = true;
    }
    if (mod_p_size == NaN) {
        errMsg = "Mod P size not a number";
        isErr = true;
    }
    if (a_secret == NaN) {
        errMsg = "Alices secret number not a number";
        isErr = true;
    }
    if (b_secret == NaN) {
        errMsg = "Bobs secret number not a number";
        isErr = true;
    }

    if (isErr) {
        return 0;
    } else {
        return 1;
    }

}