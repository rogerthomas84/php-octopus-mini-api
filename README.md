Octopus Mini API library
====

![CI](https://github.com/rogerthomas84/php-octopus-mini-api/actions/workflows/ci.yml/badge.svg?branch=master)

### Description...

This is a simple library, with a basic implementation of the Octopus API, as well as a small part of their GraphQL API.
It's original purpose was primarily to serve as a documentation of how to retrieve the live consumption data from the
Octopus Energy GraphQL API, but has since been expanded to include some other basic functionality, such as retrieval
of half-hourly consumption data, as well as account information.

In order to retrieve the live consumption data, you must have an Octopus Mini device, and (obviously) you need to have
an account with Octopus Energy. If you have an Octopus account, but don't have a Mini device, you can request a free
one from Octopus Energy [here](https://octopus.typeform.com/to/B5ifg5rQ).

### Usage...

```
composer require rogerthomas84/php-octopus-mini-api
```

```php
$api = \Rt\OctopusAPI\OctopusApiSingleton::getInstance();
$apiInstance = $api->setEmail(
    getenv('OCTOPUS_EMAIL')
)->setPassword(
    getenv('OCTOPUS_PASSWORD')
)->setAccountNumber(
    getenv('OCTOPUS_ACCOUNT_NUMBER')
)->setApiKey(
    getenv('OCTOPUS_API_KEY')
)->setMpan(
    getenv('OCTOPUS_MPAN')
)->setSerialNumber(
    getenv('OCTOPUS_SERIAL_NUMBER')
);

$graphQl = $apiInstance->getOctopusGraphQL();

// $myToken = $graphQl->getToken();
// $meterDeviceId = $graphQl->getMeterDeviceId();
$consumption = $graphQl->getLiveConsumption();
// or you can pass the meterDeviceId directly:
// $consumption = $graphQl->getLiveConsumption($meterDeviceId);

echo 'Current consumption is ' . $consumption . 'W\n';

$myAccount = $apiInstance->getAccount();
echo 'You have ' . count($myAccount->getProperties()) . ' properties on your account\n';

$myProperty = $myAccount->getProperties()[0];
echo 'The first property on your account is ' . $myProperty->getAddressLine1() . "\n";

$myMeter = $myProperty->getElectricityMeterPoints()[0];
echo 'The first electricity meter point on your property is ' . $myMeter->getMpan() . "\n";

$myAgreement = $myMeter->getAgreements()[0];
echo 'My tariff code is ' . $myAgreement->getTariffCode() . "\n";

```

### Testing...

To test this, you'll need to set the following environment variables:
  * `OCTOPUS_EMAIL`
  * `OCTOPUS_PASSWORD`
  * `OCTOPUS_ACCOUNT_NUMBER`
  * `OCTOPUS_API_KEY`
  * `OCTOPUS_MPAN`
  * `OCTOPUS_SERIAL_NUMBER`

Then run the following commands:

```
composer install
./vendor/bin/phpunit
```
