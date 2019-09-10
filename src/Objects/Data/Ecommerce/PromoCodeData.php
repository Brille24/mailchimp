<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Ecommerce;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class PromoCodeData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $code;

    /** @var string */
    private $redemption_url;

    /** @var int|null */
    private $usage_count;

    /** @var bool|null */
    private $enabled;

    /** @var \DateTimeInterface|null */
    private $created_at_foreign;

    /** @var \DateTimeInterface|null */
    private $updated_at_foreign;

    public function __construct(
        string $id,
        string $code,
        string $redemption_url
    ) {
        $this->setId($id);
        $this->setCode($code);
        $this->setRedemptionUrl($redemption_url);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Promo code data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'code' => $this->getCode(),
            'redemption_url' => $this->getRedemptionUrl(),
            'usage_count' => $this->getUsageCount(),
            'enabled' => $this->getEnabled(),
        ];

        if (null !== $this->getCreatedAtForeign()) {
            $bodyParameters['created_at_foreign'] = $this->getCreatedAtForeign()->format(\DateTime::ATOM);
        }

        if (null !== $this->getUpdatedAtForeign()) {
            $bodyParameters['updated_at_foreign'] = $this->getUpdatedAtForeign()->format(\DateTime::ATOM);
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
     * @return string
     */
    public function getRedemptionUrl(): string
    {
        return $this->redemption_url;
    }

    /**
     * @param string $redemption_url
     */
    public function setRedemptionUrl(string $redemption_url): void
    {
        $this->redemption_url = $redemption_url;
    }

    /**
     * @return int|null
     */
    public function getUsageCount(): ?int
    {
        return $this->usage_count;
    }

    /**
     * @param int|null $usage_count
     */
    public function setUsageCount(?int $usage_count): void
    {
        $this->usage_count = $usage_count;
    }

    /**
     * @return bool|null
     */
    public function getEnabled(): ?bool
    {
        return $this->enabled;
    }

    /**
     * @param bool|null $enabled
     */
    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAtForeign(): ?\DateTimeInterface
    {
        return $this->created_at_foreign;
    }

    /**
     * @param \DateTimeInterface|null $created_at_foreign
     */
    public function setCreatedAtForeign(?\DateTimeInterface $created_at_foreign): void
    {
        $this->created_at_foreign = $created_at_foreign;
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
}
