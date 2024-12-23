<?php
/**
 * 2007-2020 PrestaShop SA and Contributors
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0).
 * It is also available through the world-wide-web at this URL: https://opensource.org/licenses/AFL-3.0
 */
declare(strict_types=1);

namespace Module\ElasticMainmenu\Grid\Filters;

use PrestaShop\PrestaShop\Core\Search\Filters;

class CategoryFilters extends Filters
{
    protected $filterId = 'categories_grid';

    /**
     * {@inheritdoc}
     */
    public static function getDefaults()
    {
        return [
            'limit' => 10,
            'offset' => 0,
            'orderBy' => 'id_category', // Zmień na poprawną kolumnę
            'sortOrder' => 'asc',
            'filters' => [],
        ];
    }
}
