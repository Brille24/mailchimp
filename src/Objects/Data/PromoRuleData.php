<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use Brille24\Mailchimp\Objects\Enumeration\DiscountTarget;
use Brille24\Mailchimp\Objects\Enumeration\DiscountType;
use ErrorException;

final class PromoRuleData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $title;

    /** @var string */
    private $description;

    /** @var \DateTimeInterface|null */
    private $starts_at;

    /** @var \DateTimeInterface|null */
    private $ends_at;

    /** @var float */
    private $amount;

    /** @var DiscountType */
    private $type;

    /** @var DiscountTarget */
    private $target;

    /** @var bool|null */
    private $enabled;

    /** @var \DateTimeInterface|null */
    private $created_at_foreign;

    /** @var \DateTimeInterface|null */
    private $updated_at_foreign;

    public function __construct(
        string $id,
        string $description,
        float $amount,
        DiscountType $type,
        DiscountTarget $target
    ) {
        $this->setId($id);
        $this->setDescription($description);
        $this->setAmount($amount);
        $this->setType($type);
        $this->setTarget($target);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Promo rule data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'amount' => $this->getAmount(),
            'type' => (string)$this->getType(),
            'target' => (string)$this->getTarget(),
            'enabled' => $this->getEnabled(),
        ];

        if (null !== $this->getStartsAt()) {
            $bodyParameters['starts_at'] = $this->getStartsAt()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getEndsAt()) {
            $bodyParameters['ends_at'] = $this->getEndsAt()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getCreatedAtForeign()) {
            $bodyParameters['created_at_foreign'] = $this->getCreatedAtForeign()->format(\DateTimeInterface::ATOM);
        }

        if (null !== $this->getUpdatedAtForeign()) {
            $bodyParameters['updated_at_foreign'] = $this->getUpdatedAtForeign()->format(\DateTimeInterface::ATOM);
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
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getStartsAt(): ?\DateTimeInterface
    {
        return $this->starts_at;
    }

    /**
     * @param \DateTimeInterface|null $starts_at
     */
    public function setStartsAt(?\DateTimeInterface $starts_at): void
    {
        $this->starts_at = $starts_at;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEndsAt(): ?\DateTimeInterface
    {
        return $this->ends_at;
    }

    /**
     * @param \DateTimeInterface|null $ends_at
     */
    public function setEndsAt(?\DateTimeInterface $ends_at): void
    {
        $this->ends_at = $ends_at;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
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

    /**
     * @return DiscountTarget
     */
    public function getTarget(): DiscountTarget
    {
        return $this->target;
    }

    /**
     * @param DiscountTarget $target
     */
    public function setTarget(DiscountTarget $target): void
    {
        $this->target = $target;
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
