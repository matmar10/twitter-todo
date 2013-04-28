<?php

namespace Matmar10\Bundle\TodoBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityNotFoundException;
use FOS\UserBundle\Doctrine\UserManager;
use Guzzle\Http\Client;
use Guzzle\Http\QueryString;
use Guzzle\Plugin\Oauth\OauthPlugin;

class AccountService
{

    protected static $userManager;
    protected static $doctrineRegistry;

    public function __construct(UserManager $userManager, Registry $doctrineRegistry)
    {
        self::$userManager = $userManager;
        self::$doctrineRegistry = $doctrineRegistry;
    }

    public function lookupTwitterScreeName($twitterScreenName)
    {

    }

    public function createNewAccount($twitterId, $twitterScreenName, $twitterAuth)
    {

    }
}
