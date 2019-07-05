<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use InvalidArgumentException;

class CartRequest extends Request
{
    /**
     * @param StoreRequest $storeRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromStoreAndMethod(
        StoreRequest $storeRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $storeRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A CartRequest can only be used with a Store-Identifier!');
        }

        $cartRequest = new self($method);
        $cartRequest->setStoreRequest($storeRequest);

        return $cartRequest;
    }

    /** @var StoreRequest */
    protected $storeRequest;

    /**
     * @param StoreRequest $storeRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromStoreMethodAndId(
        StoreRequest $storeRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $storeRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A CartRequest can only be used with a Store-Identifier!');
        }

        $cartRequest = new self($method);
        $cartRequest->setStoreRequest($storeRequest);

        if (null !== $id) {
            $cartRequest->setIdentifier($id);
        }

        return $cartRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getStoreRequest()->getPrimaryResource(), 'carts');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return StoreRequest */
    public function getStoreRequest(): StoreRequest
    {
        return $this->storeRequest;
    }

    /** @param StoreRequest $storeRequest */
    public function setStoreRequest(StoreRequest $storeRequest): void
    {
        $this->storeRequest = $storeRequest;
    }
}
