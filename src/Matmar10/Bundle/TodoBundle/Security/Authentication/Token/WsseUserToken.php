<?php

namespace Matmar10\Bundle\TodoBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use  Matmar10\Bundle\TodoBundle\Entity\TwitterAuth;

class WsseUserToken extends AbstractToken
{

    protected $twitterAuth;

    public function __construct(array $roles = array())
    {
        parent::__construct($roles);

        // If the user has roles, consider it authenticated
        $this->setAuthenticated(count($roles) > 0);
    }

    public function getCredentials()
    {
        return '';
    }
}