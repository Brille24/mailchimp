<?php

namespace spec\Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Ecommerce\OrderLineRequest;
use Brille24\Mailchimp\Objects\Request\Ecommerce\OrderRequest;
use Brille24\Mailchimp\Objects\Request\Ecommerce\StoreRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;

class OrderLineRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');
        $orderRequest = OrderRequest::fromStoreMethodAndId($storeRequest, RequestMethod::byName('GET'), 'order-ident');

        $this->beConstructedThrough('fromOrderAndMethod', [$orderRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(OrderLineRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/orders/order-ident/lines');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        OrderRequest $orderRequest
    ): void {
        $orderRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('An OrderLineRequest can only be used with an Order-Identifier!')
        )->during(
            'fromOrderAndMethod',
            [$orderRequest, RequestMethod::byName('GET')]
        );
    }
}
