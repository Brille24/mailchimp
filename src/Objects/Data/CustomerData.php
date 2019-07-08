<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;

final class CustomerData implements DataInterface
{
    /** @var string */
    private $id;

    /** @var string|null */
    private $email_address;

    /** @var bool|null */
    private $opt_in_status;

    /** @var string|null */
    private $company;

    /** @var string|null */
    private $first_name;

    /** @var string|null */
    private $last_name;

    /** @var int|null */
    private $orders_count;

    /** @var float|null */
    private $total_spent;

    /** @var CustomerAddressData|null */
    private $address;

    public function __construct(string $id)
    {
        $this->setId($id);
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Customer data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'id' => $this->getId(),
            'email_address' => $this->getEmailAddress(),
            'opt_in_status' => $this->getOptInStatus(),
            'company' => $this->getCompany(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'orders_count' => $this->getOrdersCount(),
            'total_spent' => $this->getTotalSpent(),
        ];

        if (null !== $this->getAddress()) {
            $bodyParameters['address'] = $this->getAddress()->toRequestBodyArray();
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
     * @return bool|null
     */
    public function getOptInStatus(): ?bool
    {
        return $this->opt_in_status;
    }

    /**
     * @param bool|null $opt_in_status
     */
    public function setOptInStatus(?bool $opt_in_status): void
    {
        $this->opt_in_status = $opt_in_status;
    }

    /**
     * @return string|null
     */
    public function getCompany(): ?string
    {
        return $this->company;
    }

    /**
     * @param string|null $company
     */
    public function setCompany(?string $company): void
    {
        $this->company = $company;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    /**
     * @param string|null $first_name
     */
    public function setFirstName(?string $first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    /**
     * @param string|null $last_name
     */
    public function setLastName(?string $last_name): void
    {
        $this->last_name = $last_name;
    }

    /**
     * @return int|null
     */
    public function getOrdersCount(): ?int
    {
        return $this->orders_count;
    }

    /**
     * @param int|null $orders_count
     */
    public function setOrdersCount(?int $orders_count): void
    {
        $this->orders_count = $orders_count;
    }

    /**
     * @return float|null
     */
    public function getTotalSpent(): ?float
    {
        return $this->total_spent;
    }

    /**
     * @param float|null $total_spent
     */
    public function setTotalSpent(?float $total_spent): void
    {
        $this->total_spent = $total_spent;
    }

    /**
     * @return CustomerAddressData|null
     */
    public function getAddress(): ?CustomerAddressData
    {
        return $this->address;
    }

    /**
     * @param CustomerAddressData|null $address
     */
    public function setAddress(?CustomerAddressData $address): void
    {
        $this->address = $address;
    }
}
