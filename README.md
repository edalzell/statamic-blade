# Blade Directives

<!-- statamic:hide -->
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
<!-- /statamic:hide -->

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

### Automatic augmentation of Statamic values

If you want values to be augmented automatically in your Blade views, you can replace the

`Illuminate\View\ViewServiceProvider::class` in the providers of your `config/app.php` with `\Edalzell\Blade\Augmentation\AugmentationViewServiceProvider`

This will replace all instances of `\Statamic\Fields\Value` by their augmented values.

### Antlers

If tag(), modify() or any of the below directives aren't achieving the desired outcome, it is possible to try the Antlers directive to render Antlers within Blade.

```blade
@antlers($str, $variables = [])
```

We do this by using the Antlers Facade and its parse method.
```php
\Statamic\Facades\Antlers::parse($str, $variables = [])
```

There are some things to note however, for these examples we will describe `$str` as the content or string that you wish to have Antlers parse into Html, while `$variables` is the context or data that will be passed to Antlers and is used to map variables and data to Antlers.

An example of this would be if we passed $str into our view,
```php
view('home', ['str' => "{{ 'foo' }}"]);
```
```blade
This will output foo.
@antlers($str)
```

But now if we instead remove the single quotes from foo, then we will need to provide the context of what foo is.
```php
view('home', [
    'str' => "{{ foo }}",
    'variables' = ['foo' => 'bar']
]);
```
```blade
This will output the value of foo that we assigned in the context, which would output bar.
@antlers($str, $variables)
```

It is also possible to use the directive inline.
If passing everything inline, then the Antlers content will need to have @ added to its curly braces. quotes will need to be escaped too.
```blade
This will output testing.
@antlers('@{{ test }}', ['test' => 'testing'])
```

You can also use @php blocks to define the content and or context.
```blade
@php
    $content = '{{ test | ucfirst }}';
    $context = ['test' => 'testing'];
@endphp

This will output Testing.
@antlers($content, $context)
```

This directive can be used in a bunch of different ways, let your imagination run wild! All you need to do is provide the content and then any context that it might need, how you get/set or provide those doesn't really matter that much.

### Assets

```blade
@asset('url/to/asset.jpg')
    URl: {{ $asset['url'] }}
    Permalink: {{ $asset['permalink'] }}
    Alt: {{ $asset['alt'] }}
    ...other fields
@endasset
```

### Breadcrumbs

```blade
@breadcrumbs
    $item['url']
@endbreadcrumbs
```

You can use the [same parameters](https://statamic.dev/tags/nav-breadcrumbs#parameters) as the `nav:breadcrumbs` tag.

```blade
@breadcrumbs(['include_home' => false, 'reverse' => true])
    $item['url']
@endbreadcrumbs
```

### Collection

Use the same params as the `{{ collection }}` tag

```blade
@collection('pages', ['title:is' => 'My Title', 'author:is' => 'Erin', 'limit' => 3, 'sort' => 'title:desc'])\
    @isset($entry['no_results'])
        <p>There are no results</p>
    @else
        {{ $entry['title'] }}
    @endisset
@endcollection
```

#### Collection Pagination
```blade
@collection('the_collection', ['limit' => 2, 'paginate' => true])
    @foreach($entry['entries'] as $entry)
        @data($entry)
            Title: {{ $title }}
        @enddata
    @endforeach
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

You can pass in the same parameters that `{{ form:create }}` supports.
Any other parameters will be added to the `<form>` tag as attributes.

To access the errors, use standard Blade [errors](https://laravel.com/docs/8.x/blade#validation-errors)
but pass in the proper error bag, which is `form.your-form-handle`.

```blade
@form('contact_us', ['redirect'=> '/', 'error_redirect' => '', 'allow_request_redirect' => false, 'id' => 'form-id', 'class' => 'foo'])
Email: <input type="text" name="email" />
@error('email', 'form.contact_us')
    <div>{{ $message }}</div>
@enderror
<button>Contact Us</button>
@endform
```

### Form Fields

Loops over the fields for a form.

```blade
@formfields('contact_us')
<label>{{ $field['display'] }}</label>
<input type="{{ $field['type'] }}" name="{{ $field['handle'] }}" placeholder="{{ $field['placeholder'] ?? '' }}" /> 
@endformfields
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

Use the same params as the `{{ taxonomy }}` tag

```blade
@taxonomy('tags', ['limit' => 6, 'sort' => 'entries_count:desc'])
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
