<?php

namespace TeamZac\Cloudinary\Tests;

use Orchestra\Testbench\TestCase;
use TeamZac\Cloudinary\CloudinaryImage;
use TeamZac\Cloudinary\Facades\Cloudinary;
use TeamZac\Cloudinary\ServiceProvider;
use TeamZac\Cloudinary\Tests\Fixtures\ExamplePreset;

class PresetsTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    public function setUp(): void
    {
    	Cloudinary::extend('test', function() {
    		return new ExamplePreset;
    	});
    }

    /** @test */
    public function a_builder_can_apply_presets() 
    {
    	$image = Cloudinary::preset('test')
    		->id('test.png');

        $this->assertCorrectTransformations(
        	'e_auto_brightness/e_blue:50/e_pixelate:20', 
        	$image
        );
    }

    protected function assertCorrectTransformations($correct, $image)
    {
        $this->assertSame(
            sprintf('http://res.cloudinary.com/testing/image/upload/%s/%s', $correct, $image->getId()),
            $image->getUrl()
        );
    }
}