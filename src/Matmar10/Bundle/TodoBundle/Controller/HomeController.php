<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class HomeController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/test", name="test")
     * @Template()
     */
    public function testAction()
    {

        $testContent = "This is a test tweet.";
        $twitterService = $this->container->get('matmar10_todo.twitter_service');
        $result = $twitterService->tweet($testContent);
        $result = 'foo';
        $response = new Response($result);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
