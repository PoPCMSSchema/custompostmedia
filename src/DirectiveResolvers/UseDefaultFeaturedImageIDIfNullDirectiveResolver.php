<?php
namespace PoP\PostMedia\DirectiveResolvers;
use PoP\PostMedia\Environment;
use PoP\Posts\FieldResolver_Posts;
use PoP\ComponentModel\DirectiveResolvers\AbstractUseDefaultValueIfNullDirectiveResolver;

class UseDefaultFeaturedImageIDIfNullDirectiveResolver extends AbstractUseDefaultValueIfNullDirectiveResolver
{
    const DIRECTIVE_NAME = 'default';
    public static function getDirectiveName(): string {
        return self::DIRECTIVE_NAME;
    }

    public static function getClassesToAttachTo(): array
    {
        return [
            FieldResolver_Posts::class,
        ];
    }
    public static function getFieldNamesToApplyTo(): array
    {
        // By default, apply to all fieldNames
        return [
            'featuredimage',
        ];
    }

    protected function getDefaultValue() {
        return Environment::getDefaultFeaturedImageID();
    }
}
