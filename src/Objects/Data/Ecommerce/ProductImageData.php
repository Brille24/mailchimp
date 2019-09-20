<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Ecommerce;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class ProductImageData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $url;

    /** @var ProductVariantData[] */
    private $variants = [];

    public function __construct(string $id, string $url)
    {
        $this->setId($id);
        $this->setUrl($url);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Product image data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $variant_ids = array_map(function(ProductVariantData $variant) {
            return $variant->getId();
        }, $this->getVariants());

        $bodyParameters = [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'variant_ids' => $variant_ids,
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
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return ProductVariantData[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    /**
     * @param ProductVariantData[] $variants
     */
    public function setVariants(array $variants): void
    {
        $this->variants = $variants;
    }

    /**
     * @param ProductVariantData $variant
     */
    public function addVariant(ProductVariantData $variant): void
    {
        $this->variants[] = $variant;
    }

    /**
     * @param ProductVariantData $variant
     */
    public function removeVariant(ProductVariantData $variant): void
    {
        if (($key = array_search($variant, $this->variants)) !== false) {
            unset($this->variants[$key]);
        }
    }
}
