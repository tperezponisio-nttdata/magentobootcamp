<?php

namespace NTTData\Employees\Model;

use NTTData\Employees\Model\ResourceModel\Employees as EmployeesResourceModel;
use Magento\Framework\Model\AbstractModel;

class Employees extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(EmployeesResourceModel::class);
    }
}
