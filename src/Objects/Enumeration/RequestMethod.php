<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Enumeration;

use ValueObjects\Enum\Enum;

final class RequestMethod extends Enum
{
    const GET = "GET";
    const POST= "POST";
    const PATCH = "PATCH";
    const PUT = "PUT";
    const DELETE = "DELETE";
}