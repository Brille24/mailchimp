<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;

final class OrderLineData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var ProductData */
    private $product;

    /** @var ProductVariantData */
    private $product_variant;

    /** @var int */
    private $quantity;

    /** @var float */
    private $price;

    /** @var float|null */
    private $discount;

    public function __construct(
        string $id,
        ProductData $product,
        ProductVariantData $product_variant,
        int $quantity,
        float $price
    ) {
        $this->setId($id);
        $this->setProduct($product);
        $this->setProductVariant($product_variant);
        $this->setQuantity($quantity);
        $this->setPrice($price);
    }

    public function toRequestBody(): string
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'product_id' => $this->getProduct()->getId(),
            'product_variant_id' => $this->getProductVariant()->getId(),
            'quantity' => $this->getQuantity(),
            'price' => $this->getPrice(),
            'discount' => $this->getDiscount(),
        ];

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new ErrorException('Order line data could not be encoded to json');
        }

        return $body;
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
     * @return ProductData
     */
    public function getProduct(): ProductData
    {
        return $this->product;
    }

    /**
     * @param ProductData $product
     */
    public function setProduct(ProductData $product): void
    {
        $this->product = $product;
    }

    /**
     * @return ProductVariantData
     */
    public function getProductVariant(): ProductVariantData
    {
        return $this->product_variant;
    }

    /**
     * @param ProductVariantData $product_variant
     */
    public function setProductVariant(ProductVariantData $product_variant): void
    {
        $this->product_variant = $product_variant;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float|null
     */
    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    /**
     * @param float|null $discount
     */
    public function setDiscount(?float $discount): void
    {
        $this->discount = $discount;
    }
}
