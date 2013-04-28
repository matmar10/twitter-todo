<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

class LoginController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        return array(
            'menuItems' => array(
                'homepage' => 'Home',
                'login' => 'Login',
            )
        );
    }

    /**
     * @Route("/login/authenticate-with-twitter", name="login_attempt_twitter")
     */
    public function attemptTwitterLoginAction()
    {
        $redirectBase = $this->getRequest()->getHost();
        $redirectUri = $redirectBase . $this->get('router')->generate('login_check');

        $twitterAuthService = $this->get('matmar10_todo.twitter_auth_service');
        $twitterAuthUrl = $twitterAuthService->buildAuthenticateRedirectUrl($redirectUri);
        return new RedirectResponse($twitterAuthUrl);
    }

    /**
     * @Route("/login/check-twitter-authentication", name="login_check")
     * @Template()
     */
    public function checkLoginAction()
    {

        $twitterAuthService = $this->get('matmar10_todo.twitter_auth_service');

        $requestQueryParams = $this->getRequest()->query;
        $oauthToken = $requestQueryParams->get('oauth_token');
        $oauthVerifier = $requestQueryParams->get('oauth_verifier');

        $oauthResult = $twitterAuthService->processAuthCallback($oauthToken, $oauthVerifier);
        if(false === $oauthResult) {
            return $this->redirect($this->generateUrl('login_error'));
        }

        return $this->redirect($this->generateUrl('welcome', array(
            'username' => $oauthResult->get('screen_name'),
        )));
    }

    /**
     * @Route("/login/error", name="login_error")
     * @Template()
     */
    public function loginErrorAction()
    {
        return array();
    }
}
