<?php

namespace Matmar10\Bundle\Todobundle\Security\Firewall;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AccessDeniedListener
{
    protected static $router;

    public function __construct($router)
    {
        self::$router = $router;
    }

    public function onAccessDeniedException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();

        if(get_class($exception) === 'Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException') {
            $redirectUri = self::$router->generate('login');
            $response = new RedirectResponse($redirectUri);
            $event->setResponse($response);
        }

        return $event;
    }
}
