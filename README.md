# Mark URLs as deprecated via HTTP response headers

[![Latest Version on Packagist](https://img.shields.io/packagist/v/wizofgoz/deprecation-laravel.svg?style=flat-square)](https://packagist.org/packages/wizofgoz/deprecation-laravel)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/wizofgoz/deprecation-laravel/run-tests?label=tests)](https://github.com/wizofgoz/deprecation-laravel/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/wizofgoz/deprecation-laravel/Check%20&%20fix%20styling?label=code%20style)](https://github.com/wizofgoz/deprecation-laravel/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/wizofgoz/deprecation_laravel.svg?style=flat-square)](https://packagist.org/packages/wizofgoz/deprecation-laravel)

This package can be installed in a Laravel application to mark API endpoints as deprecated according to the [Deprecation HTTP Header Field](https://tools.ietf.org/id/draft-dalal-deprecation-header-01.html) draft.

## Installation

You can install the package via composer:

```bash
composer require wizofgoz/deprecation-laravel
```

## Usage
Apply the middleware everywhere you want to be able to send deprecation headers, most likely the global middleware stack in the HTTP kernel.
```php
protected $middleware = [
    \Wizofgoz\DeprecationLaravel\Http\Middleware\DeprecationAwareMiddleware::class,
];
```

During the course of the request life cycle, the resource that is being served can be marked as deprecated by using the facade, and the middleware will attach the appropriate headers to the response. 
```php
use \Wizofgoz\DeprecationLaravel\Deprecated;
use \Wizofgoz\DeprecationLaravel\Facades\Deprecation;
use \Wizofgoz\DeprecationLaravel\Links\AlternateLink;
use \Wizofgoz\DeprecationLaravel\Links\LatestLink;
use \Wizofgoz\DeprecationLaravel\Links\SuccessorLink;

// The resource is simply deprecated
$deprecated = Deprecated::new();

// The resource will be deprecated at a certain date
$deprecated = Deprecated::new()->setDate(new Carbon());

// Add a link to an alternate resource that could be used
$deprecated->addLink(new AlternateLink('https://example.com/resource'));

// Add a link to the resource that is the successor of this one
$deprecated->addLink(new SuccessorLink('https://example.com/resource'));

// Add a link to the resource that is the latest version of this one
$deprecated->addLink(new LatestLink('https://example.com/resource'));

// Apply the deprecation setting to the container so the middleware can pick it up
Deprecation::deprecate($deprecated);

// Unset a deprecation that has been set already
Deprecation::deprecate(null);
```

To convey that a resource will stop receiving requests in the future, they can be marked as sunsetted.
```php
use \Wizofgoz\DeprecationLaravel\Sunset;
use \Wizofgoz\DeprecationLaravel\Facades\Deprecation;

$sunset = Sunset::new(new Carbon());

Deprecation::sunset($sunset);

// Unset a sunset that has been set already
Deprecation::sunset(null);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Wizofgoz](https://github.com/Wizofgoz)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
