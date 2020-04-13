<?php
namespace PoP\PostMedia;

class Environment
{
    public static function getDefaultFeaturedImageID(): ?int
    {
        return isset($_ENV['DEFAULT_FEATURED_IMAGE_ID']) ? (int)$_ENV['DEFAULT_FEATURED_IMAGE_ID'] : null;
    }
}
