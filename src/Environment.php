<?php

declare(strict_types=1);

namespace PoP\CustomPostMedia;

class Environment
{
    public static function getDefaultFeaturedImageID(): ?int
    {
        return isset($_ENV['DEFAULT_FEATURED_IMAGE_ID']) ? (int)$_ENV['DEFAULT_FEATURED_IMAGE_ID'] : null;
    }
}
