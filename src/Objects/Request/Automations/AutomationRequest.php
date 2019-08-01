<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Automations;


use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;

class AutomationRequest extends Request
{
    /** {@inheritdoc} */
    public static function fromMethod(
        RequestMethod $method
    ): RequestInterface {
        return new self($method);
    }

    /**
     * @param RequestMethod $method
     * @param string|null $workflowId
     *
     * @return RequestInterface
     */
    public static function fromMethodAndIdentifier(
        RequestMethod $method,
        ?string $workflowId = null
    ): RequestInterface {
        $automationRequest = new self($method);
        $automationRequest->setIdentifier($workflowId);

        return $automationRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        $primaryResource = 'automations';
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }
}
