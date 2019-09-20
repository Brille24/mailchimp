<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class QueueData implements DataInterface
{
    /** @var string */
    private $emailAddress;

    public function __construct(string $emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Queue data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        return ['email_address' => $this->emailAddress];
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @param string $emailAddress
     */
    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }
}
