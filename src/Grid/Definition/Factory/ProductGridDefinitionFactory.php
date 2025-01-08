<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License version 3.0
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License version 3.0
 */

declare(strict_types=1);

namespace Module\ElasticMainmenu\Grid\Definition\Factory;

use PrestaShop\PrestaShop\Core\Grid\Column\ColumnCollection;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\ActionColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\DataColumn;
use PrestaShop\PrestaShop\Core\Grid\Definition\Factory\AbstractGridDefinitionFactory;
use PrestaShop\PrestaShop\Core\Grid\Filter\Filter;
use PrestaShop\PrestaShop\Core\Grid\Filter\FilterCollection;
use PrestaShopBundle\Form\Admin\Type\NumberMinMaxFilterType;
use PrestaShopBundle\Form\Admin\Type\SearchAndResetType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\LinkColumn;
use PrestaShop\PrestaShop\Core\Grid\Column\Type\Common\PositionColumn;

class ProductGridDefinitionFactory extends AbstractGridDefinitionFactory
{
    const GRID_ID = 'category';

    /**
     * {@inheritdoc}
     */
    protected function getId()
    {
        return self::GRID_ID;
    }

    /**
     * {@inheritdoc}
     */
    protected function getName()
    {
        return 'Test name';
    }

    /**
     * {@inheritdoc}
     */
    protected function getColumns()
    {
        
        
        return (new ColumnCollection())
        ->add(
            (new PositionColumn('emm_position'))
                ->setName('Position')
                ->setOptions([
                    'id_field' => 'id_category',
                    'position_field' => 'position',
                    'update_route' => 'admin_link_block_update_positions',
                    'update_method' => 'POST',
                    'record_route_params' => [
                        'id_hook' => 'hookId',
                    ],
                ])
            )
        ->add(
            (new DataColumn('id_category'))
                ->setOptions([
                    'field' => 'id_category',
                ])
            )
        ->add(
            (new LinkColumn('name'))
                ->setOptions([
                    'field' => 'name',
                    'route' => 'ps_elasticmainmenu_category',
                    'route_param_name' => 'id_parent',
                    'route_param_field' => 'id_category'
                ])
            )
        ->add(
            (new DataColumn('emm_position'))
                ->setOptions([
                    'field' => 'emm_position',
                ])
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFilters()
    {
        return (new FilterCollection());

    }
}
