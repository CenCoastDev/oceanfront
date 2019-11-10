<?php
/**
 * sanitizeUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 11/8/2019
 * 
 * Sanitize data passed in through the login screen.
 * 
 * If called with an invalid type, return an error.
 * If data in is not clean, will either return false
 * or will return a sanitized string.
 * 
 */
  declare (strict_types=1);

  /**
   * sanitize a string in depending on which type
   * this also truncs the data in regardless of whether
   * it's valid or not.
   * 
   * @param  string  $textIn   string passed in
   * @param  string  $whichOne which string is to be sanitized
   * @param  int     $maxLen   strip and trim the string in to a specific length
   * @param  string  $return   returned string, cleaned up
   * @return bool              true if string is ok, false if problem
   */
 function sanitizeUser(OcUser $myUser, &$returnData, $data) {

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
            $firstIn = filter_var($firstIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have first in it");
            return false;
        }
        if (array_key_exists("last", $data)) {
            $lastIn = $data["last"];
            $lastIn = filter_var($lastIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have last in it");
            return false;
        }
        if (array_key_exists("email", $data)) {
            $emailIn = $data["email"];
            $emailIn = filter_var($emailIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have email in it");
            return false;
        }
        if (array_key_exists("street", $data)) {
            $streetIn = $data["street"];
            $streetIn = filter_var($streetIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have street in it");
            return false;
        }
        if (array_key_exists("city", $data)) {
            $cityIn = $data["city"];
            $cityIn = filter_var($cityIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have city in it");
            return false;
        }
        if (array_key_exists("state", $data)) {
            $stateIn = $data["state"];
            $stateIn = filter_var($stateIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have state in it");
            return false;
        }
        if (array_key_exists("zip", $data)) {
            $zipIn = $data["zip"];
            $zipIn = filter_var($zipIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            setup_err("js array doesn't have zip in it");
            return false;
        }
        if (array_key_exists("phone", $data)) {
            $phoneIn = $data["phone"];
            $phoneIn = filter_var($phoneIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH,
                                            FILTER_FLAG_STRIP_LOW);
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
        $myUser->setUser($user);
    } else {
        // Funny - if I have a php error it'll stack up on the
        // return and send both the text string (html) of the
        // php error and my json I'm building here back to the
        // calling javascript program.
        setup_err("User ID has something in it that we don't like");
        return false;
    }

    if (sanitizeThis($passIn, 'pass', SIZEOF_PASSWORD, $pass)) {
        $myUser->setPass($pass);
    } else {
        setup_err("Password has something in it that we don't like");
        return false;
    }

    $myUser->setFirst($firstIn);
    $myUser->setLast($lastIn);
    $myUser->setEmail($emailIn);
    $myUser->setStreet($streetIn);
    $myUser->setCity($cityIn);
    $myUser->setState($stateIn);
    $myUser->setZip($zipIn);
    $myUser->setPhone($phoneIn);
    
}
