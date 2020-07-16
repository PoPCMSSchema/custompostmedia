<?php

declare(strict_types=1);

namespace PoP\CustomPostMedia\Misc;

use PoP\Hooks\Facades\HooksAPIFacade;

class MediaHelpers
{
    public static function getThumbId($post_id)
    {
        $cmsmediapostsapi = \PoP\Media\PostsFunctionAPIFactory::getInstance();
        if ($thumb_id = $cmsmediapostsapi->getCustomPostThumbnailID($post_id)) {
            return $thumb_id;
        }

        // Default
        return HooksAPIFacade::getInstance()->applyFilters('getThumbId:default', POP_MEDIA_IMAGE_NOFEATUREDIMAGEPOST, $post_id);
    }
}
