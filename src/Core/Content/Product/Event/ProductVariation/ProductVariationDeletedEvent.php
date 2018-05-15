<?php declare(strict_types=1);

namespace Shopware\Content\Product\Event\ProductVariation;

use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;
use Shopware\Content\Product\Definition\ProductVariationDefinition;

class ProductVariationDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'product_variation.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return ProductVariationDefinition::class;
    }
}
