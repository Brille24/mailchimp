<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Audiences;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;

class ListRequest extends Request
{
    /** {@inheritdoc} */
    public static function fromMethod(
        RequestMethod $method
    ): RequestInterface {
        return new self($method);
    }

    /**
     * @param RequestMethod $method
     * @param string|null $listId
     *
     * @return RequestInterface
     */
    public static function fromMethodAndIdentifier(
        RequestMethod $method,
        ?string $listId = null
    ): RequestInterface {
        $listRequest = new self($method);
        $listRequest->setIdentifier($listId);

        return $listRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        $primaryResource = 'lists';
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }
}
