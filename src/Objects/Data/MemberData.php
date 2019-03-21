<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;

final class MemberData implements DataInterface
{
    /** @var string */
    protected $emailAddress;

    /** @var string  */
    protected $emailType = 'html';

    /** @var string|null */
    protected $status;

    /** @var array|null */
    protected $mergeFields;

    /** @var array|null */
    protected $interests;

    /** @var string|null */
    protected $language;

    /** @var bool */
    protected $vip = false;

    /** @return string */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /** @param string $emailAddress */
    public function setEmailAddress(string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    /** @return string */
    public function getEmailType(): string
    {
        return $this->emailType;
    }

    /** @param string $emailType */
    public function setEmailType(string $emailType): void
    {
        $this->emailType = $emailType;
    }

    /** @return string */
    public function getStatus(): ?string
    {
        return $this->status;
    }

    /** @param string $status */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /** @return array */
    public function getMergeFields(): ?array
    {
        return $this->mergeFields;
    }

    /** @param array $mergeFields */
    public function setMergeFields(array $mergeFields): void
    {
        $this->mergeFields = $mergeFields;
    }

    /** @return array */
    public function getInterests(): ?array
    {
        return $this->interests;
    }

    /** @param array $interests */
    public function setInterests(array $interests): void
    {
        $this->interests = $interests;
    }

    /** @return string */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /** @param string $language */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }

    /** @return bool */
    public function isVip(): bool
    {
        return $this->vip;
    }

    /** @param bool $vip */
    public function setVip(bool $vip): void
    {
        $this->vip = $vip;
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $bodyParameters = [];

        $bodyParameters['email_address'] = $this->getEmailAddress();
        $bodyParameters['email_type'] = $this->getEmailType();
        $bodyParameters['status'] = $this->getStatus();
        $bodyParameters['language'] = $this->getLanguage();
        $bodyParameters['vip'] = $this->isVip();

        if (null !== $this->getInterests()) {
            $bodyParameters['interests'] = $this->getInterests();
        }

        if (null !== $this->getMergeFields()) {
            $bodyParameters['merge_fields'] = $this->getMergeFields();
        }

        $body = json_encode($bodyParameters);
        if ($body === false) {
            throw new \Exception('Member data could not be encoded to json');
        }

        return $body;
    }
}