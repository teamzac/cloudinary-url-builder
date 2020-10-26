<?php

namespace TeamZac\Cloudinary\Tests\Fixtures;

use TeamZac\Cloudinary\Builder;

class ExamplePreset extends Builder
{
    protected function initializePreset()
    {
        $this->autoBrightness()
        	->blue(50)
        	->pixelate(20);
    }
}
