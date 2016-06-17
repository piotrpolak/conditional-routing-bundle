# Symfony conditional-routing-bundle

Provides a way to selectively load Symfony bundle routes based on a set of user defined conditions.

[![Build Status](https://travis-ci.org/piotrpolak/conditional-routing-bundle.svg)](https://travis-ci.org/piotrpolak/conditional-routing-bundle)

## Installation:

* Enable `PiotrpolakConditionalRoutingBundle` in `AppKernel.php`
* Include `conditional-routing-bundle/Resources/config/routing.yml` in your routing, this will enable the custom route loader

## Known issues:

Warming up the Symfony cache will nor remove the custom Router mathes and Generators.
A workaround would be to add the following commands to your deploy scripts:

```bash
rm -f app/cache/*/*UrlGenerator__*.php* && rm -f app/cache/*/*UrlMatcher__*.php*
```