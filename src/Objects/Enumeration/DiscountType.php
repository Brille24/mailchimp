<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration;


use ValueObjects\Enum\Enum;

final class DiscountType extends Enum
{
    const FIXED = 'fixed';
    const PERCENTAGE = 'percentage';
}
