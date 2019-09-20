<?php

namespace spec\Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Ecommerce\PromoCodeRequest;
use Brille24\Mailchimp\Objects\Request\Ecommerce\PromoRuleRequest;
use Brille24\Mailchimp\Objects\Request\Ecommerce\StoreRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;

class PromoCodeRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');
        $promoRuleRequest = PromoRuleRequest::fromStoreMethodAndId($storeRequest, RequestMethod::byName('GET'), 'rule-ident');

        $this->beConstructedThrough('fromPromoRuleAndMethod', [$promoRuleRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PromoCodeRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/promo-rules/rule-ident/promo-codes');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        PromoRuleRequest $promoRuleRequest
    ): void {
        $promoRuleRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A PromoCodeRequest can only be used with a PromoRule-Identifier!')
        )->during(
            'fromPromoRuleAndMethod',
            [$promoRuleRequest, RequestMethod::byName('GET')]
        );
    }
}
