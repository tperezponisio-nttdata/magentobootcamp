<?php

namespace NTTData\Employees\Model;

use NTTData\Employees\Model\ResourceModel\HealthInsuranceProvider as HealthInsuranceProviderResourceModel;
use Magento\Framework\Model\AbstractModel;

class HealthInsuranceProvider extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(HealthInsuranceProviderResourceModel::class);
    }

}
