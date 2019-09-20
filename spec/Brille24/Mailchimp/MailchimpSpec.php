<?php

namespace spec\Brille24\Mailchimp;

use Brille24\Mailchimp\Mailchimp;
use Brille24\Mailchimp\MailchimpInterface;
use Brille24\Mailchimp\Objects\Data\DataInterface;
use Brille24\Mailchimp\Objects\Enumeration\RequestMethod;
use Brille24\Mailchimp\Objects\Request\RequestInterface;
use Brille24\Mailchimp\Objects\Security\Credentials;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\ResponseInterface;

class MailchimpSpec extends ObjectBehavior
{
    public function let(Client $client, Credentials $credentials)
    {
        $this->beConstructedWith($client, $credentials);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType(Mailchimp::class);
    }

    public function it_implements()
    {
        $this->shouldImplement(MailchimpInterface::class);
    }

    public function it_has_credentials(Credentials $credentials)
    {
        $this->getCredentials()->shouldReturn($credentials);
    }

    public function it_executes_a_request_without_parameters(
        RequestInterface $request,
        ResponseInterface $response,
        ClientInterface $client,
        Credentials $credentials
    ): void {
        $credentials->getApiKey()->willReturn('api-key');
        $request->getBodyParameters()->willReturn(null);
        $request->getQueryParameters()->willReturn(null);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('primary');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/primary',
            ['auth' => ['anystring', 'api-key']]
        )->willReturn($response);

        $this->executeRequest($request)->shouldReturn($response);
    }

    public function it_executes_a_request_with_query_parameters(
        RequestInterface $request,
        ResponseInterface $response,
        ClientInterface $client,
        Credentials $credentials,
        DataInterface $queryParameters
    ): void {
        $credentials->getApiKey()->willReturn('api-key');
        $queryParameters->toRequestBody()->willReturn('some-query-parameters');
        $request->getBodyParameters()->willReturn(null);
        $request->getQueryParameters()->willReturn($queryParameters);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('primary');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/primary',
            ['auth' => ['anystring', 'api-key'], 'query' => 'some-query-parameters']
        )->willReturn($response);

        $this->executeRequest($request)->shouldReturn($response);
    }

    public function it_executes_a_request_with_body_parameters(
        RequestInterface $request,
        ResponseInterface $response,
        ClientInterface $client,
        Credentials $credentials,
        DataInterface $bodyParameters
    ): void {
        $credentials->getApiKey()->willReturn('api-key');
        $bodyParameters->toRequestBody()->willReturn('a-json-string');
        $request->getBodyParameters()->willReturn($bodyParameters);
        $request->getQueryParameters()->willReturn(null);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('primary');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/primary',
            ['auth' => ['anystring', 'api-key'], 'body' => 'a-json-string']
        )->willReturn($response);

        $this->executeRequest($request)->shouldReturn($response);
    }

    public function it_executes_a_request_with_body_and_query_parameters(
        RequestInterface $request,
        ResponseInterface $response,
        ClientInterface $client,
        Credentials $credentials,
        DataInterface $queryParameters,
        DataInterface $bodyParameters
    ): void {
        $credentials->getApiKey()->willReturn('api-key');
        $bodyParameters->toRequestBody()->willReturn('a-json-string');
        $queryParameters->toRequestBody()->willReturn('some-query-parameters');
        $request->getBodyParameters()->willReturn($bodyParameters);
        $request->getQueryParameters()->willReturn($queryParameters);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('primary');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/primary',
            ['auth' => ['anystring', 'api-key'], 'body' => 'a-json-string', 'query' => 'some-query-parameters']
        )->willReturn($response);

        $this->executeRequest($request)->shouldReturn($response);
    }

    public function it_throws_a_client_exception_if_the_request_was_malformed(
        RequestInterface $request,
        ResponseInterface $response,
        ClientException $clientException,
        ClientInterface $client,
        Credentials $credentials
    ): void {
        $clientException->getResponse()->willReturn($response);
        $credentials->getApiKey()->willReturn('api-key');
        $request->getBodyParameters()->willReturn(null);
        $request->getQueryParameters()->willReturn(null);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('non-existing');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/non-existing',
            ['auth' => ['anystring', 'api-key']]
        )->willThrow($clientException->getWrappedObject());

        $this->executeRequest($request)->shouldReturn($response);
    }

    public function it_throws_a_server_exception_if_mailchimp_encountered_an_issue(
        RequestInterface $request,
        ResponseInterface $response,
        ServerException $serverException,
        ClientInterface $client,
        Credentials $credentials
    ): void {
        $serverException->getResponse()->willReturn($response);
        $credentials->getApiKey()->willReturn('invalid-api-key');
        $request->getBodyParameters()->willReturn(null);
        $request->getQueryParameters()->willReturn(null);
        $request->getMethod()->willReturn(RequestMethod::byName('GET'));
        $request->getPrimaryResource()->willReturn('primary');

        $client->request(
            RequestMethod::byName('GET'),
            'https://key.api.mailchimp.com/3.0/primary',
            ['auth' => ['anystring', 'invalid-api-key']]
        )->willThrow($serverException->getWrappedObject());

        $this->executeRequest($request)->shouldReturn($response);
    }
}
