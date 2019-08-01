<?php

namespace spec\Brille24\Mailchimp\Objects\Request\Automations;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Automations\AutomationRequest;
use Brille24\Mailchimp\Objects\Request\Automations\EmailRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;

class EmailRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $automationRequest = AutomationRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'automation-ident');

        $this->beConstructedThrough('fromAutomationAndMethod', [$automationRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(EmailRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('automations/automation-ident/emails');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        AutomationRequest $automationRequest
    ): void {
        $automationRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('An EmailRequest can only be used with an Automation-Identifier!')
        )->during(
            'fromAutomationAndMethod',
            [$automationRequest, RequestMethod::byName('GET')]
        );
    }
}
