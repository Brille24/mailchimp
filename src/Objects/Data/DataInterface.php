<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;

interface DataInterface
{
    /**
     * Converts this into a string that can be send to Mailchimp API v3.0
     *
     * @return string
     */
    public function toRequestBody(): string;
}