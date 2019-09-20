<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Ecommerce;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

class PromoCodeRequest extends Request
{
    /**
     * @param PromoRuleRequest $promoRuleRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromPromoRuleAndMethod(
        PromoRuleRequest $promoRuleRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $promoRuleRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A PromoCodeRequest can only be used with a PromoRule-Identifier!');
        }

        $promoCodeRequest = new self($method);
        $promoCodeRequest->setPromoRuleRequest($promoRuleRequest);

        return $promoCodeRequest;
    }

    /** @var PromoRuleRequest */
    protected $promoRuleRequest;

    /**
     * @param PromoRuleRequest $promoRuleRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromPromoRuleMethodAndId(
        PromoRuleRequest $promoRuleRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $promoRuleRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A PromoRuleCodeRequest can only be used with a PromoRule-Identifier!');
        }

        $promoCodeRequest = new self($method);
        $promoCodeRequest->setPromoRuleRequest($promoRuleRequest);

        if (null !== $id) {
            $promoCodeRequest->setIdentifier($id);
        }

        return $promoCodeRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getPromoRuleRequest()->getPrimaryResource(), 'promo-codes');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return PromoRuleRequest */
    public function getPromoRuleRequest(): PromoRuleRequest
    {
        return $this->promoRuleRequest;
    }

    /** @param PromoRuleRequest $promoRuleRequest */
    public function setPromoRuleRequest(PromoRuleRequest $promoRuleRequest): void
    {
        $this->promoRuleRequest = $promoRuleRequest;
    }
}
