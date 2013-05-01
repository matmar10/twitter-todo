<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;

class ApiController extends Controller
{
    /**
     * @Route("/api/tweet", name="api_tweet")
     * @Method({"POST"})
     */
    public function tweetAction($content)
    {
        $testContent = "This is a test tweet.";
        $twitterService = $this->container->get('matmar10_todo.twitter_service');
        $result = $twitterService->tweet($testContent);
        $response = new Response($result);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
