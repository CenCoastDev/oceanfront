<?php
/**
 * getParams.php
 *
 * Get the datatbase connection parameters from a file.
 * 
 * @author Mark Whitcomb
 * @copyright 9/19/2019
 *
 */
 declare (strict_types=1);

 // My connection parameters object (or you can call it a 'class').
 require_once 'DbParams.php';

 function getParams() {

    // php built-in function to read a file, return an array
    $var_arr = parse_ini_file("../halyard/dbconnect.config");

    $host = $var_arr['host'];
    $user = $var_arr['user'];
    $dbname = $var_arr['database'];
    $userpass = $var_arr['password'];

    $theParams = new DbParams();

    $theParams->setHost($host);
    $theParams->setUser($user);
    $theParams->setDbName($dbname);
    $theParams->setPass($userpass);

    return $theParams;
}
