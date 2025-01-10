<?php

namespace Module\ElasticMainmenu\Controller\Admin;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;
use Doctrine\DBAL\Query\QueryBuilder;


class AdminTableController extends FrameworkBundleAdminController
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @var string
     */
    private $dbPrefix;

     public function __construct() {

    }
    private function setDependencies()
    {
        $this->connection = $this->get('doctrine.dbal.default_connection');
        $this->dbPrefix = $this->getParameter('database_prefix');
    }
    public function initContent() {
        parent::initContent();
    }

    public function updatePositions($idstart, $idend, $idcategory = null) {
        $response = new JsonResponse();
        $this->setDependencies();

        $tempId = $idend + 0.5;
        $updateFromId = null;

        if($idstart > $idend) {
            $updateFromId = $idend;
        } else {
            $updateFromId = $idstart;
        }

        $db = \Db::getInstance(_PS_USE_SQL_SLAVE_);

        $request = 'SELECT id_parent FROM ps_category WHERE id_category = '.$idcategory;
        $parentId = $db->executeS($request);

        $this->connection->executeQuery("UPDATE ps_category SET emm_position = ".$tempId." WHERE emm_position = ".$idstart." AND id_parent = ".$parentId[0]['id_parent']);

        $this->connection->executeQuery("SET @position = -1");
        $this->connection->executeQuery("UPDATE ps_category 
            SET emm_position = (@position := @position + 1) 
            WHERE id_parent = ".$parentId[0]['id_parent']." 
            ORDER BY emm_position");

        $response->setData([
            'idstart' => $idstart,
            'idend' => $idend,
            'idcategory' => $parentId[0]['id_parent']
        ]);

        return $response;

    }
    public function test() {
        dump(33);
        exit;
    }

}