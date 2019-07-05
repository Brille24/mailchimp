<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;

final class OutreachData implements DataInterface
{
    /** @var string|null */
    private $id;

    public function toRequestBody(): string
    {
        $bodyParameters = [
            'id' => $this->getId(),
        ];

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new ErrorException('Outreach data could not be encoded to json');
        }

        return $body;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     */
    public function setId(?string $id): void
    {
        $this->id = $id;
    }
}
