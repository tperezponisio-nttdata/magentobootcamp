<?php

namespace NTTData\Employees\Model\ResourceModel\Roles;

use NTTData\Employees\Model\Roles as RolesModel;
use NTTData\Employees\Model\ResourceModel\Roles as RolesResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            RolesModel::class,
            RolesResourceModel::class
        );
    } 
}