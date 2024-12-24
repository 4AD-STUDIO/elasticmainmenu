<?php
declare(strict_types=1);

namespace Module\ElasticMainmenu\Controller\Admin;

use Module\ElasticMainmenu\Grid\Definition\Factory\ProductGridDefinitionFactory;
use Module\ElasticMainmenu\Grid\Filters\ProductFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class ElasticmainmenuController extends FrameworkBundleAdminController
{
    /**
     * List quotes
     *
     * @param ProductFilters $filters
     *
     * @return Response
     */
    public function indexAction(ProductFilters $filters)
    {
        $quoteGridFactory = $this->get('demo_grid.grid.factory.products');
        $quoteGrid = $quoteGridFactory->getGrid($filters);

        return $this->render(
            '@Modules/elasticmainmenu/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Elastic MainMenu', 'Modules.Elasticmainmenu.Admin'),
                // 'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'quoteGrid' => $this->presentGrid($quoteGrid),
            ]
        );
    }

}