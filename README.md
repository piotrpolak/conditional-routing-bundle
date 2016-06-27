# Symfony conditional-routing-bundle

Provides a way to load selected Symfony bundle routes based on a set of user defined conditions.

Solves a problem of how to redirect Symfony application routes from base bundle to another bundle.

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

### Implement your own RouteResolver

The following example loads `MyCampaign2016Bundle` routing based on the year condition.
Please note that `AbstractYamlRouteResolver` is just a helper that makes use of `RouteResolverInterface` easier.

```php
<?php

namespace MyApp;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class CampaignRouteResolver extends AbstractYamlRouteResolver
{
    /**
     * @inheritdoc
     */
    public function resolveBundleNames()
    {
        $bundleNames = array();
        if ((int)date('Y') > 2016) {
            // Loads @MyCampaign2016Bundle/Resources/config/routing.yml
            $bundleNames[] = 'MyCampaign2016Bundle';
        }
        return $bundleNames;
    }
}
```

```yaml
# in services.yml
services:
    # ...
    my_app.campaign_route_resolver:
        class: MyApp\CampaignRouteResolver
        tags:
            - { name: conditional_loader.route_resolver }
```

## Known issues:

Warming up the Symfony cache will nor remove the custom router matchers and generators as we are not able to predict the
final combination of the router-enabled bundles (they are only known at the runtime).

A workaround to clean up the cache would be to add the following commands to your deploy scripts:

```sh
rm -f app/cache/*/*UrlGenerator__*.php* && rm -f app/cache/*/*UrlMatcher__*.php*
```