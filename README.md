## Brille24 Mailchimp Library
This library is intended to be used with the brille24/mailchimp-symfony-bundle which provides Mailchimp API v3.0 functionality.

## Currently implemented features
* Reading, Creating and Updating Mailchimp Lists
* Reading, Creating and Updating Mailchimp List-Members

## Tests

```bash
composer install
php vendor/bin/phpspec run
```

## Examples
```php
// Getting all lists
$listRequest = ListRequest::fromMethod(RequestMethod::byName('GET'));
// Getting a specific list
$listRequest = ListRequest::fromMethodAndIdentifier(RequestMethod::byName('GET'), "your_list_id");

// Getting all members from a list.
$memberRequest = MemberRequest::fromListAndMethod(RequestMethod::byName('GET'), $listRequest);

// Getting a specific member of a list.
$memberRequest = MemberRequest::fromListMethodAndEmail(
    RequestMethod::byName('GET'),
    $listRequest,
    'some@email_address.tld'
);

// Updating or creating a new member in a list.
// 1. Make a list and member request.
// 2. Add body parameters.
$bodyParameters = new MemberData();
$bodyParameters->setEmailAddress("some@email_address.tld");
$bodyParameters->setStatus(MemberStatus::byName('PENDING'));
$bodyParameters->setLanguage(MemberLanguage::byName('English'));
// ... there can me more fields in your Mailchimp lists,
$bodyParameters->setMergeFields(['FNAME' => 'Some', 'LNAME' => 'Dude']);
$memberRequest->setBodyParameters($bodyParameters);

// Alternatively or additionally, add query parameters to your requests for filtering response data.
/** @var $queryParameters QueryParameters*/
$queryParameters = QueryParameters::fromNative(['fields' => 'email_address', 'count' => 10]);
$memberRequest->setQueryParameters($queryParameters);

// Execute Request
$credentials = new Credentials('your_api_key_here');
// This uses the guzzle HTTP client library.
$mailchimp = new Mailchimp(new Client(), $credentials);
try {
    $response = $mailchimp->executeRequest($memberRequest);
    echo (string) $response->getBody();
} catch (\Throwable $throwable) {
    // This throws every exception that guzzle will throw.
}
```