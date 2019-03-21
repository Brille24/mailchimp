<?php

namespace spec\Brille24\Mailchimp;

use Brille24\Mailchimp\Mailchimp;
use Brille24\Mailchimp\MailchimpInterface;
use Brille24\Mailchimp\Objects\Security\Credentials;
use GuzzleHttp\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MailchimpSpec extends ObjectBehavior
{
    public function let(Client $client, Credentials $credentials)
    {
        $this->beConstructedWith($client, $credentials);
    }
    function it_is_initializable()
    {
        $this->shouldHaveType(Mailchimp::class);
    }

    function it_implements()
    {
        $this->shouldImplement(MailchimpInterface::class);
    }
}
