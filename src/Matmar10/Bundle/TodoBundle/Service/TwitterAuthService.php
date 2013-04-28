<?php

namespace Matmar10\Bundle\TodoBundle\Service;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityNotFoundException;
use FOS\UserBundle\Doctrine\UserManager;
use Guzzle\Http\Client;
use Guzzle\Http\QueryString;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Matmar10\Bundle\TodoBundle\Entity\TwitterAuth;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * @see https://dev.twitter.com/docs/auth/implementing-sign-twitter
 */
class TwitterAuthService
{

    protected static $userManager;

    protected static $doctrineRegistry;

    protected static $twitterAuthUri;

    public function __construct(
        Registry $doctrineRegistry,
        $twitterAuthenticateUri = 'https://api.twitter.com/oauth/authenticate'
    )
    {
        self::$doctrineRegistry = $doctrineRegistry;
        self::$twitterAuthUri = $twitterAuthenticateUri;
    }

    public function processAuthCallback($oauthToken, $oauthVerifier)
    {
        try {
            $twitterAuth = $this->lookupByOauthToken($oauthToken);
        } catch(EntityNotFoundException $e) {
            return false;
        }

        $twitterAuth->setOauthVerifier($oauthVerifier);

        $em = $this->getManager($twitterAuth);
        $em->merge($twitterAuth);
        $em->flush();

        return $this->generateAccessToken($twitterAuth);
    }

    public function buildAuthenticateRedirectUrl($redirectUri)
    {
        $oauthToken = $this->createRequestToken($redirectUri);
        return self::$twitterAuthUri . '?oauth_token=' . $oauthToken;
    }

    protected function lookupByOauthToken($oauthToken)
    {
        $registry = self::$doctrineRegistry->getRepository('Matmar10TodoBundle:TwitterAuth');
        $twitterAuth = $registry->findOneByOauthToken($oauthToken);

        return $twitterAuth;
    }


    protected function generateAccessToken(TwitterAuth $twitterAuth)
    {

        $client = new Client('https://api.twitter.com');

        // TODO: these are just for dev and must be moved out into config
        $oauth = new OauthPlugin(array(
            'consumer_key'    => 'vdppViIZVmHZdFQaS4CzQ',
            'consumer_secret' => 'UnNv6fRqTpvxX3Jv7z8sNWtLkkgGV40165ekgVzsTo',
            'token' => $twitterAuth->getOauthToken(),
        ));

        $client->addSubscriber($oauth);

        $response = $client->post('/oauth/access_token')
            ->addPostFields(array(
                'oauth_verifier' => $twitterAuth->getOauthVerifier(),
            ))->send();
        $responseCode = $response->getStatusCode();
        if(200 !== $responseCode) {
            throw new RuntimeException("Request for Twitter Oauth Request Token failed with response code " . $responseCode . " (response code 200 expected).");
        }

        $responseString = $response->getBody(true);
        $responseParams = QueryString::fromString($responseString);

        return $responseParams;
    }

    /**
     * Step 1: Obtaining a request token
     *
     * @see https://dev.twitter.com/docs/auth/implementing-sign-twitter
     *
     * @param $redirectToRouteId string Requests
     * @return string
     */
    protected function createRequestToken($redirectUri)
    {

        $client = new Client('https://api.twitter.com');

        $oauth = new OauthPlugin(array(
            'consumer_key'    => 'vdppViIZVmHZdFQaS4CzQ',
            'consumer_secret' => 'UnNv6fRqTpvxX3Jv7z8sNWtLkkgGV40165ekgVzsTo',
            'callback' => $redirectUri,
        ));
        $client->addSubscriber($oauth);

        $response = $client->post('/oauth/request_token')->send();
        $responseCode = $response->getStatusCode();
        if(200 !== $responseCode) {
            throw new RuntimeException("Request for Twitter Oauth Request Token failed with response code " . $responseCode . " (response code 200 expected).");
        }

        $responseString = $response->getBody(true);
        $responseParams = QueryString::fromString($responseString);

        $oauthCallbackConfirmed = json_decode($responseParams->get('oauth_callback_confirmed')); // twitter returns string 'true'
        if(!$oauthCallbackConfirmed) {
            throw new RuntimeException("Request for Twitter Oauth Request Token failed: Twitter did not confirm that Oauth Callback was confirmed.");
        }


        $twitterAuth = new TwitterAuth();
        $twitterAuth->setOauthToken($responseParams->get('oauth_token'));
        $twitterAuth->setOauthTokenSecret($responseParams->get('oauth_token_secret'));

        $em = $this->getManager($twitterAuth);
        $em->persist($twitterAuth);
        $em->flush();

        return $twitterAuth->getOauthToken();
    }

    protected function getManager($entity)
    {
        return self::$doctrineRegistry->getManagerForClass(get_class($entity));
    }
}
