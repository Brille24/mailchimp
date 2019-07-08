<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;


use ErrorException;

final class StoreAddressData implements DataInterface
{
    /** @var string|null */
    private $address1;

    /** @var string|null */
    private $address2;

    /** @var string|null */
    private $city;

    /** @var string|null */
    private $province;

    /** @var string|null */
    private $province_code;

    /** @var string|null */
    private $postal_code;

    /** @var string|null */
    private $country;

    /** @var string|null */
    private $country_code;

    /** @var float|null */
    private $longitude;

    /** @var float|null */
    private $latitude;

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Address data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'address1' => $this->getAddress1(),
            'address2' => $this->getAddress2(),
            'city' => $this->getCity(),
            'province' => $this->getProvince(),
            'province_code' => $this->getProvinceCode(),
            'postal_code' => $this->getPostalCode(),
            'country' => $this->getCountry(),
            'country_code' => $this->getCountryCode(),
            'longitude' => $this->getLongitude(),
            'latitude' => $this->getLatitude(),
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return string|null
     */
    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    /**
     * @param string|null $address1
     */
    public function setAddress1(?string $address1): void
    {
        $this->address1 = $address1;
    }

    /**
     * @return string|null
     */
    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    /**
     * @param string|null $address2
     */
    public function setAddress2(?string $address2): void
    {
        $this->address2 = $address2;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     */
    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string|null
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @param string|null $province
     */
    public function setProvince(?string $province): void
    {
        $this->province = $province;
    }

    /**
     * @return string|null
     */
    public function getProvinceCode(): ?string
    {
        return $this->province_code;
    }

    /**
     * @param string|null $province_code
     */
    public function setProvinceCode(?string $province_code): void
    {
        $this->province_code = $province_code;
    }

    /**
     * @return string|null
     */
    public function getPostalCode(): ?string
    {
        return $this->postal_code;
    }

    /**
     * @param string|null $postal_code
     */
    public function setPostalCode(?string $postal_code): void
    {
        $this->postal_code = $postal_code;
    }

    /**
     * @return string|null
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }

    /**
     * @param string|null $country
     */
    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    /**
     * @param string|null $country_code
     */
    public function setCountryCode(?string $country_code): void
    {
        $this->country_code = $country_code;
    }

    /**
     * @return float|null
     */
    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    /**
     * @param float|null $longitude
     */
    public function setLongitude(?float $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return float|null
     */
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    /**
     * @param float|null $latitude
     */
    public function setLatitude(?float $latitude): void
    {
        $this->latitude = $latitude;
    }
}
