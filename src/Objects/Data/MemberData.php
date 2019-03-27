<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;

use Brille24\Mailchimp\Objects\Enumeration\MemberLanguage;
use Brille24\Mailchimp\Objects\Enumeration\MemberStatus;

final class MemberData implements DataInterface
{
    /** @var string */
    protected $emailAddress;

    /** @var string  */
    protected $emailType = 'html';

    /** @var MemberStatus|null */
    protected $status;

    /** @var array|null */
    protected $mergeFields;

    /** @var array|null */
    protected $interests;

    /** @var MemberLanguage|null */
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

    /** @return MemberStatus */
    public function getStatus(): ?MemberStatus
    {
        return $this->status;
    }

    /** @param MemberStatus $status */
    public function setStatus(MemberStatus $status): void
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

    /** @return MemberLanguage */
    public function getLanguage(): ?MemberLanguage
    {
        return $this->language;
    }

    /** @param MemberLanguage $language */
    public function setLanguage(MemberLanguage $language): void
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