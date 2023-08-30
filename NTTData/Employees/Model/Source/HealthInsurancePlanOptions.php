<?php

namespace NTTData\Employees\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use NTTData\Employees\Model\ResourceModel\HealthInsurancePlan\CollectionFactory as HealthInsurancePlanCollectionFactory;

class HealthInsurancePlanOptions implements OptionSourceInterface
{
    protected $healthInsurancePlanCollectionFactory;

    public function __construct(HealthInsurancePlanCollectionFactory $healthInsurancePlanCollectionFactory)
    {
        $this->healthInsurancePlanCollectionFactory = $healthInsurancePlanCollectionFactory;
    }

    public function getData()
    {
        $collection = $this->healthInsurancePlanCollectionFactory->create();
        $data = [];

        foreach ($collection as $model) {
            $data[] = [
                'id' => $model->getId(),
                'plan' => $model->getPlan()
            ];
        }

        return $data;
    }

    public function toOptionArray()
    {
        $rolesData = $this->getData();
        $options = [
            ['value' => null, 'label' => __('-- Select Health Insurance Plan --')],
        ];

        foreach ($rolesData as $role) {
            $options[] = [
                'value' => $role['id'],
                'label' => $role['plan']
            ];
        }

        return $options;
    }
}
