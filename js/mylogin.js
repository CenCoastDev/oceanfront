/**
 * mylogin.js
 * 
 * @description Do general login stuff
 * 
 * @author Mark Whitcomb
 * @copyright 9/14/2019
 * 
 */
'use strict'

let theSubmit = document.getElementById("formSubmit");
theSubmit.addEventListener("click", doSomething);

function doSomething() {

    // Last check to see if fields are ok
    if (($("#userid").valid() == false) ||
        ($("#pw").valid() == false)) {
        return;
    }

    // Get values from the input fields
    let $userid = $('#userid').val();
    let $pw = $('#pw').val();

    // Build json data
    let data = {
        "userid": $userid,
        "pw": $pw
    };

    fetch("php/existsUser.php", {
            method: "POST",
            mode: "cors",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json"
            },
            body: JSON.stringify(data)
        })
        // Below is how to do it if you don't care
        // to test the return from php and assume
        // that it'll return a valid json object.
        // 
        // .then((response) => response.json())
        // 
        // Below is what I'm going to do to test
        // the return and handle errors instead
        // of just hand off to the .catch at the end.
        .then(function(response) {
            if (!response.ok) {
                if (response.status == 404) {
                    console.log("can't get php program");
                } else {
                    console.log("fetch failed, response=" + response.status);
                }
                // problem here is that I can't break out of this.
                // It's going to do the next .then.
                //
                // Also note that you need to return either a string
                // if return response.txt() 
                // or an object if return response.json()
                //
                // Below works if return response.json()
                // return { return: "err", msg: "Failed php call" };
                //
                // Below doesn't work if return response.text()
                // because javascript is a fucking piece of shit
                // language.  I have no idea what the syntax of this
                // fucking piece of shit should be so that 
                // the NEXT .then can successfully json.parse it.
                //
                // - didn't work
                // return "return: 'err', msg: 'Failed php call'";
                // - didn't work
                // return '{"return": err, "msg": "Failed php call"}';
                // - didn't work
                // return '"return": err';
                // -didn't work
                // return "return: err";
                // - finally got below to work.  Fuck you very much, javascript.
                return '{"return":"err","msg":"Failed php call"}';
            }
            // If php doesn't respond with json I'll find out
            // in the next .then.
            return response.text();
        })
        .then(function(response) {
            let dataFromPhp = {};
            try {
                dataFromPhp = JSON.parse(response);
            } catch (error) {
                console.log(error);
                if (response.substring(0, 1) == "<") {
                    // then it's probably an error from
                    // php passed back folded in html.
                    //
                    // Below will actually show what the error is
                    // $('#divErr').append(response);
                    //  or
                    // console.log(response);
                    //
                    // but since everyone insists on keeping
                    // the user in the dark as to what the hell
                    // is going on, I'll oblige and give some
                    // shit, useless error message here.
                    $('.results-textarea').text("Something went wrong.  Tough shit.");
                } else {
                    $('.results-textarea').text(response);
                }
                return;
            }
            // ok, we know we've returned with json
            // but there's nothing that ties the array
            // names used to build the json string in the
            // php program to here.  Only way would be to
            // iterate thru json object searching for 
            // a value I can reference here in javascript.
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
        // Could be here from the first .then or the last .then 
        // or from the body of either of the functions.
        // Who knows.
        .catch(function(error) {
            console.log(error);
            $('.results-textarea').text("Something went wrong.  Tough shit.");
        });

}