<?php

namespace TeamZac\Cloudinary;

use TeamZac\Cloudinary\Transformations\PendingOutline;

class Builder
{
    protected $id;

    protected $transformations = [];

    public function __construct()
    {
        $this->initializePresets();
    }

    protected function initializePresets()
    {
        // subclasses can override here to set defaults
    }

    public function id($id)
    {
        $this->id = $id;
        return $this;
    }

    public function resize($width, $height, $cropMode = 'scale')
    {
        return $this->transform([
            'width' => $width,
            'height' => $height,
            'crop' => $cropMode,
        ]);
    }

    public function transform(array $options)
    {
        $this->transformations[] = $options;
        return $this;
    }

    public function brightness($value)
    {
        return $this->addEffect('brightness:'.$value);
    }

    public function color($effect, $modifier = null)
    {
        return $this->addEffect($effect . ($modifier ? ':'.$modifier : ''));
    }

    public function outline($mode, $width = 5, $blur = 0, $callback = null)
    {
        $pending = new PendingOutline($mode, $width, $blur);

        if (is_callable($callback)) {
            $callback($pending);
        }

        return $this->addEffect($pending->getValue());
    }

    public function tint($amount, ...$colors)
    {
        return $this->addEffect(
            sprintf('tint:%d:%s', $amount, implode(':', $colors))
        );
    }

    public function equalizedTint($amount, ...$colors)
    {
        return $this->addEffect(
            sprintf('tint:equalize:%d:%s', $amount, implode(':', $colors))
        );
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

    public function removeBackground()
    {
        return $this->addEffect('bgremoval');
    }

    public function accelerate($value)
    {
        return $this->addEffect('accelerate:'.$value);
    }

    public function removeRedEye()
    {
        return $this->addEffect('adv_redeye');
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

    public function boomerang()
    {
        return $this->addEffect('boomerang');
    }

    public function brightnessHsb()
    {
        return $this->addEffect('brightness_hsb');
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

    public function fade($strength = 0)
    {
        return $this->addEffect('fade:'.$strength);
    }

    public function fillLight($strength = 0)
    {
        return $this->addEffect('fill_light:'.$strength);
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


    public function sharpen()
    {
        return $this->addEffect('sharpen');
    }

    public function overlay($mode, $overlay)
    {
        return $this->addEffect($mode.','.$overlay);
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

    public function improve($mode)
    {
        return $this->addEffect('improve:'.$mode);
    }

    public function enhance()
    {
        return $this->addEffect('viesus_correct');
    }

    public function filter($mode)
    {
        return $this->addEffect('art:'.$mode);
    }

    public function oilPaint($strength)
    {
        return $this->addEffect('oil_paint:'.$strength);
    }

    public function cartoonify()
    {
        return $this->addEffect('cartoonify');
    }

    public function addEffect($value)
    {
        $this->transformations[] = ['effect' => $value];
        return $this;
    }

    public function build()
    {
        return (new CloudinaryImage($this->id))->withTransformations($this->transformations);
    }
}
