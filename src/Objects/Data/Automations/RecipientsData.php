<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class RecipientsData implements DataInterface
{
    /** @var string|null */
    private $listId;

    /** @var string|null */
    private $storeId;

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Recipients data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'list_id' => $this->listId,
            'store_id' => $this->storeId,
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return string|null
     */
    public function getListId(): ?string
    {
        return $this->listId;
    }

    /**
     * @param string|null $listId
     */
    public function setListId(?string $listId): void
    {
        $this->listId = $listId;
    }

    /**
     * @return string|null
     */
    public function getStoreId(): ?string
    {
        return $this->storeId;
    }

    /**
     * @param string|null $storeId
     */
    public function setStoreId(?string $storeId): void
    {
        $this->storeId = $storeId;
    }
}
