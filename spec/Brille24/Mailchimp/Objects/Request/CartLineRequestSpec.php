<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\CartLineRequest;
use Brille24\Mailchimp\Objects\Request\CartRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Request\StoreRequest;
use PhpSpec\ObjectBehavior;

class CartLineRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');
        $cartRequest = CartRequest::fromStoreMethodAndId($storeRequest, RequestMethod::byName('GET'), 'cart-ident');

        $this->beConstructedThrough('fromCartAndMethod', [$cartRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(CartLineRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/carts/cart-ident/lines');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        CartRequest $cartRequest
    ): void {
        $cartRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A CartLineRequest can only be used with a Cart-Identifier!')
        )->during(
            'fromCartAndMethod',
            [$cartRequest, RequestMethod::byName('GET')]
        );
    }
}
