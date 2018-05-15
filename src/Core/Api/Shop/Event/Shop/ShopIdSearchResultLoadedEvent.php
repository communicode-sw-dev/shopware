<?php declare(strict_types=1);

namespace Shopware\Api\Shop\Event\Shop;

use Shopware\Framework\ORM\Search\IdSearchResult;
use Shopware\Context\Struct\ApplicationContext;
use Shopware\Framework\Event\NestedEvent;

class ShopIdSearchResultLoadedEvent extends NestedEvent
{
    public const NAME = 'shop.id.search.result.loaded';

    /**
     * @var IdSearchResult
     */
    protected $result;

    public function __construct(IdSearchResult $result)
    {
        $this->result = $result;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): ApplicationContext
    {
        return $this->result->getContext();
    }

    public function getResult(): IdSearchResult
    {
        return $this->result;
    }
}
