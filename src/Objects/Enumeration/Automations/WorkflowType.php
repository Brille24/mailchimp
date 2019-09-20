<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Automations;


use ValueObjects\Enum\Enum;

final class WorkflowType extends Enum
{
    const ABANDONED_CART = 'abandonedCart';
}
