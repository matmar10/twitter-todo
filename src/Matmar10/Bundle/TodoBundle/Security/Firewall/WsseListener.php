<?php

namespace Matmar10\Bundle\TodoBundle\Security\Firewall;

use Matmar10\Bundle\TodoBundle\Security\Authentication\Token\WsseUserToken;
use Matmar10\Bundle\TodoBundle\Service\TwitterAuthService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;

class WsseListener implements ListenerInterface
{
    protected $securityContext;
    protected $authenticationManager;
    protected $twiterAuthService;
    protected $userProvider;

    public function __construct(
        SecurityContextInterface $securityContext,
        AuthenticationManagerInterface $authenticationManager,
        $userProvider
    )
    {
        $this->securityContext = $securityContext;
        $this->authenticationManager = $authenticationManager;
        $this->userProvider = $userProvider;
    }

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if(!$request->headers->has('X-Authentication')) {
            if(!$request->cookies->has('X-Authentication')) {
                return;
            }
            $xAuthentication = $request->cookies->get('X-Authentication');
        } else {
            $xAuthentication = $request->headers->get('X-Authentication');
        }


        try {
            $user = $this->userProvider->loadUserFromXAuthentication($xAuthentication);
        } catch(UsernameNotFoundException $e) {
            return;
        }

        $token = new WsseUserToken(array('ROLE_AUTHENTICATED_USER'));
        $token->setUser($user);

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->securityContext->setToken($authToken);

        } catch (AuthenticationException $failed) {

            // TODO: log something here

            // To deny the authentication clear the token. This will redirect to the login page.
            // $this->securityContext->setToken(null);
            // return;

            // Deny authentication with a '403 Forbidden' HTTP response
            $response = new Response();
            $response->setStatusCode(403);
            $event->setResponse($response);

        }
    }
}