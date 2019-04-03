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
        /** @var ListRequest $listRequest */
        $listRequest = ListRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'list-ident');

        $this->beConstructedThrough('fromListAndMethod', [$listRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MemberRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('lists/list-ident/members');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        ListRequest $request
    ): void {
        $request->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A MemberRequest can only be used with a List-Identifier!')
        )->during(
            'fromListAndMethod',
            [$request, RequestMethod::byName('GET')]
        );
    }
}
