<?php

namespace TeamZac\Cloudinary;

class Color
{
    protected $name;
    protected $hex;

    public static function named($name)
    {
        return (new static)->setName($name);
    }

    public static function hex($hex)
    {
        return (new static)->setHex($hex);
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setHex($hex)
    {
        $this->hex = $hex;
        return $this;
    }

    public function getValue()
    {
        return $this->name ? $this->name : sprintf('rgb:%s', $this->hex);
    }
}
