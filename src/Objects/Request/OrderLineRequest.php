<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use InvalidArgumentException;

class OrderLineRequest extends Request
{
    /**
     * @param OrderRequest $orderRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromOrderAndMethod(
        OrderRequest $orderRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $orderRequest->getIdentifier()) {
            throw new \InvalidArgumentException('An OrderLineRequest can only be used with an Order-Identifier!');
        }

        $orderLineRequest = new self($method);
        $orderLineRequest->setOrderRequest($orderRequest);

        return $orderLineRequest;
    }

    /** @var OrderRequest */
    protected $orderRequest;

    /**
     * @param OrderRequest $orderRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromOrderMethodAndId(
        OrderRequest $orderRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $orderRequest->getIdentifier()) {
            throw new \InvalidArgumentException('An OrderLineRequest can only be used with an Order-Identifier!');
        }

        $orderLineRequest = new self($method);
        $orderLineRequest->setOrderRequest($orderRequest);

        if (null !== $id) {
            $orderLineRequest->setIdentifier($id);
        }

        return $orderLineRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getOrderRequest()->getPrimaryResource(), 'lines');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return OrderRequest */
    public function getOrderRequest(): OrderRequest
    {
        return $this->orderRequest;
    }

    /** @param OrderRequest $orderRequest */
    public function setOrderRequest(OrderRequest $orderRequest): void
    {
        $this->orderRequest = $orderRequest;
    }
}
