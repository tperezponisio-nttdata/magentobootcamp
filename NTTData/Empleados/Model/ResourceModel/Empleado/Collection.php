<?php

namespace NTTData\Empleados\Model\ResourceModel\Empleado;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use NTTData\Empleados\Model\Empleado as Model;
use NTTData\Empleados\Model\ResourceModel\Empleado as ResourceModel;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
