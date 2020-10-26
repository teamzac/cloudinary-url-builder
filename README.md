# Fluent Cloudinary image transformations

[![Latest Version on Packagist](https://img.shields.io/packagist/v/team-zac/cloudinary-builder.svg?style=flat-square)](https://packagist.org/packages/team-zac/cloudinary)

Cloudinary is awesome but I wanted a more expressive way to apply transformations to an image than their official package provides. This is not a replacement for the official API client, it just provides a different way to generate image URLs based on the transformations you wish to apply. It also provides a way to create pre-defined groups of transformations as presets.

## Installation

You can install the package via composer:

```bash
composer require team-zac/cloudinary-url-builder
```

## Usage

This package uses the official Cloudinary PHP library under the hood, which has a variety of global config options. If you are using Laravel, the auto-registered service provider for this package will set the default cloud name for you based on the value in this package's config.

You can set this value by adding a key for `CLOUDINARY_CLOUD_NAME` to your .env file. If you'd like to take ownership of the package's config file, you can run the following command:

```bash
php artisan vendor:publish
```

and choose the `TeamZac\Cloudinary\ServiceProvider` option.

The core functionality is provided with the `TeamZac\Cloudinary\Builder` class. You can access it directly, or utilize the facade, to apply transformations and generate an image URL.

``` php
Cloudinary::id('image.jpg')
	->resize(300, 450, 'crop')
	->removeRedEye()
	->sepia(30)
	->getUrl();
```

To build a pre-defined set of transformations, you can subclass the Builder class and override the `initializePreset` method. There, you can apply all the transformations you want. This method gets called before building the URL, and only once in case you plan to reuse the same instance of your preset class.

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

You can instantiate your own preset classes directly, or you can extend the Builder in a service provider to name your presets. You can then create a new instance using the `preset` method:

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

This could be useful for something like a hero image on a blog, where you want a similar transformation to be applied to each image but might have a light and dark variant. You could store the transformation preset on the post model and dynamically refer to it in your template.

Most of the effects Cloudinary provides are either parameterless or just allow a single value. In many cases, we've included the same defaults that Cloudinary uses so you can exclude passing any parameters if you're fine with the defaults. We still need to add Cloudinary's defaults to some of the effect methods.

In some cases, the effects can be a bit more complex. For example, you can create an Outline effect using the `outline` method, with an optional callback to customize additional options:

```php
// with just the main options
Cloudinary::id('image.jpg')
	->outline('inner', 5, 1000);

// with a callback as the first parameter. You'll receive an instance of TeamZac\Cloudinary\Transformations\PendingOutline
Cloudinary::id('image.jpg')
	->outline(function($outline) {
		$outline->mode('inner')
			->width(5)
			->color('orange');
	});

Cloudinary::id('image.jpg')
	->outline(function($outline) {
		$outline->mode('outer')
			->width(5)
			->color('rgb:30a940');
	});

// you can also use the Color class if you prefer
Cloudinary::id('image.jpg')
  ->outline(function($outline) {
    $outline->mode('outer')
      ->width(5)
      ->color(TeamZac\Cloudinary\Color::hex('30a940'));
  });

```

### Testing

``` bash
composer test
```


# Todo

- several effects whose options are more involved have yet to be added to this package

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email chad@zactax.com instead of using the issue tracker.

## Credits

- [Chad Janicek](https://github.com/team-zac)
- [Laravel Package Boilerplate](https://laravelpackageboilerplate.com)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
