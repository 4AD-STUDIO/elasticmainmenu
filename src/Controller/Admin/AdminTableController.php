<?php

namespace Module\ElasticMainmenu\Controller\Admin;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;


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

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     */




    public function initContent() {
        dump(23234234);
        parent::initContent();
    }
    // public function ajaxProcessUpdatePositions() {
    //     dump(24234234234234);
    //     exit;
    //     return "Dzień dobry";

    // }

    public function updatePositions($idstart, $idend) {
        $response = new JsonResponse();
        
        // $statement_table = $this->connection->executeQuery($sql_table);


        $response->setData([
            'idstart' => $idstart,
            'idend' => $idend
        ]);

        return $response;

    }
    public function test() {
        dump(33);
        exit;
    }

}