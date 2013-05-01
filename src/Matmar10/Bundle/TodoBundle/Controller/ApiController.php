<?php

namespace Matmar10\Bundle\TodoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\SecurityContext;
use RuntimeException;

class ApiController extends Controller
{

    /**
     * @Route("/api/tweet", name="api_tweet")
     * @Method({"POST"})
     */
    public function tweetAction()
    {
        $request = $this->getRequest();

        if(false === array_search('application/json', $request->getAcceptableContentTypes())) {
            throw new RuntimeException("Request must Accept Content-Type of application/json.");
        }

        $tweetContent = $request->getContent();

        // trim for Twitter
        $tweetContent = (strlen($tweetContent) > 140) ? substr($tweetContent, 0, 137) . '…' : $tweetContent;

        $twitterService = $this->container->get('matmar10_todo.twitter_service');
        $result = $twitterService->tweet($tweetContent, true);

        $response = new Response($result);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
