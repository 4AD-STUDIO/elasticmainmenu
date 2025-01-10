<?php

declare(strict_types=1);

use Module\ElasticMainmenu\Database\DbInstaller;
use PrestaShop\PrestaShop\Adapter\SymfonyContainer;


if (!defined('_PS_VERSION_')) {
    exit;
}

if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require_once __DIR__.'/vendor/autoload.php';
}

class ElasticMainmenu extends Module
{
    public function __construct()
    {
        $this->name = 'elasticmainmenu';
        $this->author = '4AD STUDIO';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.7.7', 'max' => '8.99.99'];

        parent::__construct();

        $this->displayName = $this->l('ElasticMainMenu');
        $this->description = $this->l('This module allows you to easily compose and speed up your top nav.');

    }

    public function install()
    {
        return $this->installTables() && parent::install() && $this->registerHook('displayHome') && $this->registerHook('actionAdminControllerSetMedia');
    }

    public function hookActionAdminControllerSetMedia()
{
    // $token = Tools::getAdminTokenLite('AdminTableController');


    $route = SymfonyContainer::getInstance()->get('router')->generate('ps_elasticmainmenu_updatepositions', [
        'idstart' => '|STARTID|',
        'idend'  => '|ENDID|',
        'idcategory'  => '|IDCATEGORY|'
    ]);






    // dump($token);
    Media::addJsDef([
        'token_4ad' => $route,
    ]);


    $this->context->controller->addJs($this->getPathUri() . 'public/position-handle.js?4ad_token=' . $token);
    $this->context->controller->addCSS($this->_path . '/public/styles.css');

}



    public function uninstall()
    {
        return $this->removeTables() && parent::uninstall();
    }

    private function installTables()
    {
        /** @var DbInstaller $installer */
        $installer = $this->getInstaller();
        
        $errors = $installer->createTables();
        $installer->setInitialPositions();
        return empty($errors);
    }

    private function removeTables()
    {
        /** @var DbInstaller $installer */
        $installer = $this->getInstaller();
        $errors = $installer->dropTables();

        return empty($errors);
    }

    public function getContent()
    {
        
        Tools::redirectAdmin(
            $this->context->link->getAdminLink('AdminElasticMainmenu')
        );
    }
    

    private function getInstaller()
    {
       

        try { 
            $installer = $this->get('prestashop.module.elasticmainmenu.db.install');
        } catch (Exception $e) {
            // Catch exception in case container is not available, or service is not available
            $installer = null;
        }

        // During install process the modules's service is not available yet so we build it manually
        if (!$installer) {
            $installer = new DbInstaller(
                $this->get('doctrine.dbal.default_connection'),
                $this->getContainer()->getParameter('database_prefix')
            );
        }

        return $installer;
    }

}