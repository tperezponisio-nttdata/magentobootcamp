<?php

namespace NTTData\Employees\Model;

use NTTData\Employees\Model\ResourceModel\HealthInsurancePlan as HealthInsurancePlanResourceModel;
use Magento\Framework\Model\AbstractModel;

class HealthInsurancePlan extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(HealthInsurancePlanResourceModel::class);
    }

}
