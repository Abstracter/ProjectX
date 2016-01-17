<?php

// src/RegBundle/Entity/User.php
namespace RegBundle\Entity;

class User
{
    protected $User;

    protected $Pass;

    protected $Info;
    
    protected $Prenume;
    
    protected $Nume;
    
    protected $Email;
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $Username;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->Username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->Username;
    }

    /**
     * Set pass
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->Pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->Pass;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return User
     */
    public function setInfo($info)
    {
        $this->Info = $info;

        return $this;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->Info;
    }

    /**
     * Set nume
     *
     * @param string $nume
     *
     * @return User
     */
    public function setNume($nume)
    {
        $this->Nume = $nume;

        return $this;
    }

    /**
     * Get nume
     *
     * @return string
     */
    public function getNume()
    {
        return $this->Nume;
    }

    /**
     * Set prenume
     *
     * @param string $prenume
     *
     * @return User
     */
    public function setPrenume($prenume)
    {
        $this->Prenume = $prenume;

        return $this;
    }

    /**
     * Get prenume
     *
     * @return string
     */
    public function getPrenume()
    {
        return $this->Prenume;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->Email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->Email;
    }
}
