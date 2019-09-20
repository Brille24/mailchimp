<?php

namespace spec\Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Ecommerce\CartRequest;
use Brille24\Mailchimp\Objects\Request\Ecommerce\StoreRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;

class CartRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');

        $this->beConstructedThrough('fromStoreAndMethod', [$storeRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CartRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/carts');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        StoreRequest $storeRequest
    ): void {
        $storeRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A CartRequest can only be used with a Store-Identifier!')
        )->during(
            'fromStoreAndMethod',
            [$storeRequest, RequestMethod::byName('GET')]
        );
    }
}
