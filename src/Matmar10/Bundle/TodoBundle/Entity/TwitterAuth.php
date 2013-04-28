<?php

namespace Matmar10\Bundle\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="twitter_auth")
 */
class TwitterAuth
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $oauthToken;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $oauthTokenSecret;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $oauthVerifier;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
    }

    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    public function setOauthVerifier($oauthVerifier)
    {
        $this->oauthVerifier = $oauthVerifier;
    }

    public function getOauthVerifier()
    {
        return $this->oauthVerifier;
    }

    public function setOauthTokenSecret($oauthTokenSecret)
    {
        $this->oauthTokenSecret = $oauthTokenSecret;
    }

    public function getOauthTokenSecret()
    {
        return $this->oauthTokenSecret;
    }

}
