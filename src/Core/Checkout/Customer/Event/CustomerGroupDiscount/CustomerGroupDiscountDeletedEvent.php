<?php declare(strict_types=1);

namespace Shopware\Checkout\Customer\Event\CustomerGroupDiscount;

use Shopware\Checkout\Customer\Definition\CustomerGroupDiscountDefinition;
use Shopware\Framework\ORM\Write\DeletedEvent;
use Shopware\Framework\ORM\Write\WrittenEvent;

class CustomerGroupDiscountDeletedEvent extends WrittenEvent implements DeletedEvent
{
    public const NAME = 'customer_group_discount.deleted';

    public function getName(): string
    {
        return self::NAME;
    }

    public function getDefinition(): string
    {
        return CustomerGroupDiscountDefinition::class;
    }
}
