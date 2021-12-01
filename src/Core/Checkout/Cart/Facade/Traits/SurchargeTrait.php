<?php declare(strict_types=1);

namespace Shopware\Core\Checkout\Cart\Facade\Traits;

use Shopware\Core\Checkout\Cart\Facade\DiscountFacade;
use Shopware\Core\Checkout\Cart\LineItem\LineItem;
use Shopware\Core\Checkout\Cart\LineItem\LineItemCollection;
use Shopware\Core\Checkout\Cart\Price\Struct\CurrencyPriceDefinition;
use Shopware\Core\Checkout\Cart\Price\Struct\PercentagePriceDefinition;
use Shopware\Core\Checkout\Cart\Price\Struct\PriceDefinitionInterface;
use Shopware\Core\Defaults;
use Shopware\Core\Framework\DataAbstractionLayer\Pricing\PriceCollection;

/**
 * @internal The trait is not intended for re-usability in other domains
 */
trait SurchargeTrait
{
    protected LineItemCollection $items;

    /**
     * @public-api used for app scripting
     *
     * @param float|string|PriceCollection $value
     */
    public function surcharge(string $key, string $type, $value, string $label): DiscountFacade
    {
        $definition = $this->buildSurchargeDefinition($type, $value, $key);

        $item = new LineItem($key, LineItem::DISCOUNT_LINE_ITEM, null, 1);
        $item->setGood(false);
        $item->setPriceDefinition($definition);
        $item->setLabel($label);
        $this->getItems()->add($item);

        return new DiscountFacade($item);
    }

    protected function getItems(): LineItemCollection
    {
        return $this->items;
    }

    /**
     * @param float|PriceCollection|string|int $value
     */
    private function buildSurchargeDefinition(string $type, $value, string $key): PriceDefinitionInterface
    {
        if ($type === PercentagePriceDefinition::TYPE) {
            if ($value instanceof PriceCollection) {
                throw new \RuntimeException('Percentage discounts requires a provided float value');
            }

            $value = (float) $value;

            return new PercentagePriceDefinition(abs($value));
        }
        if ($type !== 'absolute') {
            throw new \RuntimeException(sprintf('Discount type %s not supported', $type));
        }
        if (!$value instanceof PriceCollection) {
            throw new \RuntimeException(sprintf('Absolute discounts %s requires a provided price collection. Use services.price(...) to create a price', $key));
        }
        if (!$value->has(Defaults::CURRENCY)) {
            throw new \RuntimeException(sprintf('Absolute discounts %s requires a defined currency price for the default currency. Use services.price(...) to create a compatible price object', $key));
        }

        return new CurrencyPriceDefinition($value);
    }
}
