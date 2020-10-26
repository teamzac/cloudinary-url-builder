# Fluent Cloudinary image transformations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/team-zac/cloudinary.svg?style=flat-square)](https://packagist.org/packages/team-zac/cloudinary)

Cloudinary is awesome but I wanted a more expressive way to apply transformations to an image than their official package provides. This is not a replacement for the official API client, it just provides a different way to generate image URLs based on the transformations you wish to apply. It also provides a way to create pre-defined groups of transformations as presets.

## Installation

You can install the package via composer:

```bash
composer require team-zac/cloudinary
```

## Usage

This package uses the official Cloudinary PHP library under the hood. If you're using Laravel, the service provider is auto-registered (5.5+) and will set a default cloud name on the Cloudinary package based on the value in this package's config. You can publish the config file with `php artisan vendor:publish` or just set `CLOUDINARY_CLOUD_NAME` in your .env file.

You can use the facade (or reference the `TeamZac\Cloudinary\Builder` class directly) to apply transformations and generate the URL.

``` php
Cloudinary::id('image.jpg')
	->resize(300, 450, 'crop')
	->removeRedEye()
	->sepia(30)
	->getUrl();
```

To build a pre-defined set of transformations, you can subclass the Builder class and override the `initializePreset` method. There, you can apply all the transformations you want. This method gets called during instantiation, so if you need to override the constructor (for DI or any other reasons) make sure to call this method or call `parent::__construct()`.

``` php
<?php

namespace App\Presets;

use TeamZac\Cloudinary\Builder;

class MyPreset extends Builder 
{
	protected function initializePreset()
	{
		$this->resize(300, 450, 'crop')
			->removeRedEye()
			->sepia(30);
	}	
}

```

You can instantiate your own preset classes directly, or you can extend the default builder in a service provider to name your presets, and then create a new instance using the `preset` method:

```php
// in a service provider
	public function boot() 
	{
		Cloudinary::extend('my-preset', function() {
			return new MyPreset();
		});
	}

// in your application code
	$url = Cloudinary::preset('my-preset')->id('image.jpg')->getUrl();
```

Most of the effects Cloudinary provides are either parameterless or just allow a single value. In some cases, the effects can be a bit more complex. For example, you can create an Outline effect using the `outline` method, with an optional callback to customize additional options:

```php
// with just the main options
Cloudinary::id('image.jpg')
	->outline('inner', 5, 1000);

// with a callback as the first parameter. Cloudinary's defaults will be used
Cloudinary::id('image.jpg')
	->outline(function(PendingOutline $outline) {
		$outline->mode('inner')
			->width(5)
			->color('orange');
	});

Cloudinary::id('image.jpg')
	->outline(function(PendingOutline $outline) {
		$outline->mode('outer')
			->width(5)
			->color('rgb', 'ae12d2');
	});

```

### Testing

``` bash
composer test
```


# todo

https://cloudinary.com/documentation/image_transformation_reference

- May add a PendingTint callback to reduce duplication between tint() and equalizedTint()
- maybe a dedicated Color class, since colors can either be provided as a string CSS name or "rgb:<hexcode>"
- several effects whose options are more involved have yet to be added to this package

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email chad@zactax.com instead of using the issue tracker.

## Credits

- [Chad Janicek](https://github.com/team-zac)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).