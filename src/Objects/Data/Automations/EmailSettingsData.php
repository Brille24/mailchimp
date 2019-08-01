<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use ErrorException;

final class EmailSettingsData implements DataInterface
{
    /** @var string|null */
    private $subjectLine;

    /** @var string|null */
    private $previewText;

    /** @var string|null */
    private $title;

    /** @var string|null */
    private $fromName;

    /** @var string|null */
    private $replyTo;

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Settings data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'subject_line' => $this->subjectLine,
            'preview_text' => $this->previewText,
            'title'        => $this->title,
            'from_name'    => $this->fromName,
            'reply_to'     => $this->replyTo,
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return string|null
     */
    public function getSubjectLine(): ?string
    {
        return $this->subjectLine;
    }

    /**
     * @param string|null $subjectLine
     */
    public function setSubjectLine(?string $subjectLine): void
    {
        $this->subjectLine = $subjectLine;
    }

    /**
     * @return string|null
     */
    public function getPreviewText(): ?string
    {
        return $this->previewText;
    }

    /**
     * @param string|null $previewText
     */
    public function setPreviewText(?string $previewText): void
    {
        $this->previewText = $previewText;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getFromName(): ?string
    {
        return $this->fromName;
    }

    /**
     * @param string|null $fromName
     */
    public function setFromName(?string $fromName): void
    {
        $this->fromName = $fromName;
    }

    /**
     * @return string|null
     */
    public function getReplyTo(): ?string
    {
        return $this->replyTo;
    }

    /**
     * @param string|null $replyTo
     */
    public function setReplyTo(?string $replyTo): void
    {
        $this->replyTo = $replyTo;
    }
}
