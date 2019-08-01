<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Ecommerce;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;
use Webmozart\Assert\Assert;

final class OrderData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var CustomerData */
    private $customer;

    /** @var string|null */
    private $campaign_id;

    /** @var string|null */
    private $landing_site;

    /** @var string|null */
    private $financial_status;

    /** @var string|null */
    private $fulfillment_status;

    /** @var string */
    private $currency_code;

    /** @var float */
    private $order_total;

    /** @var string|null */
    private $order_url;

    /** @var float|null */
    private $discount_total;

    /** @var float|null */
    private $tax_total;

    /** @var float|null */
    private $shipping_total;

    /** @var string|null */
    private $tracking_code;

    /** @var \DateTimeInterface|null */
    private $processed_at_foreign;

    /** @var \DateTimeInterface|null */
    private $cancelled_at_foreign;

    /** @var \DateTimeInterface|null */
    private $updated_at_foreign;

    /** @var OrderAddressData|null */
    private $shipping_address;

    /** @var OrderAddressData|null */
    private $billing_address;

    /** @var OrderPromo[] */
    private $promos = [];

    /** @var OrderLineData[] */
    private $lines;

    /** @var OutreachData|null */
    private $outreach;

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
            throw new ErrorException('Order data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $lines = array_map(function(OrderLineData $line) {
            return $line->toRequestBodyArray();
        }, $this->getLines());

        $promos = array_map(function(OrderPromo $promo) {
            return $promo->toRequestBodyArray();
        }, $this->getPromos());

        $bodyParameters = [
            'id' => $this->getId(),
            'customer' => $this->getCustomer()->toRequestBodyArray(),
            'campaign_id' => $this->getCampaignId(),
            'landing_site' => $this->getLandingSite(),
            'financial_status' => $this->getFinancialStatus(),
            'fulfillment_status' => $this->getFulfillmentStatus(),
            'currency_code' => $this->getCurrencyCode(),
            'order_total' => $this->getOrderTotal(),
            'order_url' => $this->getOrderUrl(),
            'discount_total' => $this->getDiscountTotal(),
            'tax_total' => $this->getTaxTotal(),
            'shipping_total' => $this->getShippingTotal(),
            'tracking_code' => $this->getTrackingCode(),
            'promos' => $promos,
            'lines' => $lines,
        ];

        if (null !== $this->getProcessedAtForeign()) {
            $bodyParameters['processed_at_foreign'] = $this->getProcessedAtForeign()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getCancelledAtForeign()) {
            $bodyParameters['cancelled_at_foreign'] = $this->getCancelledAtForeign()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getUpdatedAtForeign()) {
            $bodyParameters['updated_at_foreign'] = $this->getUpdatedAtForeign()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getShippingAddress()) {
            $bodyParameters['shipping_address'] = $this->getShippingAddress()->toRequestBodyArray();
        }

        if (null !== $this->getBillingAddress()) {
            $bodyParameters['billing_address'] = $this->getBillingAddress()->toRequestBodyArray();
        }

        if (null !== $this->getOutreach()) {
            $bodyParameters['outreach'] = $this->getOutreach()->toRequestBodyArray();
        }

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
    public function getLandingSite(): ?string
    {
        return $this->landing_site;
    }

    /**
     * @param string|null $landing_site
     */
    public function setLandingSite(?string $landing_site): void
    {
        $this->landing_site = $landing_site;
    }

    /**
     * @return string|null
     */
    public function getFinancialStatus(): ?string
    {
        return $this->financial_status;
    }

    /**
     * @param string|null $financial_status
     */
    public function setFinancialStatus(?string $financial_status): void
    {
        $this->financial_status = $financial_status;
    }

    /**
     * @return string|null
     */
    public function getFulfillmentStatus(): ?string
    {
        return $this->fulfillment_status;
    }

    /**
     * @param string|null $fulfillment_status
     */
    public function setFulfillmentStatus(?string $fulfillment_status): void
    {
        $this->fulfillment_status = $fulfillment_status;
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
     * @return string|null
     */
    public function getOrderUrl(): ?string
    {
        return $this->order_url;
    }

    /**
     * @param string|null $order_url
     */
    public function setOrderUrl(?string $order_url): void
    {
        $this->order_url = $order_url;
    }

    /**
     * @return float|null
     */
    public function getDiscountTotal(): ?float
    {
        return $this->discount_total;
    }

    /**
     * @param float|null $discount_total
     */
    public function setDiscountTotal(?float $discount_total): void
    {
        $this->discount_total = $discount_total;
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
     * @return float|null
     */
    public function getShippingTotal(): ?float
    {
        return $this->shipping_total;
    }

    /**
     * @param float|null $shipping_total
     */
    public function setShippingTotal(?float $shipping_total): void
    {
        $this->shipping_total = $shipping_total;
    }

    /**
     * @return string|null
     */
    public function getTrackingCode(): ?string
    {
        return $this->tracking_code;
    }

    /**
     * @param string|null $tracking_code
     */
    public function setTrackingCode(?string $tracking_code): void
    {
        $this->tracking_code = $tracking_code;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getProcessedAtForeign(): ?\DateTimeInterface
    {
        return $this->processed_at_foreign;
    }

    /**
     * @param \DateTimeInterface|null $processed_at_foreign
     */
    public function setProcessedAtForeign(?\DateTimeInterface $processed_at_foreign): void
    {
        $this->processed_at_foreign = $processed_at_foreign;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCancelledAtForeign(): ?\DateTimeInterface
    {
        return $this->cancelled_at_foreign;
    }

    /**
     * @param \DateTimeInterface|null $cancelled_at_foreign
     */
    public function setCancelledAtForeign(?\DateTimeInterface $cancelled_at_foreign): void
    {
        $this->cancelled_at_foreign = $cancelled_at_foreign;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAtForeign(): ?\DateTimeInterface
    {
        return $this->updated_at_foreign;
    }

    /**
     * @param \DateTimeInterface|null $updated_at_foreign
     */
    public function setUpdatedAtForeign(?\DateTimeInterface $updated_at_foreign): void
    {
        $this->updated_at_foreign = $updated_at_foreign;
    }

    /**
     * @return OrderAddressData|null
     */
    public function getShippingAddress(): ?OrderAddressData
    {
        return $this->shipping_address;
    }

    /**
     * @param OrderAddressData|null $shipping_address
     */
    public function setShippingAddress(?OrderAddressData $shipping_address): void
    {
        $this->shipping_address = $shipping_address;
    }

    /**
     * @return OrderAddressData|null
     */
    public function getBillingAddress(): ?OrderAddressData
    {
        return $this->billing_address;
    }

    /**
     * @param OrderAddressData|null $billing_address
     */
    public function setBillingAddress(?OrderAddressData $billing_address): void
    {
        $this->billing_address = $billing_address;
    }

    /**
     * @return OrderPromo[]
     */
    public function getPromos(): array
    {
        return $this->promos;
    }

    /**
     * @param OrderPromo[] $promos
     */
    public function setPromos(array $promos): void
    {
        $this->promos = $promos;
    }

    /**
     * @param OrderPromo $promo
     */
    public function addPromo(OrderPromo $promo): void
    {
        $this->promos[] = $promo;
    }

    /**
     * @param OrderPromo $promo
     */
    public function removePromo(OrderPromo $promo): void
    {
        if (($key = array_search($promo, $this->promos)) !== false) {
            unset($this->promos[$key]);
        }
    }

    /**
     * @return OrderLineData[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param OrderLineData[] $lines
     */
    public function setLines(array $lines): void
    {
        Assert::notEmpty($lines, 'At least one line item is required!');

        $this->lines = $lines;
    }

    /**
     * @param OrderLineData $line
     */
    public function addLine(OrderLineData $line): void
    {
        $this->lines[] = $line;
    }

    /**
     * @param OrderLineData $line
     */
    public function removeLine(OrderLineData $line): void
    {
        Assert::minCount($this->lines, 2, 'At least one line item is required!');

        if (($key = array_search($line, $this->lines)) !== false) {
            unset($this->lines[$key]);
        }
    }

    /**
     * @return OutreachData|null
     */
    public function getOutreach(): ?OutreachData
    {
        return $this->outreach;
    }

    /**
     * @param OutreachData|null $outreach
     */
    public function setOutreach(?OutreachData $outreach): void
    {
        $this->outreach = $outreach;
    }
}
