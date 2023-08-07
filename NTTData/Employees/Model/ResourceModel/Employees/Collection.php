<?php

namespace NTTData\Employees\Model\ResourceModel\Employees;

use NTTData\Employees\Model\Employees as EmployeesModel;
use NTTData\Employees\Model\ResourceModel\Employees as EmployeesResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            EmployeesModel::class,
            EmployeesResourceModel::class
        );
    } 
}