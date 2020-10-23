<?php

namespace TeamZac\Cloudinary;

use Cloudinary as BaseCloudinary;

class CloudinaryImage
{
    protected $id;

    protected $transformations = [];

    public static function make($id)
    {
        return new static($id);
    }

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function withTransformations($transformations)
    {
        $this->transformations = $transformations;
        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUrl()
    {
        $transformations = [
            'transformation' => $this->transformations,
        ];

        return BaseCloudinary::cloudinary_url($this->id, $transformations);
    }
}
