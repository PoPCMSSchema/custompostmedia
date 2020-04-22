<?php

declare(strict_types=1);

namespace PoP\PostMedia\DirectiveResolvers;

use PoP\PostMedia\Environment;
use PoP\Content\FieldInterfaces\ContentEntityFieldInterfaceResolver;
use PoP\BasicDirectives\DirectiveResolvers\AbstractUseDefaultValueIfConditionDirectiveResolver;

class UseDefaultFeaturedImageIDIfConditionDirectiveResolver extends AbstractUseDefaultValueIfConditionDirectiveResolver
{
    const DIRECTIVE_NAME = 'defaultFeaturedImage';
    public static function getDirectiveName(): string
    {
        return self::DIRECTIVE_NAME;
    }

    public static function getClassesToAttachTo(): array
    {
        return [
            ContentEntityFieldInterfaceResolver::class,
        ];
    }
    public static function getFieldNamesToApplyTo(): array
    {
        return [
            'featuredImage',
        ];
    }

    protected function getDefaultValue()
    {
        return Environment::getDefaultFeaturedImageID();
    }
}
