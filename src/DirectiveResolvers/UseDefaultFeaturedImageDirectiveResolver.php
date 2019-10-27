<?php
namespace PoP\API\DirectiveResolvers;
use PoP\PostMedia\Environment;
use PoP\Posts\FieldResolver_Posts;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\ComponentModel\DirectiveResolvers\AbstractDirectiveResolver;

class UseDefaultFeaturedImageDirectiveResolver extends AbstractDirectiveResolver
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

    public function resolveDirective(FieldResolverInterface $fieldResolver, array &$resultIDItems, array &$idsDataFields, array &$dbItems, array &$dbErrors, array &$dbWarnings, array &$schemaErrors, array &$schemaWarnings, array &$schemaDeprecations)
    {
        // Check all results with the result being NULL
        if (true) {
            // Replace it with the default image
            if ($defaultFeaturedImageID = Environment::getDefaultFeaturedImageID()) {
                // ...
            }
        }
    }
}
