<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        if($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {

        }

        return array();
    }

    /**
     * @Route("/welcome/{username}", name="welcome")
     * @Template()
     */
    public function welcomeAction($username)
    {
        return array(
            'username' => $username,
        );
    }
}
