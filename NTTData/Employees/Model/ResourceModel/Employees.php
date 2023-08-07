<?php

namespace NTTData\Employees\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Employees extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('employees', 'id');
    }
}