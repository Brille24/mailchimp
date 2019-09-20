<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

class CartLineRequest extends Request
{
    /**
     * @param CartRequest $cartRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromCartAndMethod(
        CartRequest $cartRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $cartRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A CartLineRequest can only be used with a Cart-Identifier!');
        }

        $cartLineRequest = new self($method);
        $cartLineRequest->setCartRequest($cartRequest);

        return $cartLineRequest;
    }

    /** @var CartRequest */
    protected $cartRequest;

    /**
     * @param CartRequest $cartRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromCartMethodAndId(
        CartRequest $cartRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $cartRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A CartLineRequest can only be used with a Cart-Identifier!');
        }

        $cartLineRequest = new self($method);
        $cartLineRequest->setCartRequest($cartRequest);

        if (null !== $id) {
            $cartLineRequest->setIdentifier($id);
        }

        return $cartLineRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getCartRequest()->getPrimaryResource(), 'lines');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return CartRequest */
    public function getCartRequest(): CartRequest
    {
        return $this->cartRequest;
    }

    /** @param CartRequest $cartRequest */
    public function setCartRequest(CartRequest $cartRequest): void
    {
        $this->cartRequest = $cartRequest;
    }
}
