<?php
/**
 * fetchUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 9/28/2019
 * 
 * This will actually do the sql fetch.
 * 
 */
declare (strict_types=1);

// DBParams is an object that stores values
require_once 'DbParams.php';
// getPrams just gets db connect parameters
require_once 'getParams.php';

/**
 * do the sql select
 * 
 * @param string $user select from table where = $user
 * @param string $name return name of user if retcode ok else msg
 * @param string $retcode return values 'ok', 'not', 'err'
 *                  ok if user exists
 *                  not if user doesn't exist
 *                  err if sql error
 * @return bool true/false false if err, else true
 */
function fetchUser ($user, &$name, &$retcode) {

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
        $name = "Err on PDO declaration";
        $retcode = "err";
        return false;
    }

    $first = "";

    try {
        $stmt = $pdo->prepare("select first from user where user = :user");
        $stmt->execute(['user' => $user]);
        $count = $stmt->rowCount();

        if ($count > 0) {
            $row = $stmt->fetch();
            $first = $row['first'];
            $retcode = "ok";
        } else {
            $first = "Doesnt exist";
            $retcode = "not";
        }

    } catch (PDOException $e) {
        // Below 'throw new' was from...I don't know and I don't understand it.
        // throw new PDOException($e->getMessage(), (int)$e->getCode());
        error_log($e->getMessage());
        $name = "Err on prepare or execute";
        $retcode = "err";
        return false;
    } finally {
        // Close database connection.
        // Will this get run if I have a 'return above?
        // Yes, according to my debug.
        $pdo = null;
    }

    $name = $first;

    return true;
}