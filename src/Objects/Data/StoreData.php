<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;

final class StoreData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string */
    private $list_id;

    /** @var string */
    private $name;

    /** @var string|null */
    private $platform;

    /** @var string|null */
    private $domain;

    /** @var bool|null */
    private $is_syncing;

    /** @var string|null */
    private $email_address;

    /** @var string */
    private $currency_code;

    /** @var string|null */
    private $money_format;

    /** @var string|null */
    private $primary_locale;

    /** @var string|null */
    private $timezone;

    /** @var string|null */
    private $phone;

    /** @var StoreAddressData|null */
    private $address;

    public function __construct(
        string $id,
        string $list_id,
        string $name,
        string $currency_code
    ) {
        $this->setId($id);
        $this->setListId($list_id);
        $this->setName($name);
        $this->setCurrencyCode($currency_code);
    }

    public function toRequestBody(): string
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'list_id' => $this->getListId(),
            'name' => $this->getName(),
            'platform' => $this->getPlatform(),
            'domain' => $this->getDomain(),
            'is_syncing' => $this->getIsSyncing(),
            'email_address' => $this->getEmailAddress(),
            'currency_code' => $this->getCurrencyCode(),
            'money_format' => $this->getMoneyFormat(),
            'primary_locale' => $this->getPrimaryLocale(),
            'timezone' => $this->getTimezone(),
            'phone' => $this->getPhone(),
        ];

        if (null !== $this->getAddress()) {
            $bodyParameters['address'] = $this->getAddress()->toRequestBody();
        }

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new ErrorException('Store data could not be encoded to json');
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
    public function getListId(): string
    {
        return $this->list_id;
    }

    /**
     * @param string $list_id
     */
    public function setListId(string $list_id): void
    {
        $this->list_id = $list_id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPlatform(): ?string
    {
        return $this->platform;
    }

    /**
     * @param string|null $platform
     */
    public function setPlatform(?string $platform): void
    {
        $this->platform = $platform;
    }

    /**
     * @return string|null
     */
    public function getDomain(): ?string
    {
        return $this->domain;
    }

    /**
     * @param string|null $domain
     */
    public function setDomain(?string $domain): void
    {
        $this->domain = $domain;
    }

    /**
     * @return bool|null
     */
    public function getIsSyncing(): ?bool
    {
        return $this->is_syncing;
    }

    /**
     * @param bool|null $is_syncing
     */
    public function setIsSyncing(?bool $is_syncing): void
    {
        $this->is_syncing = $is_syncing;
    }

    /**
     * @return string|null
     */
    public function getEmailAddress(): ?string
    {
        return $this->email_address;
    }

    /**
     * @param string|null $email_address
     */
    public function setEmailAddress(?string $email_address): void
    {
        $this->email_address = $email_address;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @param string $currency_code
     */
    public function setCurrencyCode(string $currency_code): void
    {
        $this->currency_code = $currency_code;
    }

    /**
     * @return string|null
     */
    public function getMoneyFormat(): ?string
    {
        return $this->money_format;
    }

    /**
     * @param string|null $money_format
     */
    public function setMoneyFormat(?string $money_format): void
    {
        $this->money_format = $money_format;
    }

    /**
     * @return string|null
     */
    public function getPrimaryLocale(): ?string
    {
        return $this->primary_locale;
    }

    /**
     * @param string|null $primary_locale
     */
    public function setPrimaryLocale(?string $primary_locale): void
    {
        $this->primary_locale = $primary_locale;
    }

    /**
     * @return string|null
     */
    public function getTimezone(): ?string
    {
        return $this->timezone;
    }

    /**
     * @param string|null $timezone
     */
    public function setTimezone(?string $timezone): void
    {
        $this->timezone = $timezone;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return StoreAddressData|null
     */
    public function getAddress(): ?StoreAddressData
    {
        return $this->address;
    }

    /**
     * @param StoreAddressData|null $address
     */
    public function setAddress(?StoreAddressData $address): void
    {
        $this->address = $address;
    }
}
