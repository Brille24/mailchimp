<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Data;

use ValueObjects\Structure\Dictionary;
use ValueObjects\Structure\KeyValuePair;

final class QueryParameters extends Dictionary implements DataInterface
{
    /** {@inheritdoc} */
    public function toRequestBody(): string
    {
        return implode('&', $this->toRequestBodyArray());
    }

    /** {@inheritdoc} */
    public function toRequestBodyArray(): array
    {
        $queryString = [];
        /** @var KeyValuePair $queryParameter*/
        foreach ($this->toArray() as $queryParameter) {
            $queryString[] = sprintf('%s=%s', $queryParameter->getKey(), $queryParameter->getValue());
        }

        return $queryString;
    }
}
