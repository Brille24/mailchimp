<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

class ProductRequest extends Request
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
            throw new \InvalidArgumentException('A ProductRequest can only be used with a Store-Identifier!');
        }

        $productRequest = new self($method);
        $productRequest->setStoreRequest($storeRequest);

        return $productRequest;
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
            throw new \InvalidArgumentException('A ProductRequest can only be used with a Store-Identifier!');
        }

        $productRequest = new self($method);
        $productRequest->setStoreRequest($storeRequest);

        if (null !== $id) {
            $productRequest->setIdentifier($id);
        }

        return $productRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getStoreRequest()->getPrimaryResource(), 'products');
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
