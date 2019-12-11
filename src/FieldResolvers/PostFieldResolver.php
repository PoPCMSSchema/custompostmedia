<?php
namespace PoP\PostMedia\FieldResolvers;

use PoP\Translation\Facades\TranslationAPIFacade;
use PoP\ComponentModel\Schema\SchemaDefinition;
use PoP\ComponentModel\FieldResolvers\AbstractDBDataFieldResolver;
use PoP\ComponentModel\TypeResolvers\TypeResolverInterface;
use PoP\Posts\TypeResolvers\PostTypeResolver;
use PoP\Media\TypeResolvers\MediaTypeResolver;
use PoP\Media\Misc\MediaHelpers;

class PostFieldResolver extends AbstractDBDataFieldResolver
{
    public static function getClassesToAttachTo(): array
    {
        return array(PostTypeResolver::class);
    }

    public static function getFieldNamesToResolve(): array
    {
        return [
            'has-featuredimage',
            'featuredimage',
            'featuredimage-props',
        ];
    }

    public function getSchemaFieldType(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $types = [
			'has-featuredimage' => SchemaDefinition::TYPE_BOOL,
            'featuredimage' => SchemaDefinition::TYPE_ID,
            'featuredimage-props' => SchemaDefinition::TYPE_OBJECT,
        ];
        return $types[$fieldName] ?? parent::getSchemaFieldType($typeResolver, $fieldName);
    }

    public function getSchemaFieldDescription(TypeResolverInterface $typeResolver, string $fieldName): ?string
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        $descriptions = [
			'has-featuredimage' => $translationAPI->__('Does the post have a featured image?', 'pop-media'),
            'featuredimage' => $translationAPI->__('ID of the featured image DB object', 'pop-media'),
            'featuredimage-props' => $translationAPI->__('Properties (url, width and height) of the featured image', 'pop-media'),
        ];
        return $descriptions[$fieldName] ?? parent::getSchemaFieldDescription($typeResolver, $fieldName);
    }

    public function resolveValue(TypeResolverInterface $typeResolver, $resultItem, string $fieldName, array $fieldArgs = [], ?array $variables = null, ?array $expressions = null, array $options = [])
    {
        $cmsmediapostsapi = \PoP\Media\PostsFunctionAPIFactory::getInstance();
        $post = $resultItem;
        switch ($fieldName) {
            case 'has-featuredimage':
                return $cmsmediapostsapi->hasPostThumbnail($typeResolver->getId($post));

            case 'featuredimage':
                return $cmsmediapostsapi->getPostThumbnailId($typeResolver->getId($post));

            case 'featuredimage-props':
                if ($image_id = $cmsmediapostsapi->getPostThumbnailId($typeResolver->getId($post))) {
                    return MediaHelpers::getAttachmentImageProperties($image_id, $fieldArgs['size']);
                }
                return null;
        }

        return parent::resolveValue($typeResolver, $resultItem, $fieldName, $fieldArgs, $variables, $expressions, $options);
    }

    public function getSchemaFieldArgs(TypeResolverInterface $typeResolver, string $fieldName): array
    {
        $translationAPI = TranslationAPIFacade::getInstance();
        switch ($fieldName) {
            case 'featuredimage-props':
                return [
                    [
                        'name' => 'size',
                        'type' => SchemaDefinition::TYPE_STRING,
                        'description' => $translationAPI->__('Size of the image', 'pop-media'),
                    ],
                ];
        }

        return parent::getSchemaFieldArgs($typeResolver, $fieldName);
    }

    public function resolveFieldTypeResolverClass(TypeResolverInterface $typeResolver, string $fieldName, array $fieldArgs = []): ?string
    {
        switch ($fieldName) {
            case 'featuredimage':
                return MediaTypeResolver::class;
        }

        return parent::resolveFieldTypeResolverClass($typeResolver, $fieldName, $fieldArgs);
    }
}
