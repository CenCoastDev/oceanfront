<?php
/**
 * insertUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 11/7/2019
 * 
 * This will actually do the sql insert.
 * 
 */
declare (strict_types=1);

// DBParams is an object that stores values
require_once ('DbParams.php');
// getPrams just gets db connect parameters
require_once ('getParams.php');

/**
 * do the sql select
 * 
 * @param string $myUser an object with all the user fields in it
 * @param string $name return name of user if retcode ok else msg
 * @param string $retcode return values 'ok', 'not', 'err'
 *                  ok if user exists
 *                  not if user doesn't exist
 *                  err if sql error
 * @return bool true/false false if err, else true
 */
function insertUser (OcUser $myUser, &$retcode) {

    $retcode = "ok";

    $connParams = new DbParams();

    $connParams = getParams();

    $host = $connParams->getHost();
    $db = $connParams->getDbName();
    $dbuser = $connParams->getUser();
    $dbpass = $connParams->getPass();

    $charset = "utf8mb4";

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    // According to phpdelusions.net/pdo, 
    // 'turn exception logging on (bad for production?)',
    // fetch returns an associated array vs other types.
    // attr_emulate_prepares is kinda hard to follow.
    // Turning off means send 'prepare' to mysql
    // then send 'execute' with the values of the 
    // variables.  Two steps.
    // Else (true) the 'execute' has the fully built string.
    // This has interesting effect on where exactly an error
    // is thrown if the sql has a syntax error.
    $options = [
        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false,
    ];

    try {
        $pdo = new PDO($dsn, $dbuser, $dbpass, $options);
    } catch (PDOException $e) {
        error_log($e->getMessage());
        $retcode = "Err on PDO declaration";
        return false;
    }

	// Hash the password.
	// I'm assuming by now that anything that could be checked
	// has been checked.  At some point, you have to say
	// you're done.
	$temp_hashed_and_salted = password_hash($myUser->getPass(), 
	                                        PASSWORD_ARGON2ID);

    try {
        $stmt = $pdo->prepare
        ("insert into user 
          (user, 
          pass,
          email,
          first,
          last,
          street,
          city,
          state,
          zip,
          phone) values 
          (?,?,?,?,?,?,?,?,?,?)");
        
        $stmt->execute([$myUser->getUser(), 
        $temp_hashed_and_salted,
        $myUser->getEmail(),
        $myUser->getFirst(),
        $myUser->getLast(),
        $myUser->getStreet(),
        $myUser->getCity(),
        $myUser->getState(),
        $myUser->getZip(),
        $myUser->getPhone()]);

        $count = $stmt->rowCount();

        if ($count > 0) {
            $retcode = "ok";
        } else {
            $retcode = "not";
        }

    } catch (PDOException $e) {
        // Below 'throw new' was from...I don't know and I don't understand it.
        // throw new PDOException($e->getMessage(), (int)$e->getCode());
        error_log($e->getMessage());
        $retcode = "Err on prepare or execute";
        return false;
    } finally {
        // Close database connection.
        // Will this get run if I have a 'return above?
        // Yes, according to my debug.
        $pdo = null;
    }

    $retcode = "ok";

    return true;
}