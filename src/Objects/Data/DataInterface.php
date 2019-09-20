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
     *
     * @throws \Exception
     */
    public function toRequestBody(): string;

    /**
     * Converts this into an arry that can be used by other data objects
     *
     * @return array
     */
    public function toRequestBodyArray(): array;
}
