<?php

namespace NTTData\Empleados\Model;

// Every model extends the Magento\Framework\Model\AbstractModelclass,
// which inherits the \Magento\Framework\DataObjectclass, hence, we can
// call the setDataand getData functions on our model, to get or set
// the data of a model respectively. 

use Magento\Framework\Model\AbstractModel;
use NTTData\Empleados\Model\ResourceModel\Empleado as ResourceModel;

class Car extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }
}