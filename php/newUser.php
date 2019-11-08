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

include ('loginConstants.php');
require_once('sanitizeLogin.php');
require_once('insertUser.php');
// OcUser is an object that stores values
require_once ('OcUser.php');

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

// set up a class object to store the user fields
$myUser = new OcUser();

if (getAndClean()) {
    // continue
} else {
    return false;
}


// Below is going to be returned by the fetch of the user.
$name = "";
$retcode = "";

// insertUser actually does the sql write.
// We have three conditions here.
// - Successful write, 
// - unsuccessful write, user exists
// - something went wrong (probably connection, sql)
//      pass what went wrong back in $name
// $name, $retcode are passed by reference.
if (insertUser($myUser, $name, $retcode) === true) {
    if ($retcode === 'ok') {
        $returnData->return = "ok";
        $returnData->retname = $name;
    } else {
        $returnData->return = "ok";
        $returnData->retname = "doesn't exist";
    }
// What could possibly go wrong with 'echo'?
// What a shitty way of transferring data to and from
// different programming languages.
    echo json_encode($returnData);
} else {
    // if insertUser had prob, prob will return in $name
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

function getAndClean() {

    global $data;
    global $myUser;

    // below came in from screen
    $userIn = "";
    $passIn = "";
    $firstIn = "";
    $lastIn = "";
    $emailIn = "";
    $streetIn = "";
    $cityIn = "";
    $stateIn = "";
    $zipIn = "";
    $phoneIn = "";
    // below are after we wash it thru sanitizeThis
    $user = "";
    $pass = "";

    if (is_array($data)) {
        if (array_key_exists("userid", $data)) {
            $userIn = $data["userid"];
        } else {
            setup_err("js array doesn't have userid in it");
            return false;
        }
        if (array_key_exists("pass", $data)) {
            $passIn = $data["pass"];
        } else {
            setup_err("js array doesn't have pass in it");
            return false;
        }
        if (array_key_exists("first", $data)) {
            $firstIn = $data["first"];
        } else {
            setup_err("js array doesn't have first in it");
            return false;
        }
        if (array_key_exists("last", $data)) {
            $lastIn = $data["last"];
        } else {
            setup_err("js array doesn't have last in it");
            return false;
        }
        if (array_key_exists("email", $data)) {
            $emailIn = $data["email"];
        } else {
            setup_err("js array doesn't have email in it");
            return false;
        }
        if (array_key_exists("street", $data)) {
            $streetIn = $data["street"];
        } else {
            setup_err("js array doesn't have street in it");
            return false;
        }
        if (array_key_exists("city", $data)) {
            $cityIn = $data["city"];
        } else {
            setup_err("js array doesn't have city in it");
            return false;
        }
        if (array_key_exists("state", $data)) {
            $stateIn = $data["state"];
        } else {
            setup_err("js array doesn't have state in it");
            return false;
        }
        if (array_key_exists("zip", $data)) {
            $zipIn = $data["zip"];
        } else {
            setup_err("js array doesn't have zip in it");
            return false;
        }
        if (array_key_exists("phone", $data)) {
            $phoneIn = $data["phone"];
        } else {
            setup_err("js array doesn't have phone in it");
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
        $myUser.setUser($user);
    } else {
        // Funny - if I have a php error it'll stack up on the
        // return and send both the text string (html) of the
        // php error and my json I'm building here back to the
        // calling javascript program.
        setup_err("User ID has something in it that we don't like");
        return false;
    }

    if (sanitizeThis($passIn, 'pass', SIZEOF_PASSWORD, $pass)) {
        $myUser.setPass($pass);
    } else {
        setup_err("Password has something in it that we don't like");
        return false;
    }

}