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

    // TODO What does mode='cors' do?
    fetch("php/dhCalc.php", {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        // This is the only way I can figure out how to handle php error
        // coming back as an html string, not json.  Just do response.text()
        // and test the return thing in the next .then.
        .then((response) => response.text())
        .then(function(returned_data) {
            // Need to figure out if I have json data or did the php
            // program puke out some html stuff.
            try {
                let data = JSON.parse(returned_data);
                if (data.ret_code == 'ok') {
					// Changed from .html to .text.
					// I was hoping this would fix my
					// shitty iphone not displaying anything.
					// It didn't fix.
                    $("#theReturn").text(
                        data.return2 + "\n" +
                        data.return3 + "\n" +
                        data.return4 + "\n" +
                        data.return5 + "\n" +
                        data.return6
                    );
                } else if (data.ret_code == 'err') {
                    $("#theReturn").text(data.return2 + "\n" + data.return3);
                } else {
                    $("#theReturn").text(returned_data);
                }
            } catch (error) {
                // if here then err on try json.parse?
                // I don't know because javascript is shit.
                $("#theReturn").text("Data returned from php not json. Probably php error.");
                console.log(error);
            }
        })
        // Catch what?  I don't know what will end up here.
        .catch((error) => {
            $("#theReturn").text("Problem on server side");
            console.log(error);
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