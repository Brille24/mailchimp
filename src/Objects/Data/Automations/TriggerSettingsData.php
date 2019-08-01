<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data\Automations;


use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\Automations\WorkflowType;
use ErrorException;

final class TriggerSettingsData implements DataInterface
{
    /** @var WorkflowType */
    private $workflowType;

    public function __construct()
    {
        // Currently only supports this one type
        $this->workflowType = WorkflowType::byValue('abandonedCart');
    }

    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        $body = json_encode($this->toRequestBodyArray());
        if ($body === false) {
            throw new ErrorException('Trigger settings data could not be encoded to json');
        }

        return $body;
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $bodyParameters = [
            'workflow_type' => $this->workflowType->getValue(),
        ];

        return array_filter($bodyParameters, function($value) {
            return null !== $value;
        });
    }

    /**
     * @return WorkflowType
     */
    public function getWorkflowType(): WorkflowType
    {
        return $this->workflowType;
    }

    /**
     * @param WorkflowType $workflowType
     */
    public function setWorkflowType(WorkflowType $workflowType): void
    {
        $this->workflowType = $workflowType;
    }
}
