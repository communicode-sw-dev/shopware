<?php declare(strict_types=1);

namespace Shopware\System\Configuration\Event\ConfigurationGroup;

use Shopware\System\Configuration\Definition\ConfigurationGroupDefinition;
use Shopware\Framework\ORM\Write\WrittenEvent;

class ConfigurationGroupWrittenEvent extends WrittenEvent
{
    public const NAME = 'configuration_group.written';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ConfigurationGroupDefinition::class;
    }
}
