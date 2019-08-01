<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Automations;


use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

final class QueueRequest extends Request
{
    /**
     * @param EmailRequest $emailRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromEmailAndMethod(
        EmailRequest $emailRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $emailRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A QueueRequest can only be used with an Email-Identifier!');
        }

        $queueRequest = new self($method);
        $queueRequest->setEmailRequest($emailRequest);

        return $queueRequest;
    }

    /** @var EmailRequest */
    protected $emailRequest;

    /**
     * @param EmailRequest $emailRequest
     * @param RequestMethod $method
     * @param string|null $email
     *
     * @return RequestInterface
     */
    public static function fromEmailMethodAndEmail(
        EmailRequest $emailRequest,
        RequestMethod $method,
        ?string $email = null
    ): RequestInterface {
        if (null === $emailRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A QueueRequest can only be used with an Email-Identifier!');
        }

        $queueRequest = new self($method);
        $queueRequest->setEmailRequest($emailRequest);

        if (null !== $email) {
            $queueRequest->setIdentifier(hash('md5', strtolower($email)));
        }

        return $queueRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getEmailRequest()->getPrimaryResource(), 'queue');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return EmailRequest */
    public function getEmailRequest(): EmailRequest
    {
        return $this->emailRequest;
    }

    /** @param EmailRequest $emailRequest */
    public function setEmailRequest(EmailRequest $emailRequest): void
    {
        $this->emailRequest = $emailRequest;
    }
}
