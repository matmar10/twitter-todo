<?php

namespace Matmar10\Bundle\TodoBundle\Service;

use Guzzle\Http\Client;
use Guzzle\Http\QueryString;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Matmar10\Bundle\TodoBundle\Security\User\WebserviceUserProvider;
use RuntimeException;

/**
 * @see https://dev.twitter.com/docs/auth/implementing-sign-twitter
 */
class TwitterService
{

    protected static $securityContext;
    protected static $userProvider;

    public function __construct($securityContext, $userProvider)
    {
        self::$securityContext = $securityContext;
        self::$userProvider = $userProvider;
    }

    public function tweet($message, $rawJsonResponse = true)
    {

        $user = self::$securityContext->getToken()->getUser();
        $twitterAuth = self::$userProvider->getTwitterAuthForUser($user);

        $client = new Client('https://api.twitter.com/1.1/');

        // TODO: these are just for dev and must be moved out into config
        $oauth = new OauthPlugin(array(
            'consumer_key'    => 'vdppViIZVmHZdFQaS4CzQ',
            'consumer_secret' => 'UnNv6fRqTpvxX3Jv7z8sNWtLkkgGV40165ekgVzsTo',
            'token' => $twitterAuth->getOauthToken(),
            'token_secret' => $twitterAuth->getOauthTokenSecret(),
        ));

        $client->addSubscriber($oauth);

        $response = $client->post('statuses/update.json')
            ->addPostFields(array(
                'status' => $message,
            ))->send();

        $responseCode = $response->getStatusCode();
        if(200 !== $responseCode) {
            throw new RuntimeException("Tweet failed with response code " . $responseCode . " (response code 200 expected).");
        }

        $responseString = $response->getBody(true);


            if($rawJsonResponse) {
                return $responseString;
            }

        return json_decode($rawJsonResponse);
    }
}
