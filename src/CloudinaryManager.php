<?php

namespace TeamZac\Cloudinary;

use Illuminate\Support\Manager;

class CloudinaryManager extends Manager
{
    public function createEmptyDriver()
    {
        return new Builder;
    }

    public function getDefaultDriver()
    {
        return 'empty';
    }
}
