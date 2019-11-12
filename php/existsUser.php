<?php
/**
 * existsUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 9/19/2019
 * 
 * Read 'user' from database.
 * 
 */
declare (strict_types=1);

include 'loginConstants.php';
require_once 'sanitizeLogin.php';
require_once 'fetchUser.php';

// store returned data here
class JsonData {
    public $return = "";
    public $retid = "";
    public $retname = "";
    public $msg = "";
}

// set up a json object to be returned to javascript
$returnData = new JsonData();

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
$data = json_decode($stuff, true);
if (json_last_error() === JSON_ERROR_NONE) {
    // continue
} else {
    setup_err("Php failed json_decode=" . json_last_error());
    return false;
}

if (is_null($data)) {
    setup_err("Php sees nothing to work on (data is null)");
    return false;
}

// these fields are from screen
$userIn = "";
$pwIn = "";
// these fields are after we wash them 
$user = "";
$pw = "";

if (is_array($data)) {
    if (array_key_exists("userid", $data)) {
        $userIn = $data["userid"];
    } else {
        setup_err("js array doesn't have userid in it");
        return false;
    } 
	if (array_key_exists("pw", $data)) {
		$pwIn = $data["pw"];
	} else {
		setup_err("js array doesn't have pw in it");
		return false;
	}
} else {
    setup_err("data from js not an array");
    return false;
}

// sanitizeThis returns a sanitized $user string, so 
// set the return data if ok.
if (sanitizeThis($userIn, 'user', SIZEOF_USER, $user)) {
    $returnData->retid = $user;
} else {
    // Funny - if I have a php error it'll stack up on the
    // return and send both the text string (html) of the
    // php error and my json I'm building here back to the
    // calling javascript program.
    setup_err("User ID has something in it that we don't like");
    return false;
}

if (sanitizeThis($pwIn, 'pass', SIZEOF_PASSWORD, $pw)) {
	// continue - I should have value in $pw
} else {
	setup_err("Password has something in it that we don't like");
	return false;
}

// Below is going to be returned by the fetch of the user.
$name = "";
$retcode = "";

// fetchUser actually does the sql read.
// We have three conditions here.
// - Successful read, user exists
// - successful read but no data returned
// - something went wrong (probably connection, sql)
//      pass what went wrong back in $name
// How do you tell here that $name, $retcode are passed by reference?
if (fetchUser($user, $name, $retcode, $hashed_pw) === true) {
    if ($retcode === 'ok') {
        $returnData->retname = $name;
    } else {
        $returnData->return = "ok";
        $returnData->retname = "doesn't exist";
    }
	
	if (password_verify($pw, $hashed_pw) {
		$returnData->return = "ok"
	} else {
		$returnData->return = "ng"
		$returnData->retname = "Please try again";
	}

	echo json_encode($returnData);
	
} else {
    // if fetchUser had prob, prob will return in $name
    setup_err($name);
}

// done
return true;

function setup_err($err_msg) {

    global $returnData;

    error_log($err_msg);
    $returnData->return = "err";
    $returnData->msg = $err_msg;
    echo json_encode($returnData);

}