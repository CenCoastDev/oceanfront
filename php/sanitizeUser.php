<?php
/**
 * sanitizeUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 11/8/2019
 * 
 * Sanitize data passed in through the login screen.
 * 
 * If data in is not clean, will either return false
 * or will return a sanitized string.
 * 
 */
  declare (strict_types=1);
  include_once 'loginConstants.php';
  include_once 'userConstants.php';

  /**
   * @param  OcUser  $myuser     store the sanitized fields
   * @param  array   $msg        msg if err, nothing if ok
   * @param  array   $data       the json array of fields in
   * @return bool    true/false  true if all is ok, false if problem
   */
 function sanitizeUser(OcUser &$myUser, &$msg, $data) {

    // temp fields
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
            if (sanitizeThis($userIn, 'user', SIZEOF_USER, $user)) {
                // below will put clean value in object and return variable
            } else {
                $msg = "User ID has something in it that we don't like";
                return false;
            }
        } else {
            $msg = "js array doesn't have userid in it";
            return false;
        }
        if (array_key_exists("pass", $data)) {
            $passIn = $data["pass"];
            if (sanitizeThis($passIn, 'pass', SIZEOF_PASSWORD, $pass)) {
                // below will put clean value in object
            } else {
                $msg = "Password has something in it that we don't like";
                return false;
            }
        } else {
            $msg = "js array doesn't have pass in it";
            return false;
        }
        if (array_key_exists("first", $data)) {
            $firstIn = substr($data["first"], 0, SIZEOF_FIRST);
            $firstIn = filter_var($firstIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have first in it";
            return false;
        }
        if (array_key_exists("last", $data)) {
            $lastIn = substr($data["last"], 0, SIZEOF_LAST);
            $lastIn = filter_var($lastIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have last in it";
            return false;
        }
        if (array_key_exists("email", $data)) {
            $emailIn = substr($data["email"], 0, SIZEOF_EMAIL);
            $emailIn = filter_var($emailIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have email in it";
            return false;
        }
        if (array_key_exists("street", $data)) {
            $streetIn = substr($data["street"], 0, SIZEOF_STREET);
            $streetIn = filter_var($streetIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have street in it";
            return false;
        }
        if (array_key_exists("city", $data)) {
            $cityIn = substr($data["city"], 0, SIZEOF_CITY);
            $cityIn = filter_var($cityIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have city in it";
            return false;
        }
        if (array_key_exists("state", $data)) {
            $stateIn = substr($data["state"], 0, SIZEOF_STATE);
            $stateIn = filter_var($stateIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have state in it";
            return false;
        }
        if (array_key_exists("zip", $data)) {
            $zipIn = substr($data["zip"], 0, SIZEOF_ZIP);
            $zipIn = filter_var($zipIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have zip in it";
            return false;
        }
        if (array_key_exists("phone", $data)) {
            $phoneIn = substr($data["phone"], 0, SIZEOF_PHONE);
            $phoneIn = filter_var($phoneIn, FILTER_SANITIZE_STRING,
                                            FILTER_FLAG_STRIP_HIGH |
                                            FILTER_FLAG_STRIP_LOW);
        } else {
            $msg = "js array doesn't have phone in it";
            return false;
        }
    } else {
        $msg = "data from js not an array";
        return false;
    }

    $myUser->setUser($user);
    $myUser->setPass($pass);
    $myUser->setFirst($firstIn);
    $myUser->setLast($lastIn);
    $myUser->setEmail($emailIn);
    $myUser->setStreet($streetIn);
    $myUser->setCity($cityIn);
    $myUser->setState($stateIn);
    $myUser->setZip($zipIn);
    $myUser->setPhone($phoneIn);
    
    $msg = "ok";
    return true;
}
