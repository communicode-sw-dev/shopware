<?php declare(strict_types=1);

namespace Shopware\Content\Media\Event\MediaAlbumTranslation;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Media\Definition\MediaAlbumTranslationDefinition;

class MediaAlbumTranslationDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'media_album_translation.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return MediaAlbumTranslationDefinition::class;
    }
}
