<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;

class MemberRequest extends Request
{
    /** @var ListRequest */
    protected $listRequest;

    /**
     * @param RequestMethod $method
     * @param RequestInterface $listRequest
     *
     * @return RequestInterface
     *
     * @throws \InvalidArgumentException
     */
    public static function fromListAndMethod(
        RequestMethod $method,
        RequestInterface $listRequest
    ): RequestInterface {

        if (!$listRequest instanceof ListRequest) {
            throw new \InvalidArgumentException(sprintf('A MemberRequest can only be executed with a ListRequest, %s given', get_class($listRequest)));
        }

        if (null === $listRequest->getIdentifier()) {
            throw new \InvalidArgumentException('A MemberRequest can only be used with a List-Identifier!');
        }

        $memberRequest = new self($method);
        $memberRequest->setListRequest($listRequest);

        return $memberRequest;
    }

    /**
     * @param RequestMethod $method
     * @param RequestInterface $listRequest
     * @param string|null $email
     *
     * @return RequestInterface
     */
    public static function fromListMethodAndEmail(
        RequestMethod $method,
        RequestInterface $listRequest,
        ?string $email = null
    ): RequestInterface {

        if (!$listRequest instanceof ListRequest) {
            throw new \InvalidArgumentException(sprintf('A MemberRequest can only be executed with a ListRequest, %s given', get_class($listRequest)));
        }

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