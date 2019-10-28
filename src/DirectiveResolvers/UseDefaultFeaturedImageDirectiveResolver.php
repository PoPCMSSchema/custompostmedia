<?php
namespace PoP\PostMedia\DirectiveResolvers;
use PoP\PostMedia\Environment;
use PoP\Posts\FieldResolver_Posts;
use PoP\ComponentModel\FieldResolvers\PipelinePositions;
use PoP\ComponentModel\FieldResolvers\FieldResolverInterface;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
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

    /**
     * This directive must be executed after ResolveAndMerge, and modify values directly on the returned DB items
     *
     * @return void
     */
    public function getPipelinePosition(): string
    {
        return PipelinePositions::BACK;
    }

    public function resolveDirective(FieldResolverInterface $fieldResolver, array &$resultIDItems, array &$idsDataFields, array &$dbItems, array &$dbErrors, array &$dbWarnings, array &$schemaErrors, array &$schemaWarnings, array &$schemaDeprecations)
    {
        // Replace all the NULL results with the default value
        if ($defaultValue = Environment::getDefaultFeaturedImageID()) {
            $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
            $fieldOutputKeyCache = [];
            foreach ($idsDataFields as $id => $dataFields) {
                foreach ($dataFields['direct'] as $field) {
                    // Get the fieldOutputKey from the cache, or calculate it
                    if (is_null($fieldOutputKeyCache[$field])) {
                        $fieldOutputKeyCache[$field] = $fieldQueryInterpreter->getFieldOutputKey($field);
                    }
                    $fieldOutputKey = $fieldOutputKeyCache[$field];
                    // If it is null, replace it with the default value
                    if (is_null($dbItems[$id][$fieldOutputKey])) {
                        $dbItems[$id][$fieldOutputKey] = $defaultValue;
                    }
                }
            }
        }
    }
}
