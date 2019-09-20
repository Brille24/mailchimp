<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class RemovedSubscribersData implements DataInterface
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
            throw new ErrorException('Removed subscribers data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'email_address' => $this->emailAddress,
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
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
