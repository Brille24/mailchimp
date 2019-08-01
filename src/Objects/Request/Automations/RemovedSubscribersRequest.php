<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Automations;


use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

class RemovedSubscribersRequest extends Request
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
            throw new \InvalidArgumentException('A RemovedSubscribersRequest can only be used with an Automation-Identifier!');
        }

        $emailRequest = new self($method);
        $emailRequest->setAutomationRequest($automationRequest);

        return $emailRequest;
    }

    /** @var AutomationRequest */
    protected $automationRequest;

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getAutomationRequest()->getPrimaryResource(), 'removed-subscribers');

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
