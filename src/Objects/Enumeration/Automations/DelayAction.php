<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Automations;


use ValueObjects\Enum\Enum;

final class DelayAction extends Enum
{
    const SIGNUP = 'signup';
    const ABANDONED_BROWSE = 'ecomm_abandoned_browse';
    const ABANDONED_CART = 'ecomm_abandoned_cart';
}
