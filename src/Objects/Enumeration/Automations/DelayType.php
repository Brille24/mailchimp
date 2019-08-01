<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Automations;


use ValueObjects\Enum\Enum;

final class DelayType extends Enum
{
    const NOW = 'now';
    const DAY = 'day';
    const HOUR = 'hour';
    const WEEK = 'week';
}
