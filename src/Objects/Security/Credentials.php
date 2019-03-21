<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Security;

class Credentials
{
    /** @var string */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @param string $apiKey
     *
     * @return Credentials
     */
    public static function fromApiKey(string $apiKey): self
    {
        return new self($apiKey);
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}