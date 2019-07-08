<?php

namespace spec\Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\ProductImageRequest;
use Brille24\Mailchimp\Objects\Request\ProductRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Request\StoreRequest;
use PhpSpec\ObjectBehavior;

class ProductImageRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $storeRequest = StoreRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'store-ident');
        $productRequest = ProductRequest::fromStoreMethodAndId($storeRequest, RequestMethod::byName('GET'), 'product-ident');

        $this->beConstructedThrough('fromProductAndMethod', [$productRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ProductImageRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('ecommerce/stores/store-ident/products/product-ident/images');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        ProductRequest $productRequest
    ): void {
        $productRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A ProductImageRequest can only be used with a Product-Identifier!')
        )->during(
            'fromProductAndMethod',
            [$productRequest, RequestMethod::byName('GET')]
        );
    }
}
