<?php

namespace NTTData\Employees\Model;

use NTTData\Employees\Model\ResourceModel\RolesType as RolesTypeResourceModel;
use Magento\Framework\Model\AbstractModel;

class RolesType extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(RolesTypeResourceModel::class);
    }
}
