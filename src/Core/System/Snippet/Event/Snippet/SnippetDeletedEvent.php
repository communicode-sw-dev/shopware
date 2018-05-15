<?php declare(strict_types=1);

namespace Shopware\System\Snippet\Event\Snippet;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\System\Snippet\Definition\SnippetDefinition;

class SnippetDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'snippet.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return SnippetDefinition::class;
    }
}
