# Symfony conditional-routing-bundle

Provides a way to load selected budnles routes based on a specific user defined conditions.

Solves a problem how to redirect Symfony application routes from base bundle to another bundle.

## Example usages
* Overwrite Symfony application routes for selected users
* Overwrite Symfony application routes based on the current time (e.g. switching monthly campaigns)

[![Build Status](https://travis-ci.org/piotrpolak/conditional-routing-bundle.svg)](https://travis-ci.org/piotrpolak/conditional-routing-bundle)
[![Code Climate](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/badges/gpa.svg)](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle)
[![Test Coverage](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/badges/coverage.svg)](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/coverage)

## Installation:

### Enable bundle in application kernel

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Piotrpolak\ConditionalRoutingBundle\PiotrpolakConditionalRoutingBundle(),
    // ...
);
```

### Include bundle routing

This will enable the `ConditionalRouterLoader`.

```yaml
# in app/config/routing.yml
conditional_routing:
    resource: "@PiotrpolakConditionalRoutingBundle/Resources/config/routing.yml"
    type:     yaml
```

## Known issues:

Warming up the Symfony cache will nor remove the custom router matchers and generators as we are not able to predict the
final combination of the router-enabled bundles (they are only known at the runtime).

A workaround to clean up the cache would be to add the following commands to your deploy scripts:

```sh
rm -f app/cache/*/*UrlGenerator__*.php* && rm -f app/cache/*/*UrlMatcher__*.php*
```