<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;

class StoreRequest extends Request
{
    /** {@inheritdoc} */
    public static function fromMethod(
        RequestMethod $method
    ): RequestInterface {
        return new self($method);
    }

    /**
     * @param RequestMethod $method
     * @param string|null $storeId
     *
     * @return RequestInterface
     */
    public static function fromMethodAndIdentifier(
        RequestMethod $method,
        ?string $storeId = null
    ): RequestInterface {
        $storeRequest = new self($method);
        $storeRequest->setIdentifier($storeId);

        return $storeRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        $primaryResource = 'ecommerce/stores';
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }
}
