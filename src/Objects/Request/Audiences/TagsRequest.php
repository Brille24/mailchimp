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

class TagsRequest extends Request
{
    /** @var MemberRequest */
    protected $memberRequest;

    /**
     * @param RequestMethod $method
     * @param MemberRequest $memberRequest
     *
     * @return RequestInterface
     */
    public static function fromMethodAndMember(
        RequestMethod $method,
        MemberRequest $memberRequest
    ): RequestInterface {
        if (null === $memberRequest->getIdentifier()) {
            throw new InvalidArgumentException('A TagsRequest can only be used with a Member-Identifier!');
        }

        $tagsRequest = new self($method);
        $tagsRequest->setMemberRequest($memberRequest);

        return $tagsRequest;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        return sprintf('%s/%s', $this->getMemberRequest()->getPrimaryResource(), 'tags');
    }

    /**
     * @return MemberRequest
     */
    public function getMemberRequest(): MemberRequest
    {
        return $this->memberRequest;
    }

    /**
     * @param MemberRequest $memberRequest
     */
    public function setMemberRequest(MemberRequest $memberRequest): void
    {
        $this->memberRequest = $memberRequest;
    }
}
