<?php

namespace TeamZac\Cloudinary\Facades;

use Illuminate\Support\Facades\Facade;
use TeamZac\Cloudinary\CloudinaryManager;

class Cloudinary extends Facade
{
    public static function getFacadeAccessor()
    {
        return CloudinaryManager::class;
    }
}
