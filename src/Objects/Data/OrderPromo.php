<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use Brille24\Mailchimp\Objects\Enumeration\DiscountType;
use ErrorException;

final class OrderPromo implements DataInterface
{
    /** @var string */
    private $code;

    /** @var float */
    private $amount_discounted;

    /** @var DiscountType */
    private $type;

    public function __construct(
        string $code,
        float $amount_discounted,
        DiscountType $type
    ) {
        $this->setCode($code);
        $this->setAmountDiscounted($amount_discounted);
        $this->setType($type);
    }

    public function toRequestBody(): string
    {
        $bodyParameters = [
            'code' => $this->getCode(),
            'amount_discounted' => $this->getAmountDiscounted(),
            'type' => (string)$this->getType(),
        ];

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new ErrorException('Promo code data could not be encoded to json');
        }

        return $body;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return float
     */
    public function getAmountDiscounted(): float
    {
        return $this->amount_discounted;
    }

    /**
     * @param float $amount_discounted
     */
    public function setAmountDiscounted(float $amount_discounted): void
    {
        $this->amount_discounted = $amount_discounted;
    }

    /**
     * @return DiscountType
     */
    public function getType(): DiscountType
    {
        return $this->type;
    }

    /**
     * @param DiscountType $type
     */
    public function setType(DiscountType $type): void
    {
        $this->type = $type;
    }
}
