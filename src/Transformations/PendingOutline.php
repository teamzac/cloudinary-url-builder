<?php

namespace TeamZac\Cloudinary\Transformations;

class PendingOutline
{
    public $mode;
    public $width;
    public $blur;

    public $color;

    public function __construct($mode, $width = 5, $blur = 0)
    {
        $this->mode = $mode;
        $this->width = $width;
        $this->blur = $blur;
    }

    public function mode($mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function width($width)
    {
        $this->width = $width;
        return $this;
    }

    public function blur($blur)
    {
        $this->blur = $blur;
        return $this;
    }

    public function color($color, $hex = null)
    {
        if ($hex) {
            $this->color = $color.':'.$hex;
        } else {
            $this->color = $color;
        }

        return $this;
    }

    public function getValue()
    {
        $value = sprintf('outline:%s:%d:%d', $this->mode, $this->width, $this->blur);

        if ($this->color) {
            $value .= ',co_'.$this->color;
        }

        return $value;
    }

}
