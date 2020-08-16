# Blade Directives
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides custom directives so you can easily access Statamic data in your Blade templates.

## Requirements

* PHP 7.4+
* Statamic v3

## Installation

You can install this package via composer using:

```bash
composer require edalzell/blade-directives
```

The package will automatically register itself.


## Usage

### Collection

```blade
 @collection('pages', ['where' => 'title:My Title,author:Erin', 'limit' => 3, 'orderBy' => 'title:desc'])
   {{ $entry['title'] }}
 @endcollection
```

### Bard

```blade
@collection('blade')
    @bard($entry['content'])
        <p>Type is {{ $set['type'] }}</p>
        @include("partials/{$set['type']}", [ 'data' => $set['content']])
    @endbard
@endcollection
```

### Globals

```blade
@globalset('footer')
    {{ $set_variable }}
@endglobalset

@globalset('footer', 'set_variable')
```

## Testing

Run the tests with:
```bash
vendor/bin/phpunit
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email [addon-security@silentz.co](mailto:addon-security@silentz.co) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
