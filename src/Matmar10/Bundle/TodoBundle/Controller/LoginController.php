<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Matmar10\Bundle\TodoBundle\Entity\TwitterAuth;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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

        $twitterAuthService = $this->get('matmar10_todo.webservice_user_provider');
        $twitterAuthUrl = $twitterAuthService->buildAuthenticateRedirectUrl($redirectUri);
        return new RedirectResponse($twitterAuthUrl);
    }

    /**
     * @Route("/login/check-twitter-authentication", name="login_check")
     * @Template()
     */
    public function loginCheckAction()
    {
        $query = $this->getRequest()->query;

        $oauthToken = $query->get('oauth_token');
        $oathVerifier = $query->get('oauth_verifier');

        $twitterAuthService = $this->get('matmar10_todo.webservice_user_provider');
        $user = $twitterAuthService->processAuthCallback($oauthToken, $oathVerifier);

        $homeUri = $this->get('router')->generate('homepage');
        $response = new RedirectResponse($homeUri);

        $xAuthToken = $user->getTwitterAuth()->getInternalToken();

        $response->headers->set('X-Authentication', $xAuthToken); // for convenient access

        // this will get picked up in the auth listener on subsequent requests
        $response->headers->setCookie(new Cookie('X-Authentication', $xAuthToken));
        return $response;
    }


    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

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
