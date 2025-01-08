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

namespace Module\ElasticMainmenu\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Driver\Statement;


/**
 * We cannot use Doctrine entities on install because the mapping is not available yet
 * but we can still use Doctrine connection to perform DQL or SQL queries.
 */
class DbInstaller
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
    public function __construct(
        Connection $connection,
        $dbPrefix
    ) {
        $this->connection = $connection;
        $this->dbPrefix = $dbPrefix;
    }

    /**
     * @return array
     *
     * @throws \Doctrine\DBAL\DBALException
     */
    public function createTables()
    {

        
        $errors = [];
        $this->dropTables();
        $sqlInstallFile = __DIR__ . '/../../Resources/data/install.sql';
        $sqlQueries = preg_split('/\r\n|\r|\n/', file_get_contents($sqlInstallFile));
        $sqlQueries = str_replace('PREFIX_', $this->dbPrefix, $sqlQueries);

        foreach ($sqlQueries as $query) {
            if (empty($query)) {
                continue;
            }
            $statement = $this->connection->executeQuery($query);
            if (0 != (int) $statement->errorCode()) {
                $errors[] = [
                    'key' => json_encode($statement->errorInfo()),
                    'parameters' => [],
                    'domain' => 'Admin.Modules.Notification',
                ];
            }
        }
        // $this->setInitialPositions();
        return $errors;
    }

    public function setInitialPositions() {
        $updatePositions = $this->connection->executeQuery("UPDATE ps_category SET emm_position = position;");
        if($updatePositions) {
            return true;
        } else {
            echo "Błąd przy ustawianiu pozycji!";
        }
    }

    /**
     * @return array
     *
     * @throws DBALException
     */
    public function dropTables()
    {
        $errors = [];
        $tableNames = [
            'elasticmainmenu'
        ];
        foreach ($tableNames as $tableName) {
            $sql_table = 'DROP TABLE IF EXISTS ' . $this->dbPrefix . $tableName;
            $statement_table = $this->connection->executeQuery($sql_table);
            if ($statement_table instanceof Statement && 0 != (int) $statement_table->errorCode()) {
                $errors[] = [
                    'key' => json_encode($statement_table->errorInfo()),
                    'parameters' => [],
                    'domain' => 'Admin.Modules.Notification',
                ];
            }
        }

        $checkIfColumnsExist = $this->connection->executeQuery("SHOW COLUMNS FROM ps_category LIKE 'emm_position'");
        if ($checkIfColumnsExist->rowCount() > 0) {
            $this->connection->executeQuery("ALTER TABLE ".$this->dbPrefix."category DROP COLUMN emm_position, DROP COLUMN emm_enabled");
        }

        return $errors;
    }
}
