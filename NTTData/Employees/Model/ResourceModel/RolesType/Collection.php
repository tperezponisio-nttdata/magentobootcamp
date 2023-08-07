<?php

namespace NTTData\Employees\Model\ResourceModel\RolesType;

use NTTData\Employees\Model\RolesType as RolesTypeModel;
use NTTData\Employees\Model\ResourceModel\RolesType as RolesTypeResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            RolesTypeModel::class,
            RolesTypeResourceModel::class
        );
    } 
}