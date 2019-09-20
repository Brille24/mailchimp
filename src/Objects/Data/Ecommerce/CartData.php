<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Ecommerce;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;
use Webmozart\Assert\Assert;

final class CartData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var CustomerData */
    private $customer;

    /** @var string|null */
    private $campaign_id;

    /** @var string|null */
    private $checkout_url;

    /** @var string */
    private $currency_code;

    /** @var float */
    private $order_total;

    /** @var float|null */
    private $tax_total;

    /** @var CartLineData[] */
    private $lines;

    public function __construct(
        string $id,
        CustomerData $customer,
        string $currency_code,
        float $order_total,
        array $lines
    ) {
        $this->setId($id);
        $this->setCustomer($customer);
        $this->setCurrencyCode($currency_code);
        $this->setOrderTotal($order_total);
        $this->setLines($lines);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Cart data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $lines = array_map(function(CartLineData $line) {
            return $line->toRequestBodyArray();
        }, $this->getLines());

        $bodyParameters = [
            'id' => $this->getId(),
            'customer' => $this->getCustomer()->toRequestBodyArray(),
            'campaign_id' => $this->getCampaignId(),
            'checkout_url' => $this->getCheckoutUrl(),
            'currency_code' => $this->getCurrencyCode(),
            'order_total' => $this->getOrderTotal(),
            'tax_total' => $this->getTaxTotal(),
            'lines' => $lines,
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return CustomerData
     */
    public function getCustomer(): CustomerData
    {
        return $this->customer;
    }

    /**
     * @param CustomerData $customer
     */
    public function setCustomer(CustomerData $customer): void
    {
        $this->customer = $customer;
    }

    /**
     * @return string|null
     */
    public function getCampaignId(): ?string
    {
        return $this->campaign_id;
    }

    /**
     * @param string|null $campaign_id
     */
    public function setCampaignId(?string $campaign_id): void
    {
        $this->campaign_id = $campaign_id;
    }

    /**
     * @return string|null
     */
    public function getCheckoutUrl(): ?string
    {
        return $this->checkout_url;
    }

    /**
     * @param string|null $checkout_url
     */
    public function setCheckoutUrl(?string $checkout_url): void
    {
        $this->checkout_url = $checkout_url;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     */
    public function setCurrencyCode(string $currency_code): void
    {
        $this->currency_code = $currency_code;
    }

    /**
     * @return float
     */
    public function getOrderTotal(): float
    {
        return $this->order_total;
    }

    /**
     * @param float $order_total
     */
    public function setOrderTotal(float $order_total): void
    {
        $this->order_total = $order_total;
    }

    /**
     * @return float|null
     */
    public function getTaxTotal(): ?float
    {
        return $this->tax_total;
    }

    /**
     * @param float|null $tax_total
     */
    public function setTaxTotal(?float $tax_total): void
    {
        $this->tax_total = $tax_total;
    }

    /**
     * @return CartLineData[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param CartLineData[] $lines
     */
    public function setLines(array $lines): void
    {
        Assert::notEmpty($lines, 'At least one line item is required!');

        $this->lines = $lines;
    }

    /**
     * @param CartLineData $line
     */
    public function addLine(CartLineData $line): void
    {
        $this->lines[] = $line;
    }

    public function removeLine(CartLineData $line): void
    {
        Assert::minCount($line, 2, 'At least one line item is required!');

        if (($key = array_search($line, $this->lines)) !== false) {
            unset($this->lines[$key]);
        }
    }
}
