<?php

namespace TeamZac\Cloudinary;

use Cloudinary as BaseCloudinary;
use TeamZac\Cloudinary\Transformations\PendingOutline;

class Builder
{
    /** 
     * The Cloudinary image id
     */
    protected string $id;

    /**
     * An array of transformations to apply
     */
    protected $transformations = [];

    /**
     * An array of pre-defined transformations
     */
    public static $presets = [];

    /**
     * You can extend the main builder by providing a callback which
     * returns a new Builder subclass with presets already applied
     *
     * @var string $name
     * @var Callable $callback
     */
    public static function extend(string $name, $callback) 
    {
        static::$presets[$name] = $callback;
    }

    /**
     * Retrieve a preset previously defined using the extend method
     *
     * @var string $name
     * @return Builder subclass
     */
    public static function preset(string $preset)
    {
        if (array_key_exists($preset, static::$presets)) {
            return static::$presets[$preset]();
        }

        throw new \Exception('No preset found for key: '.$preset);
    }

    public function __construct()
    {
        $this->initializePreset();
    }

    protected function initializePreset()
    {
        // subclasses can override here to set defaults
    }

    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function transform(array $options)
    {
        $this->transformations[] = $options;
        return $this;
    }

    public function accelerate($value)
    {
        return $this->addEffect('accelerate:'.$value);
    }

    public function assistColorblind()
    {
        return $this->addEffect('assist_colorblind');
    }

    public function autoBrightness()
    {
        return $this->addEffect('auto_brightness');
    }

    public function autoColor()
    {
        return $this->addEffect('auto_color');
    }

    public function autoContrast()
    {
        return $this->addEffect('auto_contrast');
    }

    public function autoSaturation()
    {
        return $this->addEffect('auto_saturation');
    }

    public function blackWhite()
    {
        return $this->addEffect('blackwhite');
    }

    public function blue($value)
    {
        return $this->addEffect('blue:'.$value);
    }

    public function blur($value)
    {
        return $this->addEffect('blur:'.$value);
    }

    public function blurFaces($value)
    {
        return $this->addEffect('blur_faces:'.$value);
    }

    public function blurRegion($value)
    {
        return $this->addEffect('blur_region:'.$value);
    }

    public function boomerang()
    {
        return $this->addEffect('boomerang');
    }

    public function brightness($value)
    {
        return $this->addEffect('brightness:'.$value);
    }

    public function brightnessHsb()
    {
        return $this->addEffect('brightness_hsb');
    }

    public function cartoonify()
    {
        return $this->addEffect('cartoonify');
    }

    public function color($effect, $modifier = null)
    {
        return $this->addEffect($effect . ($modifier ? ':'.$modifier : ''));
    }

    public function colorize($value)
    {
        return $this->addEffect('colorize:'.$value);
    }

    public function contrast($strength = 0)
    {
        return $this->addEffect('contrast:'.$strength);
    }

    public function deshake($strength = 0)
    {
        return $this->addEffect('deshake:'.$strength);
    }

    public function displace()
    {
        return $this->addEffect('displace');
    }

    public function enhance()
    {
        return $this->addEffect('viesus_correct');
    }

    public function equalizedTint($amount, ...$colors)
    {
        return $this->addEffect(
            sprintf('tint:equalize:%d:%s', $amount, implode(':', $colors))
        );
    }

    public function fade($strength = 0)
    {
        return $this->addEffect('fade:'.$strength);
    }

    public function fillLight($strength = 0)
    {
        return $this->addEffect('fill_light:'.$strength);
    }

    public function filter($mode)
    {
        return $this->addEffect('art:'.$mode);
    }

    public function gamma($strength = 0)
    {
        return $this->addEffect('gamma:'.$strength);
    }

    public function gradientFade($strength = 0)
    {
        return $this->addEffect('gradient_fade:'.$strength);
    }

    public function grayscale()
    {
        return $this->addEffect('grayscale');
    }

    public function green($value)
    {
        return $this->addEffect('green:'.$value);
    }

    public function hue($value)
    {
        return $this->addEffect('hue:'.$value);
    }

    public function improve($mode)
    {
        return $this->addEffect('improve:'.$mode);
    }

    public function loop($mode)
    {
        return $this->addEffect('loop:'.$mode);
    }

    public function makeTransparent($mode)
    {
        return $this->addEffect('make_transparent:'.$mode);
    }

    public function noise($value)
    {
        return $this->addEffect('noise:'. $value);
    }

    public function orderedDither($value)
    {
        return $this->addEffect('ordered_dither:'. $value);
    }

    public function oilPaint($strength)
    {
        return $this->addEffect('oil_paint:'.$strength);
    }

    public function outline($mode = 'inner', $width = 5, $blur = 0)
    {
        if (is_callable($mode)) {
            $pending = new PendingOutline('inner', $width, $blur);
            $mode($pending);
        } else {
            $pending = new PendingOutline($mode, $width, $blur);
        }

        return $this->addEffect($pending->getValue());
    }

    public function overlay($mode, $overlay)
    {
        return $this->addEffect($mode.','.$overlay);
    }

    public function pixelate($value)
    {
        return $this->addEffect('pixelate:'.$value);
    }

    public function pixelateFaces($value)
    {
        return $this->addEffect('pixelate_faces:'.$value);
    }

    public function red($value)
    {
        return $this->addEffect('red:'.$value);
    }

    public function removeBackground()
    {
        return $this->addEffect('bgremoval');
    }

    public function removeRedEye()
    {
        return $this->addEffect('adv_redeye');
    }

    public function resize($width, $height, $cropMode = 'scale')
    {
        return $this->transform([
            'width' => $width,
            'height' => $height,
            'crop' => $cropMode,
        ]);
    }

    public function saturation($value)
    {
        return $this->addEffect('saturation:'.$value);
    }

    public function sepia($value)
    {
        return $this->addEffect('sepia:'.$value);
    }

    public function shadow($strength, $color, $x, $y)
    {
        return $this->transform([
            'color' => $color,
            'effect' => 'shadow:'.$strength,
            'x' => $x,
            'y' => $y
        ]);
    }

    public function sharpen()
    {
        return $this->addEffect('sharpen');
    }

    public function tiltShift($value)
    {
        return $this->addEffect('tilt_shift:'.$value);
    }

    public function tint($amount, ...$colors)
    {
        return $this->addEffect(
            sprintf('tint:%d:%s', $amount, implode(':', $colors))
        );
    }

    public function vectorize()
    {
        return $this->addEffect('vectorize');
    }

    public function vibrance($value)
    {
        return $this->addEffect('vibrance:'.$value);
    }

    public function vignette($value)
    {
        return $this->addEffect('vignette:'.$value);
    }

    public function addEffect($value)
    {
        $this->transformations[] = ['effect' => $value];
        return $this;
    }

    /**
     * Return the URL as a string. Cloudinary's library does not allow passing
     * the transformations array by reference, hence the temporary variable.
     *
     * @return string */
    public function getUrl()
    {
        $transformations = [
            'transformation' => $this->transformations,
        ];

        return BaseCloudinary::cloudinary_url($this->id, $transformations);
    }
}
