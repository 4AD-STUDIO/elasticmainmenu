<?php
declare(strict_types=1);

namespace Module\ElasticMainmenu\Controller\Admin;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;
use Module\ElasticMainmenu\Grid\Filters\CategoryFilters;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteria;

class ElasticmainmenuController extends FrameworkBundleAdminController
{

    /**
     *
     * @param CategoryFilters $filters
     *
     * @return Response
     */

    public function indexAction(CategoryFilters $filters)
    {

        $categoriesGridFactory = $this->get('prestashop.module.elasticmainmenu.grid.factory.categories');
  
        $categoriesGrid = $categoriesGridFactory->getGrid(); //stad wychodzi blad

        return $this->render(
            '@Modules/elasticmainmenu/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Elastic MainMenu', 'Modules.Elasticmainmenu.Admin'),
                // 'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                'categoriesGrid' => $this->presentGrid($categoriesGrid),
            ]
        );
    }

}