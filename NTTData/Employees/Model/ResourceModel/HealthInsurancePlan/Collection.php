<?php

namespace NTTData\Employees\Model\ResourceModel\HealthInsurancePlan;

use NTTData\Employees\Model\HealthInsurancePlan as HealthInsurancePlanModel;
use NTTData\Employees\Model\ResourceModel\HealthInsurancePlan as HealthInsurancePlanResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            HealthInsurancePlanModel::class,
            HealthInsurancePlanResourceModel::class
        );
    } 
}