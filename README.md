# Symfony conditional-routing-bundle

[![Build Status](https://travis-ci.org/piotrpolak/conditional-routing-bundle.svg)](https://travis-ci.org/piotrpolak/conditional-routing-bundle)
[![Code Climate](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/badges/gpa.svg)](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle)
[![Test Coverage](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/badges/coverage.svg)](https://codeclimate.com/github/piotrpolak/conditional-routing-bundle/coverage)

Provides a way to load selected Symfony bundle routes based on a set of user defined conditions.

Solves the problem of redirecting (overwriting) Symfony application routes from a base bundle to another bundle.

## Example usages

* Overwrite Symfony application routes for selected users and/or roles;
* Overwrite Symfony application routes based on the current time (e.g. switching monthly campaigns);
* Overwrite Symfony application routes based on session variable values;
* Overwrite Symfony application routes based on user role and HTTP domain.

## Installation

### Install composer package

```
composer require piotrpolak/conditional-routing-bundle
```

### Enable `PiotrpolakConditionalRoutingBundle` in the application kernel

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Piotrpolak\ConditionalRoutingBundle\PiotrpolakConditionalRoutingBundle(),
    // ...
);
```

### Include bundle routing

Including `routing.yml` will enable the `ConditionalRouterLoader`.

```yaml
# in app/config/routing.yml, without those lines ConditionalRouterLoader will not be enabled
conditional_routing:
    resource: "@PiotrpolakConditionalRoutingBundle/Resources/config/routing.yml"
    type:     yaml
```

> Symfony will only load the resource loader if you use it for at least one route. You can alternatively paste the
> contents of the above resource file directly in your `app/config/routing.yml`.

### Implement your own route resolver

**Route resolvers** are the components that implement `RouteResolverInterface` and decide which bundles' routing is
to be included at the request time.

A typical route resolver component is registered in the container configuration under the
`conditional_loader.route_resolver` tag - you can register any number of route resolver components and all of them will
be taken in account when selecting the combination of bundles to be included.

Since you can pass any other component to the route resolver constructor (like `@session`, `@security.token_storage`...)
bundles can be picked using any user defined scenarios.

### Example - date condition

The following example loads `MyCampaign2016Bundle` routing based on the year condition. **Note:** `MyCampaign2016Bundle`
must first be enabled in `AppKernel.php`.

> Please note that `AbstractYamlRouteResolver` is just a helper that makes use of `RouteResolverInterface` easier.

```php
<?php

namespace MyApp\Router;

use Piotrpolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class TimeCampaignRouteResolver extends AbstractYamlRouteResolver
{
    /**
     * {@inheritdoc}
     */
    public function resolveBundleNames()
    {
        // Loads @BaseCampaignBundle/Resources/config/routing.yml
        // In most cases it makes no sense to define bundle names that are ALWAYS loaded here as it can be done in the
        // app/config/routing.yml
        $bundleNames = ['BaseCampaignBundle'];
        if ((int)date('Y') >= 2016) {
            // Loads @MyCampaign2016Bundle/Resources/config/routing.yml
            // Can overwrite routes defined in BaseCampaignBundle or any other bundle
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

### Example - database value input

Reading the current bundle name from the database.

```php
<?php

namespace MyApp\Router;

use Doctrine\ORM\EntityManagerInterface;
use Piotrpolak\ConditionalRoutingBundle\Model\AbstractYamlRouteResolver;

class DatabaseCampaignRouteResolver extends AbstractYamlRouteResolver
{
    /** @var EntityManagerInterface */
    private $em;

    /**
     * CampaignRouteResolver constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveBundleNames()
    {
        // Loads @<CURRENT_BUNDLE_NAME>/Resources/config/routing.yml
        // Can overwrite any previously defined routes
        $bundleNames = [$this->getCurrentBundleName()];
        return $bundleNames;
    }

    /**
     * @return string
     */
    protected function getCurrentBundleName()
    {
        // Suppose you have a an entity having two fields: key and value
        // You might want to add some kind of cache to avoid reading from DB at every request
        return $this->em->getRepository('MyApp:Parameter')
                ->findOneBy(['key' => 'currentBundle'])
                ->getValue();
    }
}
```

```yaml
# in services.yml
services:
    # ...
    my_app.database_campaign_route_resolver:
        class: MyApp\DatabaseCampaignRouteResolver
        arguments: ['@doctrine.orm.entity_manager']
        tags:
            - { name: conditional_loader.route_resolver }
```

### Example - loading routing of various types

Route resolver from the following example implements directly the `RouteResolverInterface` and loads routing of both
YAML and XML types.

```php
<?php

namespace MyApp\Router;

use Piotrpolak\ConditionalRoutingBundle\Model\RouteResolverInterface;
use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\XmlBundleRoutingDefinition;
use Piotrpolak\ConditionalRoutingBundle\Model\RoutingDefinition\YamlBundleRoutingDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VariousTypesCampaignRouteResolver implements RouteResolverInterface
{
    /** @var EntityManagerInterface */
    private $em;
    /** @var SessionInterface */
    private $session;

    /**
     * VariousTypesCampaignRouteResolver constructor.
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * {@inheritdoc}
     */
    public function resolveConditionalRoutingDefinitions()
    {
        $definitions = [];

        // Overwrites homepage for the first visit
        $numberOfHits = $this->session->get('my_app.number_of_visits', 0);
        $this->session->set('my_app.number_of_visits', $numberOfHits + 1);
        if (0 === $numberOfHits) {
            $definitions[] = new YamlBundleRoutingDefinition('MyAppFirstVisitBundle');
        }

        // Disables some of the business critical routes based on the database value
        if ($this->em->getRepository('MyApp:Parameters')->findIsMaintenanceModeOn()) {
            $definitions[] = new XmlBundleRoutingDefinition('MyAppMaintenanceModeBundle');
        }

        return $definitions;
    }
}
```

```yaml
# in services.yml
services:
    # ...
    my_app.various_types_campaign_route_resolver:
        class: MyApp\VariousTypesCampaignRouteResolver
        arguments:
            - '@doctrine.orm.entity_manager'
            - '@session'
        tags:
            - { name: conditional_loader.route_resolver }
```

## Compatibility

* PHP 5.3+
* Symfony 2.3+

## Precautions

If you are trying to generate a link to a route that is not currently active, Symfony will throw an error.
To avoid situations like that please make sure all routes have their default behavior defined in one of you base bundles.

## Known issues

Warming up the Symfony cache will nor remove the custom router matchers and generators as we are not able to predict the
final combination of the router-enabled bundles (they are only known at the runtime).

A workaround to clean up the cache would be to add the following commands to your deploy scripts:

*   Symfony 2
    ```sh
    rm -f ./app/cache/*/*UrlGenerator__*.php* && rm -f ./app/cache/*/*UrlMatcher__*.php*
    ```

*   Symfony 3
    ```sh
    rm -f ./var/*/cache/*UrlGenerator__*.php* && rm -f ./var/*/cache/*UrlMatcher__*.php*
    ```