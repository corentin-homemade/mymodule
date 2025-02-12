<?php
declare(strict_types=1);

namespace PrestaShop\Module\MyModule\Grid\Filters;

use PrestaShop\Module\MyModule\Grid\Definition\Factory\ProductGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Search\Filters;

class ProductFilters extends Filters
{
    protected $filterId = ProductGridDefinitionFactory::GRID_ID;

    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => self::getDefaultOrderBy(),
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }

    private static function getDefaultOrderBy()
    {
        return isset($_GET['order_by']) && in_array($_GET['order_by'], ['id_product', 'id_order'])
            ? $_GET['order_by']
            : 'id_order';
    }

}
