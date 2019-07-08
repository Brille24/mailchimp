<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\PromoRuleRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Request\StoreRequest;
use PhpSpec\ObjectBehavior;

class PromoRuleRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');

        $this->beConstructedThrough('fromStoreAndMethod', [$storeRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PromoRuleRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/promo-rules');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        StoreRequest $storeRequest
    ): void {
        $storeRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A PromoRuleRequest can only be used with a Store-Identifier!')
        )->during(
            'fromStoreAndMethod',
            [$storeRequest, RequestMethod::byName('GET')]
        );
    }
}
