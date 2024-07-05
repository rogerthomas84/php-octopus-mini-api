Octopus Mini API library
====

### Description...

This is a simple library, primarily to serve as a documentation of how to retrieve the live consumption data from the
Octopus Energy GraphQL API.

The core purpose of this library will only function if you have an Octopus Mini device, and you have an account with
Octopus Energy.

### Usage...

```
composer require rogerthomas84/php-octopus-mini-api
```

```php
$singleton = \Rt\OctopusAPI\OctopusApiSingleton::getInstance()->setEmail(
    getenv('OCTOPUS_EMAIL')
)->setPassword(
    getenv('OCTOPUS_PASSWORD')
)->setAccountNumber(
    getenv('OCTOPUS_ACCOUNT_NUMBER')
);

$graphQl = $singleton->getOctopusGraphQL();

// $myToken = $graphQl->getToken();
// $meterDeviceId = $graphQl->getMeterDeviceId();
$consumption = $graphQl->getLiveConsumption();
// or you can pass the meterDeviceId directly:
// $consumption = $graphQl->getLiveConsumption($meterDeviceId);

echo 'Current consumption is ' . $consumption . 'W\n';

```

### Testing...

To test this, you'll need to set the following environment variables:
  * `OCTOPUS_EMAIL`
  * `OCTOPUS_PASSWORD`
  * `OCTOPUS_ACCOUNT_NUMBER`

Then run the following commands:

```
composer install
./vendor/bin/phpunit
```
