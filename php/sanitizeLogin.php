<?php
/**
 * sanitizeLogin.php
 * 
 * @author Mark Whitcomb
 * @copyright 9/26/2019
 * 
 * Sanitize data passed in through the login screen.
 * 
 * If called with an invalid type, return an error.
 * If data in is not clean, will either return false
 * or will return a sanitized string.
 * 
 * I TRIED using php's FILTER_SANITIZE_STRING, but it merrily
 * passed on <alt+8><alt+8>&#1697; and other strings.
 * I am going to actively write my own.
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
  function sanitizeThis($textIn, $whichOne, $maxLen, &$textOut) {

    $isClean = false;

    if (is_null($textIn)) {
        $textOut = "";
        return false;
    }

    $localText = trim($textIn);

    $len = strlen($localText);

    if ($len <= 0) {
        $textOut = "";
        return false;
    }

    // This should trim any text in to my fixed size.
    if ($len > $maxLen) {
        $localText = substr($localText, 0, $maxLen);
    }

    switch ($whichOne) {
        case "user":
            $isClean = cleanUser($localText, $textOut);
            break;
        case "pass":
            $isClean = cleanPassword($localText, $textOut);
            break;
        default:
        // It's already set to false, but I 
        // want to explicitly show that it's false.
            $textOut = "";
            return false;
    }

    // $textOut should be set by now.
    // return the bool of $isClean.
    return $isClean;
 }

 /**
  * Clean the user ID
  *
  * @param string $textIn string in to be cleaned
  * @param string $return string after regexp'd
  * @return bool          in this case, always true
  */
 function cleanUser($textIn, &$return) {

    // Allow a-z upper/lower, numbers, dash, underscore
    $checkedTxt = preg_replace("/[^A-Za-z0-9-_]/", "", $textIn);

    // invalid characters will err.  No exceptions.
    if ($textIn === $checkedTxt) {
        $return = $checkedTxt;
        return true;
    } else {
        $return = $textIn;
        return false;
    }

 }
 
 /**
  * Clean the password
  *
  * @param string $textIn string in to be cleaned
  * @param string $return same as string in
  * @return bool          true if no invalid chars
  *                       false if invalid chars
  */
  function cleanPassword($textIn, &$return) {

    // If you enter some special chars you're fine.
    // Ok, what's not allowed? '^[]{},.?/\|`;:' and single, double quote.
    // Note that the '+' is escaped in pattern below and it allows space '\s'
    // as long as it's not leading or trailing.

    $checkedTxt = preg_replace("/[^A-Za-z0-9~!@#$%&*()-_\+=<>\s]/", "", $textIn);

    // In this case I will error if I have values I don't allow.
    // Since it's a password, the user has to know exactly what's 
    // being stored.  I can't screw with the data.
    if ($textIn === $checkedTxt) {
        $return = $checkedTxt;
        return true;
    } else {
        $return = $textIn;
        return false;
    }

 }
