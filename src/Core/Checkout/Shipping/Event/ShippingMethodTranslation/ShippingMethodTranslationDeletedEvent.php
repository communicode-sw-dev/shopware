<?php declare(strict_types=1);

namespace Shopware\Checkout\Shipping\Event\ShippingMethodTranslation;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Checkout\Shipping\Definition\ShippingMethodTranslationDefinition;

class ShippingMethodTranslationDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'shipping_method_translation.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ShippingMethodTranslationDefinition::class;
    }
}
