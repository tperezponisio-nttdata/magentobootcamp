<?php

namespace NTTData\Employees\Model\ResourceModel\Employees\Grid;

// Asi estaba antes de intentar lo de los join

use NTTData\Employees\Model\ResourceModel\Employees\Collection as EmployeesCollection;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document as EmployeesModel;
use Magento\Framework\Api\Search\SearchResultInterface;


class Collection extends EmployeesCollection implements SearchResultInterface
{
    protected $aggregations;

    // @codingStandardsIgnoreStart
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = EmployeesModel::class,
        $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }

    protected function _initSelect()
    {
        parent::_initSelect();

        $this->getSelect()
            ->joinLeft(
                ['secondTable' => $this->getTable('roles')],
                'main_table.id_role = secondTable.id',
                ['role_description' => 'secondTable.description']
            )
            ->joinLeft(
                ['thirdTable' => $this->getTable('roles_type')],
                'main_table.id_role_type = thirdTable.id',
                ['role_type_description' => 'thirdTable.description']
            )
            ->joinLeft(
                ['fourthTable' => $this->getTable('health_insurance_provider')],
                'main_table.id_health_insurance_provider = fourthTable.id',
                ['health_insurance_provider' => 'fourthTable.provider']
            )
            ->columns(new \Zend_Db_Expr("TIMESTAMPDIFF(YEAR, main_table.date_of_birth, CURDATE()) AS age")); // agrega la columna age haciendo la diferencia de años entre current date y la date of birth            

        // Agrego los filtros para id, role y role description
        $this->addFilterToMap('id', 'main_table.id');
        $this->addFilterToMap('role_description', 'secondTable.description');
        $this->addFilterToMap('role_type_description', 'thirdTable.description');
        $this->addFilterToMap('health_insurance_provider', 'fourthTable.provider');

        return $this;
    }

    public function getAggregations()
    {
        return $this->aggregations;
    }
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }
    public function getSearchCriteria()
    {
        return null;
    }
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
    public function getTotalCount()
    {
        return $this->getSize();
    }
    public function setTotalCount($totalCount)
    {
        return $this;
    }
    public function setItems(array $items = null)
    {
        return $this;
    }
}
