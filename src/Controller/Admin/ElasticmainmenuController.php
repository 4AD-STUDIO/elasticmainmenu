<?php
declare(strict_types=1);

namespace Module\ElasticMainmenu\Controller\Admin;

use Module\DemoDoctrine\Grid\Filters\QuoteFilters;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class ElasticmainmenuController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
        return $this->render(
            '@Modules/elasticmainmenu/views/templates/admin/index.html.twig',
            [
                'enableSidebar' => true,
                'layoutTitle' => $this->trans('Elastic MainMenu', 'Modules.Elasticmainmenu.Admin'),
                // 'layoutHeaderToolbarBtn' => $this->getToolbarButtons(),
                // 'quoteGrid' => $this->presentGrid($quoteGrid),
            ]
        );
    }

}