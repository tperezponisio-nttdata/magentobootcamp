<?php

namespace NTTData\Employees\Model\ResourceModel\HealthInsuranceProvider;

use NTTData\Employees\Model\HealthInsuranceProvider as HealthInsuranceProviderModel;
use NTTData\Employees\Model\ResourceModel\HealthInsuranceProvider as HealthInsuranceProviderResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            HealthInsuranceProviderModel::class,
            HealthInsuranceProviderResourceModel::class
        );
    } 
}