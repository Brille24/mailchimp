<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Audiences;

use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\Audiences\MemberLanguage;
use Brille24\Mailchimp\Objects\Enumeration\Audiences\MemberStatus;
use \ErrorException;

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

    /** @var array|null */
    protected $marketingPermissions;

    /** @var array|null */
    protected $tags;

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

    /**
     * @return array|null
     */
    public function getMarketingPermissions(): ?array
    {
        return $this->marketingPermissions;
    }

    /**
     * @param array|null $marketingPermissions
     */
    public function setMarketingPermissions(?array $marketingPermissions): void
    {
        $this->marketingPermissions = $marketingPermissions;
    }

    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }

    /**
     * @param array|null $tags
     */
    public function setTags(?array $tags): void
    {
        $this->tags = $tags;
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Member data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [];

        $bodyParameters['email_address'] = $this->getEmailAddress();
        $bodyParameters['email_type'] = $this->getEmailType();
        $bodyParameters['status'] = (string) $this->getStatus();
        $bodyParameters['language'] = (string) $this->getLanguage();
        $bodyParameters['vip'] = $this->isVip();

        if (null !== $this->getInterests()) {
            $bodyParameters['interests'] = $this->getInterests();
        }

        if (null !== $this->getMergeFields()) {
            $bodyParameters['merge_fields'] = $this->getMergeFields();
        }

        if (null !== $this->getMarketingPermissions()) {
            foreach ($this->getMarketingPermissions() as $permissionId => $enabled) {
                $bodyParameters['marketing_permissions'][] = [
                    'marketing_permission_id' => $permissionId,
                    'enabled' => $enabled
                ];
            }
        }

        if (null !== $this->getTags()) {
            $bodyParameters['tags'] = $this->getTags();
        }

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }
}
