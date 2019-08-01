<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Automations;


use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

final class EmailRequest extends Request
{
    /**
     * @param AutomationRequest $automationRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromAutomationAndMethod(
        AutomationRequest $automationRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $automationRequest->getIdentifier()) {
            throw new \InvalidArgumentException('An EmailRequest can only be used with an Automation-Identifier!');
        }

        $emailRequest = new self($method);
        $emailRequest->setAutomationRequest($automationRequest);

        return $emailRequest;
    }

    /** @var AutomationRequest */
    protected $automationRequest;

    /**
     * @param AutomationRequest $automationRequest
     * @param RequestMethod $method
     * @param string|null $id
     *
     * @return RequestInterface
     */
    public static function fromAutomationMethodAndId(
        AutomationRequest $automationRequest,
        RequestMethod $method,
        ?string $id = null
    ): RequestInterface {
        if (null === $automationRequest->getIdentifier()) {
            throw new \InvalidArgumentException('An EmailRequest can only be used with an Automation-Identifier!');
        }

        $emailRequest = new self($method);
        $emailRequest->setAutomationRequest($automationRequest);

        if (null !== $id) {
            $emailRequest->setIdentifier($id);
        }

        return $emailRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getAutomationRequest()->getPrimaryResource(), 'emails');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return AutomationRequest */
    public function getAutomationRequest(): AutomationRequest
    {
        return $this->automationRequest;
    }

    /** @param AutomationRequest $automationRequest */
    public function setAutomationRequest(AutomationRequest $automationRequest): void
    {
        $this->automationRequest = $automationRequest;
    }
}
