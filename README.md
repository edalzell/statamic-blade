# Blade Directives

[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package provides custom directives so you can easily access Statamic data in your Blade templates.

## Requirements

- PHP 7.4+
- Statamic v3

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

### Data

Use this when you have Statamic data but it's a `Value` object. This will return a keyed array with all the fields as string/ints/arrays (recursively).

```blade
@data($theValueObject)
    {{ $fieldYouWant }}
@enddata
```

### Entry

Gets all the data in an entry. In the example below the data is a replicator, so you have to walk through the sets.

```blade
@entry('the_collection_handle', 'entry-slug')
    @foreach($replicator as $set)
        <p>Type is {{ $set['type'] }}</p>
        @include("partials/{$set['type']}", $set)
    @endforeach
@endentry
```
### Forms

You can pass in the  same parameters that `{{ form:create }}` supports.
Any other parameters will be added to the `<form>` tag as attributes.

To access the errors, see the commented code below.

```blade
@form('contact_us', ['redirect'=> '/', 'error_redirect' => '', 'allow_request_redirect' => false, 'id' => 'form-id', 'class' => 'foo'])
    {{-- @if ($errors->getBag('form.contact_us')->messages())
        @foreach ($errors->getBag('form.contact_us')->messages() as $field => $messages)
                $messages is an array of messages
                alternatively you could loop through $errors->getBag('form.contact_us')->keys()
                and use $errors->getBag('form.contact_us')->first($key)
        @endforeach
    @endif --}}
Email: <input type="text" name="email" />
<button>Contact Us</button>
@endform
```

### Glide

Generates the glide image.

```blade
@glide('/assets/IMG_1325.jpeg', ['width' => 100])
    <p>URL is {{ $url }}</p>
    <img src="{{ $url }}">
    <p>Width is {{ $width }}</p>
    <p>Hight is {{ $height }}</p>
@endglide
```


### Globals

```blade
@globalset('footer')
    {{ $set_variable }}
@endglobalset

@globalset('footer', 'set_variable')
```

### Nav

```blade
@nav('footer')
    {{ $item['title'] }}
@endnav
```

You can use the [same parameters](https://statamic.dev/tags/nav#parameters) as the `nav` tag.

```blade
@nav('collection::pages', ['from' => '/', 'show_unpublished' => true, 'include_home' => true])
    {{ $item['title'] }}
@endnav
```

### Site

```blade
@site
    {{ $short_locale }}
@endsite
```

```blade
@site('short_locale')
```

## Taxonomy

```blade
@taxonomy('tags')
    <p>Title is {{ $term['title'] }}</p>
@endtaxonomy
```

## Testing

Run the tests with:

```bash
vendor/bin/phpunit
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email [addon-security@silentz.co](mailto:addon-security@silentz.co) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
