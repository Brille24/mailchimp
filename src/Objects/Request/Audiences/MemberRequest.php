<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request\Audiences;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\Request;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use InvalidArgumentException;

class MemberRequest extends Request
{
    /**
     * @param ListRequest $listRequest
     * @param RequestMethod $method
     *
     * @return RequestInterface
     *
     * @throws InvalidArgumentException
     */
    public static function fromListAndMethod(
        ListRequest $listRequest,
        RequestMethod $method
    ): RequestInterface {
        if (null === $listRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A MemberRequest can only be used with a List-Identifier!');
        }

        $memberRequest = new self($method);
        $memberRequest->setListRequest($listRequest);

        return $memberRequest;
    }

    /** @var ListRequest */
    protected $listRequest;

    /**
     * @param ListRequest $listRequest
     * @param RequestMethod $method
     * @param string|null $email
     *
     * @return RequestInterface
     */
    public static function fromListMethodAndEmail(
        ListRequest $listRequest,
        RequestMethod $method,
        ?string $email = null
    ): RequestInterface {
        if (null === $listRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A MemberRequest can only be used with a List-Identifier!');
        }

        $memberRequest = new self($method);
        $memberRequest->setListRequest($listRequest);

        if (null !== $email) {
            $memberRequest->setIdentifier(hash('md5', strtolower($email)));
        }

        return $memberRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // Combine list-request resource with member-request resource
        $primaryResource = sprintf('%s/%s', $this->getListRequest()->getPrimaryResource(), 'members');
        if (null !== $this->getIdentifier()) {
            $primaryResource = sprintf('%s/%s', $primaryResource, $this->getIdentifier());
        }

        return $primaryResource;
    }

    /** @return ListRequest */
    public function getListRequest(): ListRequest
    {
        return $this->listRequest;
    }

    /** @param ListRequest $listRequest */
    public function setListRequest(ListRequest $listRequest): void
    {
        $this->listRequest = $listRequest;
    }
}
