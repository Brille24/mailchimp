<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\ListRequest;
use Brille24\Mailchimp\Objects\Request\MemberRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MemberRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith(RequestMethod::byName('GET'));
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MemberRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_throws_an_exception_if_a_request_is_not_built_properly(
        RequestInterface $request
    ): void {
        $request->beADoubleOf(RequestInterface::class);
        $this->shouldThrow(
            new \InvalidArgumentException(
                sprintf('A MemberRequest can only be executed with a ListRequest, %s given', get_class($request->getWrappedObject())))
        )->during(
            'fromListAndMethod',
            [RequestMethod::byName('GET'), $request]
        );
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        RequestInterface $request
    ): void {
        $request->beADoubleOf(ListRequest::class);
        $request->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A MemberRequest can only be used with a List-Identifier!')
        )->during(
            'fromListAndMethod',
            [RequestMethod::byName('GET'), $request]
        );
    }
}
