<?php declare(strict_types=1);

namespace Shopware\Content\Media\Event\MediaAlbumTranslation;

use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Media\Definition\MediaAlbumTranslationDefinition;

class MediaAlbumTranslationWrittenEvent extends WrittenEvent
{
    public const NAME = 'media_album_translation.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return MediaAlbumTranslationDefinition::class;
    }
}
