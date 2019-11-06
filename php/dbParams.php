<?php

class DbParams
{
    private $dbname;
    private $dbhost;
    private $dbuser;
    private $dbpassword;

    public function __construct() {
        $this->dbname = "";
        $this->dbhost = "";
        $this->dbuser = "";
        $this->dbpassword = "";
    }

    public function getDbName(): string
    {
        return $this->dbname;
    }
    public function getHost(): string
    {
        return $this->dbhost;
    }
    public function getUser(): string
    {
        return $this->dbuser;
    }
    public function getPass(): string
    {
        return $this->dbpassword;
    }
    
    public function setDbName($dbname)
    {
        $this->dbname = $dbname;
    }
    public function setHost($dbhost)
    {
        $this->dbhost = $dbhost;
    }
    public function setUser($dbuser)
    {
        $this->dbuser = $dbuser;
    }
    public function setPass($dbpassword)
    {
        $this->dbpassword = $dbpassword;
    }
}