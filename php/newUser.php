<?php
/**
 * newUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 11/7/2019
 * 
 * Create a new user.
 * 
 */
declare (strict_types=1);

require_once 'sanitizeLogin.php';
require_once 'sanitizeUser.php';
require_once 'insertUser.php';
// OcUser is an object that stores values
require_once 'OcUser.php';

// store returned data here
class ReturnThis {
    public $return = "";
    public $retid = "";
    public $retname = "";
    public $msg = "";
}

// set up a json object to be returned to javascript
$returnData = new ReturnThis();

// set up a class object to store the user fields
$myUser = new OcUser();

$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : "";

if ($contentType === "") {
    setup_err("Content type not set on SERVER param");
    return false;
}

if (!($contentType === "application/json")) {
    setup_err("Content type not json");
    return false;
}

// What could possibly go wrong with file_get_contents?
// What a shitty way of transferring data to and from
// different programming languages.
$stuff = trim(file_get_contents("php://input"));

// I am handling failure of json_decode as per php manual
// php.net/manual/en/function.json-last-error.php
// so fuck you if you don't like the format of it.
// Also note that the ', true)' thing is to force
// json_decode to actually decode into a json object.
$jsonIn = json_decode($stuff, true);

if (json_last_error() === JSON_ERROR_NONE) {
    // continue
} else {
    setup_err("Php failed json_decode=" . json_last_error());
    return false;
}

if (is_null($jsonIn)) {
    setup_err("Php sees nothing to work on (data is null)");
    return false;
}

// return 'ok' or text of what went wrong
$msg = "";

if (sanitizeUser($myUser, $msg, $jsonIn)) {
    // continue
} else {
    setup_err($msg);
    return false;
}

// Below is going to be returned by the write of the user.
$msg = "";

// insertUser actually does the sql write.
// We have three conditions here.
// - Successful write, 
// - unsuccessful write, user exists
// - something went wrong (probably connection, sql)
//      pass what went wrong back in $name
// $name, $retcode are passed by reference.
if (insertUser($myUser, $msg) === true) {
    if ($msg === 'ok') {
        $returnData->return = "ok";
        $returnData->retname = "New user created";
    } else {
        $returnData->return = "ok";
        $returnData->retname = "doesn't exist";
    }
// What could possibly go wrong with 'echo'?
// What a shitty way of transferring data to and from
// different programming languages.
    echo json_encode($returnData);
} else {
    // if insertUser had prob, prob will return in $msg
    setup_err($msg);
}

// done
return true;

// This should really be called setup_err_return_json,
// but that's really long.
// I also don't like using global, but in this
// context I think it's all right.
function setup_err($err_msg) {

    global $returnData;

    error_log($err_msg);
    $returnData->return = "err";
    $returnData->msg = $err_msg;
    echo json_encode($returnData);

}
