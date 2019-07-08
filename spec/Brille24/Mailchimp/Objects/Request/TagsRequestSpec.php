<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\ListRequest;
use Brille24\Mailchimp\Objects\Request\MemberRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Request\TagsRequest;
use PhpSpec\ObjectBehavior;
use InvalidArgumentException;

class TagsRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        /** @var ListRequest $listRequest */
        $listRequest = ListRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'list-ident');
        /** @var MemberRequest $memberRequest */
        $memberRequest = MemberRequest::fromListMethodAndEmail($listRequest, RequestMethod::byName('GET'), 'an-email-address');
        $this->beConstructedThrough('fromMethodAndMember', [RequestMethod::byName('GET'), $memberRequest]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagsRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void {
        $this->getPrimaryResource()->shouldReturn('lists/list-ident/members/b728281f3a20ac6a8050009eccfd6525/tags');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        MemberRequest $memberRequest,
        ListRequest $listRequest
    ): void {
        $listRequest->getIdentifier()->willReturn('list-identifier');
        $memberRequest->getIdentifier()->willReturn(null);
        $memberRequest->getListRequest()->willReturn($listRequest);
        $this->shouldThrow(
            new InvalidArgumentException('A TagsRequest can only be used with a Member-Identifier!')
        )->during('fromMethodAndMember', [RequestMethod::byName('GET'), $memberRequest]);
    }
}
