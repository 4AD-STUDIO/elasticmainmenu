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

namespace Module\ElasticMainmenu\Grid\Query;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Adapter\Configuration;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\DoctrineSearchCriteriaApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\DoctrineFilterApplicatorInterface;
use PrestaShop\PrestaShop\Core\Grid\Query\Filter\SqlFilters;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

/**
 * Defines all required sql statements to render products list.
 */
class ProductQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var DoctrineSearchCriteriaApplicatorInterface
     */
    private $searchCriteriaApplicator;

    /**
     * @var int
     */
    private $contextLanguageId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @var bool
     */
    private $isStockSharingBetweenShopGroupEnabled;

    /**
     * @var int
     */
    private $contextShopGroupId;

    /**
     * @var DoctrineFilterApplicatorInterface
     */
    private $filterApplicator;

    /**
     * @var Configuration
     */
    private $configuration;

    public function __construct(
        Connection $connection,
        string $dbPrefix,
        DoctrineSearchCriteriaApplicatorInterface $searchCriteriaApplicator,
        int $contextLanguageId,
        int $contextShopId,
        int $contextShopGroupId,
        bool $isStockSharingBetweenShopGroupEnabled,
        DoctrineFilterApplicatorInterface $filterApplicator,
        Configuration $configuration
    ) {
        parent::__construct($connection, $dbPrefix);
        $this->searchCriteriaApplicator = $searchCriteriaApplicator;
        $this->contextLanguageId = $contextLanguageId;
        $this->contextShopId = $contextShopId;
        $this->isStockSharingBetweenShopGroupEnabled = $isStockSharingBetweenShopGroupEnabled;
        $this->contextShopGroupId = $contextShopGroupId;
        $this->filterApplicator = $filterApplicator;
        $this->configuration = $configuration;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {

      

        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb
        ->select('category.`id_category`, categorylang.`name`, category.`id_parent`');

        $qb->andWhere('category.id_parent = :idParent')
        ->setParameter('idParent', 9);

        // dump($qb);exit;

        // dump($qb); exit;
  

        // if ($this->configuration->getBoolean('PS_STOCK_MANAGEMENT')) {
        //     $qb->addSelect('sa.`quantity`');
        // }

        // $this->searchCriteriaApplicator
        //     ->applyPagination($searchCriteria, $qb)
        //     ->applySorting($searchCriteria, $qb)
        // ;

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria): QueryBuilder
    {
        $qb = $this->getQueryBuilder($searchCriteria->getFilters());
        $qb->select('categorylang.id_category');

        // dump($qb); exit;
        // $qb->select('COUNT(categorylang.`id_category`)');
  

        $qb->andWhere('categorylang.id_category = :idCategory')
        ->setParameter('idCategory', 6);

        return $qb;
    }

    /**
     * Gets query builder.
     *
     * @param array $filterValues
     *
     * @return QueryBuilder
     */
    private function getQueryBuilder(array $filterValues): QueryBuilder
    {
        // $qb = $this->connection
        //     ->createQueryBuilder()
        //     ->from($this->dbPrefix . 'category', 'category')
        // ;
// echo "fffffffffff";
        $qb = $this->connection
        ->createQueryBuilder()
        ->from($this->dbPrefix . 'category', 'category')
        ->innerJoin(
            'category',
            $this->dbPrefix . 'category_lang',
            'categorylang',
            'categorylang.`id_category` = category.`id_category`'
        );



        $qb->setParameter('id_shop', $this->contextShopId);
        $qb->setParameter('id_lang', $this->contextLanguageId);



        return $qb;
    }
}
