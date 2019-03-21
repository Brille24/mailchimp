<?php
/**
 * @author Peter Ukena <peter.ukena@brille24.de>
 */

declare(strict_types=1);

namespace Brille24\Mailchimp;

use Brille24\Mailchimp\Objects\Security\Credentials;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\TransferStats;

class Mailchimp implements MailchimpInterface
{
    /** @var Client */
    private $client;

    /** @var Credentials */
    private $credentials;

    public function __construct(
        Client $client,
        Credentials $credentials
    )
    {
        $this->client = $client;
        $this->credentials = $credentials;
    }

    /**
     * @return Credentials
     */
    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    /**
     * Actually submits the request to mailchimp.
     *
     * @param RequestInterface $request
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @return Response
     */
    public function executeRequest(RequestInterface $request): Response
    {
        // @TODO Handle things like "does this mail exist"
        // @TODO Decide on how to be intelligently updating/creating, etc
        $requestConfiguration = ['auth' => ['anystring', $this->getCredentials()->getApiKey()]];
        if (null !== $request->getBodyParameters()) {
            $requestConfiguration['body'] = $request->getBodyParameters()->toRequestBody();
        }

        if (null !== $request->getQueryParameters()) {
            $requestConfiguration['query'] = $request->getQueryParameters()->toRequestBody();
        }

        try {
            $response = $this->client->request(
                $request->getMethod(),
                $this->generateRequestUrl($request),
                $requestConfiguration
            );
        } catch (ClientException $clientException) {
            $response = $clientException->getResponse();
        } catch (ServerException $serverException) {
            $response = $serverException->getResponse();
        }

        return $response;
    }

    /**
     * Delivers the base URL for any API call towards Mailchimp
     *
     * @param string $version
     *
     * @return string
     */
    private function getMailchimpUrl(string $version = "3.0"): string
    {
        $dataCenter = explode('-', $this->getCredentials()->getApiKey());

        return sprintf('https://%s.api.mailchimp.com/%s', end($dataCenter), $version);
    }

    /**
     * Generates the URL for a specific mailchimp request.
     *
     * @param RequestInterface $request
     *
     * @return string
     */
    private function generateRequestUrl(RequestInterface $request)
    {
        return sprintf('%s/%s', $this->getMailchimpUrl(), $request->getPrimaryResource());
    }
}