<?php

namespace Matmar10\Bundle\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * ORM\Column(type="string", length=32, unique=true, nullable=false)
     */
    protected $username;

    /**
     * ORM\Column(type="string", length=20, unique=true, nullable=false)
     */
    protected $twitterId;

    /**
     * ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $twitterScreenName;

    /**
     * @ORM\OneToOne(targetEntity="TwitterAuth")
     * @ORM\JoinColumn(name="twitter_auth_id", referencedColumnName="id")
     */
    protected $twitterAuth;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTwitterAuth($twitterAuth)
    {
        $this->twitterAuth = $twitterAuth;
    }

    public function getTwitterAuth()
    {
        return $this->twitterAuth;
    }

    public function setTwitterId($twitterId)
    {
        $this->twitterId = $twitterId;
    }

    public function getTwitterId()
    {
        return $this->twitterId;
    }

    public function setTwitterScreenName($twitterScreenName)
    {
        $this->twitterScreenName = $twitterScreenName;
    }

    public function getTwitterScreenName()
    {
        return $this->twitterScreenName;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }
}
