<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use InvalidArgumentException;

class ProductVariantRequest extends Request
{
    /**
     * @param ProductRequest $productRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromProductAndMethod(
        ProductRequest $productRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $productRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A ProductVariantRequest can only be used with a Product-Identifier!');
        }

        $productVariantRequest = new self($method);
        $productVariantRequest->setProductRequest($productRequest);

        return $productVariantRequest;
    }

    /** @var ProductRequest */
    protected $productRequest;

    /**
     * @param ProductRequest $productRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromProductMethodAndId(
        ProductRequest $productRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $productRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A ProductVariantRequest can only be used with a Product-Identifier!');
        }

        $productVariantRequest = new self($method);
        $productVariantRequest->setProductRequest($productRequest);

        if (null !== $id) {
            $productVariantRequest->setIdentifier($id);
        }

        return $productVariantRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getProductRequest()->getPrimaryResource(), 'variants');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return ProductRequest */
    public function getProductRequest(): ProductRequest
    {
        return $this->productRequest;
    }

    /** @param ProductRequest $productRequest */
    public function setProductRequest(ProductRequest $productRequest): void
    {
        $this->productRequest = $productRequest;
    }
}
