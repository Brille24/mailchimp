<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp;

use Brille24\Mailchimp\Objects\Request\RequestInterface;

interface MailchimpInterface
{
    public function executeRequest(RequestInterface $request);
}