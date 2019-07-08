<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Request\StoreRequest;
use PhpSpec\ObjectBehavior;

class StoreRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedThrough('fromMethod', [RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(StoreRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores');
    }
}
