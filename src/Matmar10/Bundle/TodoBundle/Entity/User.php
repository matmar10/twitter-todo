<?php

namespace Matmar10\Bundle\TodoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="Matmar10\Bundle\TodoBundle\Entity\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements UserInterface /*, Serializable */
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    protected $salt;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    protected $password;

    /**
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $twitterId;

    /**
     * @ORM\Column(type="string", length=20, unique=true, nullable=false)
     */
    protected $twitterScreenName;

    /**
     * @ORM\OneToOne(targetEntity="TwitterAuth", cascade={"all"}, fetch="EAGER")
     * @ORM\JoinColumn(name="twitter_auth_id", referencedColumnName="id")
     */
    protected $twitterAuth;

    public function __construct()
    {
        $this->isActive = true;
        $this->salt = md5(uniqid(null, true));
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    public function getSalt()
    {
        return $this->salt;
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
        $this->twitterScreenName = $username;
    }

    public function getUsername()
    {
        return $this->twitterScreenName;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_AUTHENTICATED_USER');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
        $this->twitterAuth = null;
    }

    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->twitterScreenName !== $user->getUsername()) {
            return false;
        }

        return true;
    }
}
