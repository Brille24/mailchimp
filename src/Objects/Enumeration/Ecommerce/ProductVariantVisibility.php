<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Ecommerce;


use ValueObjects\Enum\Enum;

final class ProductVariantVisibility extends Enum
{
    const VISIBLE = 'visible';
    const INVISIBLE = 'invisible';
}
