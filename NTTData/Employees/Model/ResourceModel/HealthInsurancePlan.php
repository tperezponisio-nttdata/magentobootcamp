<?php

namespace NTTData\Employees\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class HealthInsurancePlan extends AbstractDb
{
    protected function _construct()
    {        
        $this->_init('health_insurance_plan', 'id');
    }
}