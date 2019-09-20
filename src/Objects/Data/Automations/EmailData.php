<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class EmailData implements DataInterface
{
    /** @var string */
    private $settings;

    public function __construct(string $emailAddress)
    {
        $this->settings = $emailAddress;
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
        return ['email_address' => $this->settings];
    }

    /**
     * @return string
     */
    public function getSettings(): string
    {
        return $this->settings;
    }

    /**
     * @param string $settings
     */
    public function setSettings(string $settings): void
    {
        $this->settings = $settings;
    }
}
