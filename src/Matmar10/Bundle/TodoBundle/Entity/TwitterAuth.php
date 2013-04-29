<?php

namespace Matmar10\Bundle\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="twitter_auth")
 */
class TwitterAuth
{

    const UUID_FORMAT = '%04x%04x-%04x-%04x-%04x-%04x%04x%04x';

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

    /**
     * @ORM\Column(type="string", length=36, nullable=true)
     */
    protected $internalToken;


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

    public static function generateUuid()
    {
        return sprintf( self::UUID_FORMAT,
            // 32 bits for "time_low"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            // 16 bits for "time_mid"
            mt_rand( 0, 0xffff ),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand( 0, 0x0fff ) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand( 0, 0x3fff ) | 0x8000,

            // 48 bits for "node"
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }

    public function setInternalToken($internalToken)
    {
        $this->internalToken = $internalToken;
    }

    public function getInternalToken()
    {
        return $this->internalToken;
    }
}
