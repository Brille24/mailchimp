<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Ecommerce;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\Ecommerce\ProductVariantVisibility;
use ErrorException;

final class ProductVariantData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string|null */
    private $url;

    /** @var string|null */
    private $sku;

    /** @var float|null */
    private $price;

    /** @var int|null */
    private $inventory_quantity;

    /** @var string|null */
    private $image_url;

    /** @var string|null */
    private $backorders;

    /** @var ProductVariantVisibility|null */
    private $visibility;

    public function __construct(string $id, string $title)
    {
        $this->setId($id);
        $this->setTitle($title);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Product variant data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'sku' => $this->getSku(),
            'price' => $this->getPrice(),
            'inventory_quantity' => $this->getInventoryQuantity(),
            'image_url' => $this->getImageUrl(),
            'backorders' => $this->getBackorders(),
        ];

        if (null !== $this->getVisibility()) {
            $bodyParameters['visibility'] = (string)$this->getVisibility();
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @param string|null $url
     */
    public function setUrl(?string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string|null
     */
    public function getSku(): ?string
    {
        return $this->sku;
    }

    /**
     * @param string|null $sku
     */
    public function setSku(?string $sku): void
    {
        $this->sku = $sku;
    }

    /**
     * @return float|null
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @param float|null $price
     */
    public function setPrice(?float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return int|null
     */
    public function getInventoryQuantity(): ?int
    {
        return $this->inventory_quantity;
    }

    /**
     * @param int|null $inventory_quantity
     */
    public function setInventoryQuantity(?int $inventory_quantity): void
    {
        $this->inventory_quantity = $inventory_quantity;
    }

    /**
     * @return string|null
     */
    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    /**
     * @param string|null $image_url
     */
    public function setImageUrl(?string $image_url): void
    {
        $this->image_url = $image_url;
    }

    /**
     * @return string|null
     */
    public function getBackorders(): ?string
    {
        return $this->backorders;
    }

    /**
     * @param string|null $backorders
     */
    public function setBackorders(?string $backorders): void
    {
        $this->backorders = $backorders;
    }

    /**
     * @return ProductVariantVisibility|null
     */
    public function getVisibility(): ?ProductVariantVisibility
    {
        return $this->visibility;
    }

    /**
     * @param ProductVariantVisibility|null $visibility
     */
    public function setVisibility(?ProductVariantVisibility $visibility): void
    {
        $this->visibility = $visibility;
    }
}
