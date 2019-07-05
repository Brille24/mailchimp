<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;
use Webmozart\Assert\Assert;

final class ProductData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $title;

    /** @var string|null */
    private $handle;

    /** @var string|null */
    private $url;

    /** @var string|null */
    private $description;

    /** @var string|null */
    private $type;

    /** @var string|null */
    private $vendor;

    /** @var string|null */
    private $image_url;

    /** @var ProductVariantData[] */
    private $variants;

    /** @var ProductImageData[] */
    private $images = [];

    /** @var \DateTimeInterface|null */
    private $published_at_foreign;

    public function __construct(string $id, string $title, array $variants)
    {
        $this->setId($id);
        $this->setTitle($title);
        $this->setVariants($variants);
    }

    public function toRequestBody(): string
    {
        $variants = array_map(function(ProductVariantData $variant) {
            return $variant->toRequestBody();
        }, $this->getVariants());

        $images = array_map(function(ProductImageData $image) {
            return $image->toRequestBody();
        }, $this->getImages());

        $bodyParameters = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'handle' => $this->getHandle(),
            'url' => $this->getUrl(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
            'vendor' => $this->getVendor(),
            'image_url' => $this->getImageUrl(),
            'variants' => $variants,
            'images' => $images,
        ];

        if (null !== $this->getPublishedAtForeign()) {
            $bodyParameters['published_at_foreign'] = $this->getPublishedAtForeign()->format(\DateTimeInterface::ATOM);
        }

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new ErrorException('Product data could not be encoded to json');
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
    public function getHandle(): ?string
    {
        return $this->handle;
    }

    /**
     * @param string|null $handle
     */
    public function setHandle(?string $handle): void
    {
        $this->handle = $handle;
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
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string|null $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string|null
     */
    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    /**
     * @param string|null $vendor
     */
    public function setVendor(?string $vendor): void
    {
        $this->vendor = $vendor;
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
        Assert::notEmpty($variants, 'At least one variant is required!');

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
        Assert::minCount($this->variants, 2, 'At least one variant is required!');

        if (($key = array_search($variant, $this->variants)) !== false) {
            unset($this->variants[$key]);
        }
    }

    /**
     * @return ProductImageData[]
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @param ProductImageData[] $images
     */
    public function setImages(array $images): void
    {
        $this->images = $images;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getPublishedAtForeign(): ?\DateTimeInterface
    {
        return $this->published_at_foreign;
    }

    /**
     * @param \DateTimeInterface|null $published_at_foreign
     */
    public function setPublishedAtForeign(?\DateTimeInterface $published_at_foreign): void
    {
        $this->published_at_foreign = $published_at_foreign;
    }
}
