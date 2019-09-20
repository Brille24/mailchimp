<?php

namespace spec\Brille24\Mailchimp\Objects\Request\Automations;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Automations\AutomationRequest;
use Brille24\Mailchimp\Objects\Request\Automations\EmailRequest;
use Brille24\Mailchimp\Objects\Request\Automations\QueueRequest;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use PhpSpec\ObjectBehavior;

class QueueRequestSpec extends ObjectBehavior
{
    public function let(): void
    {
        $automationRequest = AutomationRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), 'automation-ident');
        $emailRequest      = EmailRequest::fromAutomationMethodAndId($automationRequest, RequestMethod::byName('GET'), 'email-ident');

        $this->beConstructedThrough('fromEmailAndMethod', [$emailRequest, RequestMethod::byName('GET')]);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(QueueRequest::class);
    }

    public function it_implements(): void
    {
        $this->shouldImplement(RequestInterface::class);
    }

    public function it_will_produce_an_executable_request(): void
    {
        $this->getPrimaryResource()->shouldReturn('automations/automation-ident/emails/email-ident/queue');
    }

    public function it_throws_an_exception_if_a_primary_resource_has_no_identifier(
        EmailRequest $emailRequest
    ): void {
        $emailRequest->getIdentifier()->willReturn(null);
        $this->shouldThrow(
            new \InvalidArgumentException('A QueueRequest can only be used with an Email-Identifier!')
        )->during(
            'fromEmailAndMethod',
            [$emailRequest, RequestMethod::byName('GET')]
        );
    }
}
