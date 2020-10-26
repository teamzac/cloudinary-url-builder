<?php

namespace TeamZac\Cloudinary\Tests;

use Orchestra\Testbench\TestCase;
use TeamZac\Cloudinary\Builder;
use TeamZac\Cloudinary\Color;
use TeamZac\Cloudinary\Facades\Cloudinary;
use TeamZac\Cloudinary\ServiceProvider;

class BuilderTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    /** @test */
    public function the_builder_sets_the_proper_image_id_when_building()
    {
        $image = Cloudinary::id('test.png');

        $this->assertInstanceOf(Builder::class, $image);
        $this->assertSame('test.png', $image->getId());
    }

    /** @test */
    public function resize_fill_mode()
    {
        $image = Cloudinary::id('test.png')
            ->resize(300, 300, 'fill');

        $this->assertCorrectTransformations('c_fill,h_300,w_300', $image);
    }

    /** @test */
    public function resize_scale_mode()
    {
        $image = Cloudinary::id('test.png')
            ->resize(300, 400);

        $this->assertCorrectTransformations('c_scale,h_400,w_300', $image);
    }

    /** @test */
    public function brightness()
    {
        $image = Cloudinary::id('test.png')
            ->brightness(50);

        $this->assertCorrectTransformations('e_brightness:50', $image);
    }

    /** @test */
    public function color()
    {
        $image = Cloudinary::id('test.png')
            ->color('saturation', 50);

        $this->assertCorrectTransformations('e_saturation:50', $image);
    }

    /** @test */
    function outline()
    {
        $image = Cloudinary::id('test.png')
            ->outline('inner', 5, 1000);

        $this->assertCorrectTransformations('e_outline:inner:5:1000', $image);
    }

    /** @test */
    function outlines_with_callback()
    {
        $image = Cloudinary::id('test.png')
            ->outline(function($outline) {
                $outline->width(5)
                    ->blur(1000)
                    ->color('orange');
            });
        $this->assertCorrectTransformations('e_outline:inner:5:1000,co_orange', $image);
    }

    /** @test */
    function outlines_with_callback_using_named_color()
    {
        $image = Cloudinary::id('test.png')
            ->outline(function($outline) {
                $outline->width(5)
                    ->blur(1000)
                    ->color(Color::named('orange'));
            });
        $this->assertCorrectTransformations('e_outline:inner:5:1000,co_orange', $image);
    }

    /** @test */
    function outlines_with_callback_using_rgb()
    {
        $image = Cloudinary::id('test.png')
            ->outline(function($outline) {
                $outline->mode('outer')
                    ->blur(1000)
                    ->color(Color::hex(777));
            });
        $this->assertCorrectTransformations('e_outline:outer:5:1000,co_rgb:777', $image);
    }

    /** @test */
    function tint()
    {
        $image = Cloudinary::id('test.png')
            ->tint(40, 'red', 'blue');

        $this->assertCorrectTransformations('e_tint:40:red:blue', $image);
    }

    /** @test */
    function equalizedTint()
    {
        $image = Cloudinary::id('test.png')
            ->equalizedTint(40, 'red', 'blue');

        $this->assertCorrectTransformations('e_tint:equalize:40:red:blue', $image);
    }

    /** @test */
    public function blur()
    {
        $image = Cloudinary::id('test.png')
            ->blur(250);

        $this->assertCorrectTransformations('e_blur:250', $image);
    }

    /** @test */
    public function blurFaces()
    {
        $image = Cloudinary::id('test.png')
            ->blurFaces(250);

        $this->assertCorrectTransformations('e_blur_faces:250', $image);
    }

    /** @test */
    public function blurRegion()
    {
        $image = Cloudinary::id('test.png')
            ->blurRegion(250);

        $this->assertCorrectTransformations('e_blur_region:250', $image);
    }

    /** @test */
    public function removeBackground()
    {
        $image = Cloudinary::id('test.png')
            ->removeBackground();

        $this->assertCorrectTransformations('e_bgremoval', $image);
    }

    /** @test */
    public function accelerate()
    {
        $image = Cloudinary::id('test.png')
            ->accelerate(50);

        $this->assertCorrectTransformations('e_accelerate:50', $image);
    }

    /** @test */
    public function removeRedEye()
    {
        $image = Cloudinary::id('test.png')
            ->removeRedEye();

        $this->assertCorrectTransformations('e_adv_redeye', $image);
    }

    /** @test */
    public function assistColorblind()
    {
        $image = Cloudinary::id('test.png')
            ->assistColorblind(20);

        $this->assertCorrectTransformations('e_assist_colorblind:20', $image);
    }

    /** @test */
    public function autoBrightness()
    {
        $image = Cloudinary::id('test.png')
            ->autoBrightness();

        $this->assertCorrectTransformations('e_auto_brightness', $image);
    }

    /** @test */
    public function autoColor()
    {
        $image = Cloudinary::id('test.png')
            ->autoColor();

        $this->assertCorrectTransformations('e_auto_color', $image);
    }

    /** @test */
    public function autoContrast()
    {
        $image = Cloudinary::id('test.png')
            ->autoContrast();

        $this->assertCorrectTransformations('e_auto_contrast', $image);
    }

    /** @test */
    public function autoSaturation()
    {
        $image = Cloudinary::id('test.png')
            ->autoSaturation();

        $this->assertCorrectTransformations('e_auto_saturation', $image);
    }

    /** @test */
    public function blackwhite()
    {
        $image = Cloudinary::id('test.png')
            ->blackwhite();

        $this->assertCorrectTransformations('e_blackwhite', $image);
    }

    /** @test */
    public function blue()
    {
        $image = Cloudinary::id('test.png')
            ->blue(50);

        $this->assertCorrectTransformations('e_blue:50', $image);
    }

    /** @test */
    public function boomerang()
    {
        $image = Cloudinary::id('test.png')
            ->boomerang();

        $this->assertCorrectTransformations('e_boomerang', $image);
    }

    /** @test */
    public function brightnessHsb()
    {
        $image = Cloudinary::id('test.png')
            ->brightnessHsb();

        $this->assertCorrectTransformations('e_brightness_hsb', $image);
    }

    /** @test */
    public function cartoonify()
    {
        $image = Cloudinary::id('test.png')
            ->cartoonify();

        $this->assertCorrectTransformations('e_cartoonify', $image);
    }

    /** @test */
    public function colorize()
    {
        $image = Cloudinary::id('test.png')
            ->colorize(50);

        $this->assertCorrectTransformations('e_colorize:50', $image);
    }

    /** @test */
    public function contrast()
    {
        $image = Cloudinary::id('test.png')
            ->contrast(50);

        $this->assertCorrectTransformations('e_contrast:50', $image);
    }

    /** @test */
    public function deshake()
    {
        $image = Cloudinary::id('test.png')
            ->deshake(50);

        $this->assertCorrectTransformations('e_deshake:50', $image);
    }

    /** @test */
    public function displace()
    {
        $image = Cloudinary::id('test.png')
            ->displace();

        $this->assertCorrectTransformations('e_displace', $image);
    }

    /** @skip */
    public function distort()
    {

    }

    /** @test */
    public function enhance()
    {
        $image = Cloudinary::id('test.png')
            ->enhance();

        $this->assertCorrectTransformations('e_viesus_correct', $image);
    }

    /** @test */
    public function fade()
    {
        $image = Cloudinary::id('test.png')
            ->fade(200);

        $this->assertCorrectTransformations('e_fade:200', $image);
    }

    /** @test */
    public function fillLight()
    {
        $image = Cloudinary::id('test.png')
            ->fillLight(200);

        $this->assertCorrectTransformations('e_fill_light:200', $image);
    }

    /** @test */
    public function filter()
    {
        $image = Cloudinary::id('test.png')
            ->filter('zorro');

        $this->assertCorrectTransformations('e_art:zorro', $image);
    }

    /** @test */
    public function gamma()
    {
        $image = Cloudinary::id('test.png')
            ->gamma(200);

        $this->assertCorrectTransformations('e_gamma:200', $image);
    }

    /** @test */
    public function gradient_fade()
    {
        $image = Cloudinary::id('test.png')
            ->gradientFade(200);

        $this->assertCorrectTransformations('e_gradient_fade:200', $image);
    }

    /** @test */
    public function grayscale()
    {
        $image = Cloudinary::id('test.png')
            ->grayscale();

        $this->assertCorrectTransformations('e_grayscale', $image);
    }

    /** @test */
    public function green() 
    {
        $image = Cloudinary::id('test.png')
            ->green(50);

        $this->assertCorrectTransformations('e_green:50', $image);
    }

    /** @test */
    public function hue() 
    {
        $image = Cloudinary::id('test.png')
            ->hue(50);

        $this->assertCorrectTransformations('e_hue:50', $image);
    }

    /** @test */
    public function improve()
    {
        $image = Cloudinary::id('test.png')
            ->improve('outdoor');

        $this->assertCorrectTransformations('e_improve:outdoor', $image);
    }

    /** @test */
    public function sharpen()
    {
        $image = Cloudinary::id('test.png')
            ->sharpen();

        $this->assertCorrectTransformations('e_sharpen', $image);
    }

    /** @test */
    public function overlay()
    {
        $image = Cloudinary::id('test.png')
            ->overlay('screen', 'overlay');

        $this->assertCorrectTransformations('e_screen,overlay', $image);
    }

    /** @test */
    public function shadow()
    {
        $image = Cloudinary::id('test.png')
            ->shadow(50, 'rgb:ff0000', 10, 10);

        $this->assertCorrectTransformations('co_rgb:ff0000,e_shadow:50,x_10,y_10', $image);
    }

    /** @test */
    public function oilpaint()
    {
        $image = Cloudinary::id('test.png')
            ->oilPaint(70);

        $this->assertCorrectTransformations('e_oil_paint:70', $image);
    }
    /** @test */
    public function loop() 
    {
        $image = Cloudinary::id('test.png')
            ->loop(50);

        $this->assertCorrectTransformations('e_loop:50', $image);
    }

    /** @test */
    public function makeTransparent() 
    {
        $image = Cloudinary::id('test.png')
            ->makeTransparent(50);

        $this->assertCorrectTransformations('e_make_transparent:50', $image);
    }

    /** @test */
    public function orderedDither() 
    {
        $image = Cloudinary::id('test.png')
            ->orderedDither(50);

        $this->assertCorrectTransformations('e_ordered_dither:50', $image);
    }

    /** @test */
    public function pixelate() 
    {
        $image = Cloudinary::id('test.png')
            ->pixelate(50);

        $this->assertCorrectTransformations('e_pixelate:50', $image);
    }

    /** @test */
    public function pixelateFaces() 
    {
        $image = Cloudinary::id('test.png')
            ->pixelateFaces(50);

        $this->assertCorrectTransformations('e_pixelate_faces:50', $image);
    }

    /** @test */
    public function red() 
    {
        $image = Cloudinary::id('test.png')
            ->red(50);

        $this->assertCorrectTransformations('e_red:50', $image);
    }

    /** @test */
    public function replaceColor() 
    {
        $image = Cloudinary::id('test.png')
            ->replaceColor('blue', 8);

        $this->assertCorrectTransformations('e_replace_color:blue:8', $image);
    }

    /** @test */
    public function saturation() 
    {
        $image = Cloudinary::id('test.png')
            ->saturation(50);

        $this->assertCorrectTransformations('e_saturation:50', $image);
    }

    /** @test */
    public function sepia() 
    {
        $image = Cloudinary::id('test.png')
            ->sepia(50);

        $this->assertCorrectTransformations('e_sepia:50', $image);
    }

    /** @test */
    public function tiltShift() 
    {
        $image = Cloudinary::id('test.png')
            ->tiltShift(50);

        $this->assertCorrectTransformations('e_tilt_shift:50', $image);
    }

    /** @test */
    public function vectorize() 
    {
        $image = Cloudinary::id('test.png')
            ->vectorize();

        $this->assertCorrectTransformations('e_vectorize', $image);
    }

    /** @test */
    public function vibrance() 
    {
        $image = Cloudinary::id('test.png')
            ->vibrance(50);

        $this->assertCorrectTransformations('e_vibrance:50', $image);
    }

    /** @test */
    public function vignette() 
    {
        $image = Cloudinary::id('test.png')
            ->vignette(50);

        $this->assertCorrectTransformations('e_vignette:50', $image);
    }

    protected function assertCorrectTransformations($correct, $image)
    {
        $this->assertSame(
            sprintf('http://res.cloudinary.com/testing/image/upload/%s/%s', $correct, $image->getId()),
            $image->getUrl()
        );
    }
}
