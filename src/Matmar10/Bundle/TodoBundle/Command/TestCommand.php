<?php

namespace Matmar10\Bundle\TodoBundle\Command;

use Guzzle\Http\Client;
use Guzzle\Http\QueryString;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TestCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('zzz:test')
            ->setDescription('Test random things')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //       consumer_key: vdppViIZVmHZdFQaS4CzQ
        //      consumer_secret: UnNv6fRqTpvxX3Jv7z8sNWtLkkgGV40165ekgVzsTo

        $client = new Client('https://api.twitter.com');


        $oauth = new OauthPlugin(array(
            'consumer_key'    => 'vdppViIZVmHZdFQaS4CzQ',
            'consumer_secret' => 'UnNv6fRqTpvxX3Jv7z8sNWtLkkgGV40165ekgVzsTo',
            'callback' => 'http://matmar10-todo.local/sign-in/check-response',
        ));
        $client->addSubscriber($oauth);

        $response = $client->post('/oauth/request_token')->send();
        $responseString = $response->getBody(true);
        $responseParams = QueryString::fromString($responseString);

    }
}