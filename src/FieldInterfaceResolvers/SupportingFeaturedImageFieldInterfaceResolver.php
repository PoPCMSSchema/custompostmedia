<?php

declare(strict_types=1);

namespace PoP\CustomPostMedia\FieldInterfaceResolvers;

use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\ComponentModel\FieldInterfaceResolvers\AbstractSchemaFieldInterfaceResolver;

class SupportingFeaturedImageFieldInterfaceResolver extends AbstractSchemaFieldInterfaceResolver
{
    public const NAME = 'SupportingFeaturedImage';
    public function getInterfaceName(): string
    {
        return self::NAME;
    }

    public function getSchemaInterfaceDescription(): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        return $translationAPI->__('The fundamental fields that must be implemented by all objects', 'component-model');
    }

    public static function getFieldNamesToImplement(): array
    {
        return [
            'hasFeaturedImage',
            'featuredImage',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
            'hasFeaturedImage' => SchemaDefinition::TYPE_BOOL,
            'featuredImage' => SchemaDefinition::TYPE_ID,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function isSchemaFieldResponseNonNullable(TypeResolverInterface $typeResolver, string $fieldName): bool
    {
        $nonNullableFieldNames = [
            'hasFeaturedImage',
        ];
        if (in_array($fieldName, $nonNullableFieldNames)) {
            return true;
        }
        return parent::isSchemaFieldResponseNonNullable($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
            'hasFeaturedImage' => $translationAPI->__('Does the custom post have a featured image?', 'custompostmedia'),
            'featuredImage' => $translationAPI->__('Featured image from the custom post', 'custompostmedia'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }
}
