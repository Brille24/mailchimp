<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration\Audiences;

use ValueObjects\Enum\Enum;

final class MemberStatus extends Enum
{
    const SUBSCRIBED = 'subscribed';
    const UNSUBSCRIBED = 'unsubscribed';
    const CLEANED = 'cleaned';
    const PENDING = 'pending';
}
