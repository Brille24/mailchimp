<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;

class Request implements RequestInterface
{
    /** @var RequestMethod */
    protected $method;

    /** @var string|null */
    protected $identifier;

    /** @var DataInterface */
    protected $bodyParameters;

    /** @var DataInterface */
    protected $queryParameters;

    /**
     * Request constructor.
     *
     * @param RequestMethod $method
     */
    public function __construct(RequestMethod $method)
    {
        $this->method = $method;
    }

    /** {@inheritdoc} */
    public static function fromMethod(RequestMethod $method): RequestInterface
    {
        return new self($method);
    }

    /** {@inheritdoc} */
    public function getMethod(): RequestMethod
    {
        return $this->method;
    }

    /** {@inheritdoc} */
    public function getPrimaryResource(): string
    {
        // This equals to the root-level request of the Mailchimp API v3.0
        return '';
    }

    /** {@inheritdoc} */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    /** {@inheritdoc} */
    public function setIdentifier(?string $identifier): void
    {
        $this->identifier = $identifier;
    }

    /** {@inheritdoc} */
    public function getBodyParameters(): ?DataInterface
    {
        return $this->bodyParameters;
    }

    /** {@inheritdoc} */
    public function setBodyParameters(DataInterface $bodyParameters): void
    {
        if ($this->getMethod()->sameValueAs(RequestMethod::byName('GET'))
            || $this->getMethod()->sameValueAs(RequestMethod::byName('DELETE'))) {
            throw new \InvalidArgumentException('Cannot use body on GET or DELETE requests');
        }

        $this->bodyParameters = $bodyParameters;
    }

    /** {@inheritdoc} */
    public function getQueryParameters(): ?DataInterface
    {
        return $this->queryParameters;
    }

    /** {@inheritdoc} */
    public function setQueryParameters(DataInterface $queryParameters): void
    {
        $this->queryParameters = $queryParameters;
    }
}