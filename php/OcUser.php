<?php
/**
 * OcUser.php
 * 
 * @author Mark Whitcomb
 * @copyright 11/7/2019
 * 
 * This is the user.  It corresponds to the database table
 * by the same name.
 * 
 * Why didn't I just call it User?  
 * 
 * Because, that's been used to death.  It's too close to every and
 * all reserved words that are close to 'user'.
 * 
 * Why OcUser?  
 * Because it's shorter than OceanArizPropUser.
 */
class OcUser
{
    private $user;
    private $pass;
    private $first;
    private $last;
    private $email;
    private $street;
    private $city;
    private $state;
    private $zip;
    private $phone;

    public function __construct() {
        $this->user = "";
        $this->pass = "";
        $this->first = "";
        $this->last = "";
        $this->email = "";
        $this->street = "";
        $this->city = "";
        $this->state = "";
        $this->zip = "";
        $this->phone = "";
    }

/* -------------getters------------- */    
    public function getUser(): string
    {
        return $this->user;
    }
    public function getPass(): string
    {
        return $this->pass;
    }
    public function getFirst(): string
    {
        return $this->first;
    }
    public function getLast(): string
    {
        return $this->last;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getStreet(): string
    {
        return $this->street;
    }
    public function getCity(): string
    {
        return $this->city;
    }
    public function getState(): string
    {
        return $this->state;
    }
    public function getZip(): string
    {
        return $this->zip;
    }
    public function getPhone(): string
    {
        return $this->phone;
    }

/* -------------setters------------- */    
    public function setUser($user)
    {
        $this->user = $user;
    }
    public function setPass($pass)
    {
        $this->pass = $pass;
    }
    public function setFirst($first)
    {
        $this->first = $first;
    }
    public function setLast($last)
    {
        $this->last = $last;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
    public function setStreet($street)
    {
        $this->street = $street;
    }
    public function setCity($city)
    {
        $this->city = $city;
    }
    public function setState($state)
    {
        $this->state = $state;
    }
    public function setZip($zip)
    {
        $this->zip = $zip;
    }
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}