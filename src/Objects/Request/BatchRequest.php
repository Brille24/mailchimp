<?php

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;

class BatchRequest extends Request
{
    /** {@inheritdoc} */
    public static function fromMethod(
        RequestMethod $method
    ): RequestInterface {
        return new self($method);
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        $primaryResource = 'batches';
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }
}
