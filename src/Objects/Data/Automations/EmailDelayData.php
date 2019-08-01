<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Enumeration\Automations\DelayAction;
use Brille24\Mailchimp\Objects\Enumeration\Automations\DelayDirection;
use Brille24\Mailchimp\Objects\Enumeration\Automations\DelayType;
use ErrorException;

final class EmailDelayData
{
    /** @var int|null */
    private $amount;

    /** @var DelayType|null */
    private $type;

    /** @var DelayDirection|null */
    private $direction;

    /** @var DelayAction */
    private $action;

    public function __construct(DelayAction $action)
    {
        $this->action = $action;
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Delay data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'amount' => $this->amount,
            'action' => $this->action->getValue(),
        ];

        if (null !== $this->type) {
            $bodyParameters['type'] = $this->type->getValue();
        }

        if (null !== $this->direction) {
            $bodyParameters['direction'] = $this->direction->getValue();
        }

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return int|null
     */
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    /**
     * @param int|null $amount
     */
    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return DelayType|null
     */
    public function getType(): ?DelayType
    {
        return $this->type;
    }

    /**
     * @param DelayType|null $type
     */
    public function setType(?DelayType $type): void
    {
        $this->type = $type;
    }

    /**
     * @return DelayDirection|null
     */
    public function getDirection(): ?DelayDirection
    {
        return $this->direction;
    }

    /**
     * @param DelayDirection|null $direction
     */
    public function setDirection(?DelayDirection $direction): void
    {
        $this->direction = $direction;
    }

    /**
     * @return DelayAction
     */
    public function getAction(): DelayAction
    {
        return $this->action;
    }

    /**
     * @param DelayAction $action
     */
    public function setAction(DelayAction $action): void
    {
        $this->action = $action;
    }
}
