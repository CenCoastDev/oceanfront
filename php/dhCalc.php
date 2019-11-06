<?php
/**
 *  dhCalc.php
 * 
 *  @author Mark Whitcomb
 *  @copyright 7/31/2019
 * 
 *  Total rewrite because the javascript is using fetch
 *  instead of ajax.
 * 
 * NOTE - As of 10/9/2019, I have left in backdoor on Bob's
 * number which will allow a decimal place in the number.
 * This should log an error when it tries gmp_int, saying 
 * 'not an int'.
 */

 // I'm basing my whole assumption on this value.
 // I guess that's all right because I know who's calling me.
 // Or do I?  What if someone calls this with other stuff in body?
 $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : "";

 // Define in functions as Global
 $errMsg = "";

 $outData = array (
     'ret_code' => '',
     'return2' => '',
     'return3' => '',
     'return4' => '',
     'return5' => '',
     'return6' => ''
 );

 // TODO set err, echo out
 if ($contentType === "") {
     error_log("Content type not set on SERVER param");
     $outData['ret_code'] = "err";
     $outData['return2'] = "Content type not set on Server param";
     echo json_encode($outData);
     exit;
 }

 if ($contentType === "application/json") {
     
    // Below is the holy grail.  
    // This gets the actual post body in json form.
    $content = trim(file_get_contents("php://input"));
    $decoded = json_decode($content, true);

     // This is bass-ackward to the syntax I'm used to.
     global $errMsg;

     $rawData = array (
         "base_g_raw" => "",
         "mod_p_size_raw" => "",
         "a_secret_raw" => "",
         "b_secret_raw" => ""
     );

     $inData = array (
        'base_g' => 0,
        'mod_p_size' => 0,
        'a_secret' => 0,
        'b_secret' => 0
     );

     getPostBody($decoded, $rawData);

     // Validate the raw fields, 
     // return sanitized fields in second param,
     // return boolean if successful
     if (!validateAndRetFields($rawData, $inData)) {
         $outData['ret_code'] = 'err';
         $outData['return2'] = $errMsg;
         echo json_encode($outData);
         exit;
     }

     // Need some kind of error testing here?
     calcDH ($outData, $inData);

     echo json_encode($outData);
     
 }

 function calcDH (&$outData, &$inData) {

    // Used everywhere.
    global $errMsg;

    // I'm going to ASSUME everything is good to go by now.

    // An intermediate step variable
    $gmp_inter = gmp_init(0);
    $gmp_mod_p = gmp_init(0);
    $gmp_a_publ = gmp_init(0);
    $gmp_b_publ = gmp_init(0);
    $gmp_common1 = gmp_init(0);
    $gmp_common2 = gmp_init(0);

    try {
        // Below should throw errors if bad data
        // Maybe not, since 12.34 throws warning not error(?)
        $gmp_base = gmp_init($inData['base_g']);
        $gmp_a_secret = gmp_init($inData['a_secret']);
        $gmp_b_secret = gmp_init($inData['b_secret']);

        // First get some random bits of a really big size 
        // (well, the size of mod_p_size in bits)
        $gmp_inter = gmp_random_bits(($inData['mod_p_size']));

        // Then get the next prime closest to this number
        $gmp_mod_p = gmp_nextprime($gmp_inter);
        $outData['return2'] = gmp_strval($gmp_mod_p);

        // Now use the prime as the mod n
        // as in base pow (alice's secret nbr) mod n
        $gmp_a_publ = gmp_powm($gmp_base, $gmp_a_secret, $gmp_mod_p);
        $outData['return3'] = gmp_strval($gmp_a_publ);

        // Calc bob's secret number
        $gmp_b_publ = gmp_powm($gmp_base, $gmp_b_secret, $gmp_mod_p);
        $outData['return4'] = gmp_strval($gmp_b_publ);
        
        // Do the math to get the shared secret number
        $gmp_common1 = gmp_powm($gmp_b_publ, $gmp_a_secret, $gmp_mod_p);
        $outData['return5'] = gmp_strval($gmp_common1);
        
        // This should equal the number above.
        $gmp_common2 = gmp_powm($gmp_a_publ, $gmp_b_secret, $gmp_mod_p);
        $outData['return6'] = gmp_strval($gmp_common2);

    } catch (Exception $e) {
        error_log("Caught exception in gmp, ex=" . $e -> getMessage());
        $outData['ret_code'] = 'err';
        // If returnN has a value I got to there. Oh well.
        $outData['return2'] = "Error in dh calc, gmp";
        $outData['return3'] = $e -> getMessage();
        return;
    }

    $outData['ret_code'] = 'ok';

 }

 function getPostBody($decoded, &$rawData) {

    // Used everywhere.
    global $errMsg;

    if (is_array($decoded)) {
        foreach ($decoded as $key => $value) {
            switch ($key) {
                case "base_g":
                    $rawData['base_g_raw'] = $value;
                    break;
                case "mod_p_size":
                    $rawData['mod_p_size_raw'] = $value;
                    break;
                case "a_secret":
                    $rawData['a_secret_raw'] = $value;
                    break;
                case "b_secret":
                    $rawData['b_secret_raw'] = $value;
                    break;
                default:
                // something's fishy,
                // but continue on.
                    error_log("Unexpected data from post, key=" . $key . " val=" . $value);
            }
        }
    }
 }

 /**
  * This checks data in and returns cleaned values.
  *
  * Note that it's possible that all fields are 0
  * although the front end was supposed to check for that.
  *
  * @param fields in and fields out, by reference
  * @return a boolean that says whether data is ok
  */
  // TODO - Get rid of negative or floats in numbers.
 function validateAndRetFields(&$rawData, &$inData) {

    // Used everywhere.
    global $errMsg;

    $base_g = preg_replace('/[^0-9]/', '', $rawData['base_g_raw']);
    if (empty($base_g)) {$base_g = 0;}
    // explicitly cast to a number.
    $base_g = (int) $base_g;

    $mod_p_size = preg_replace('/[^0-9]/', '', $rawData['mod_p_size_raw']);
    if (empty($mod_p_size)) {$mod_p_size = 0;}
    $mod_p_size = (int) $mod_p_size;

    if (!($base_g === 3 ||
          $base_g === 5 ||
          $base_g === 7)) {
            $errMsg = "Base g not 3, 5 or 7 is =" . $base_g;
            return false;
    }

    // Below should be impossible since I've thrown out
    // the negative sign.
    if ($mod_p_size < 0) {
        $errMsg = "Mod p size can't be negative";
        return false;
    }

    if ($mod_p_size > 4096) {
        $errMsg = "Mod p size can't be > 4096";
        return false;
    }

    // Throw away leading, trailing spaces
    $temp = trim($rawData['a_secret_raw']);
    // Trim to 64 chars
    $temp = substr($temp, 0, 64);
    // Replace all not-numbers with null
    $temp = preg_replace('/[^0-9]/', '', $temp);

    if (empty($temp)) {$temp = 0;}

    $a_secret = (int) $temp;

    // TODO Change this to be like a_secret.
    // The only reason I'm leaving this is so I 
    // can test entering a bunch of shit, which 
    // should crash all over the place.
    if (is_numeric($rawData['b_secret_raw'])) {
        $b_secret = $rawData['b_secret_raw'];
        if ($b_secret < 1) {
            $errMsg = "Bobs secret number < 1, is=" . $b_secret;
            return false;
        }
    } else {
        $errMsg = "Bobs secret number not numeric ". $rawData['b_secret_raw'];
        return false;
    }

    $inData['base_g'] = $base_g;
    $inData['mod_p_size'] = $mod_p_size;
    $inData['a_secret'] = $a_secret;
    $inData['b_secret'] = $b_secret;

    return true;
 }

 ?>