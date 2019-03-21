<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp\Objects\Request;

use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;

interface RequestInterface
{
    /**
     * @param RequestMethod $method
     *
     * @return mixed
     */
    public static function fromMethod(RequestMethod $method);

    /**
     * @return RequestMethod
     */
    public function getMethod(): RequestMethod;

    /**
     * @return string
     */
    public function getPrimaryResource(): string;

    /**
     * @return string|null
     */
    public function getIdentifier(): ?string;

    /**
     * @param string $identifier
     */
    public function setIdentifier(string $identifier): void;

    /**
     * @return DataInterface
     */
    public function getBodyParameters(): ?DataInterface;

    /**
     * @param DataInterface $bodyParameters
     */
    public function setBodyParameters(DataInterface $bodyParameters): void;

    /**
     * @return DataInterface
     */
    public function getQueryParameters(): ?DataInterface;

    /**
     * @param DataInterface $queryParameters
     */
    public function setQueryParameters(DataInterface $queryParameters): void;
}