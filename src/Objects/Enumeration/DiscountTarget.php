<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration;


use ValueObjects\Enum\Enum;

final class DiscountTarget extends Enum
{
    const PER_ITEM = 'per_item';
    const TOTAL = 'total';
    const SHIPPING = 'shipping';
}
