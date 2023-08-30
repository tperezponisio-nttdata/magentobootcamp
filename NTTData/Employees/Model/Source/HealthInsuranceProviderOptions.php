<?php

namespace NTTData\Employees\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use NTTData\Employees\Model\ResourceModel\HealthInsuranceProvider\CollectionFactory as HealthInsuranceProviderCollectionFactory;

class HealthInsuranceProviderOptions implements OptionSourceInterface
{
    protected $healthInsuranceProviderCollectionFactory;

    public function __construct(HealthInsuranceProviderCollectionFactory $healthInsuranceProviderCollectionFactory)
    {
        $this->healthInsuranceProviderCollectionFactory = $healthInsuranceProviderCollectionFactory;
    }

    public function getData()
    {
        $collection = $this->healthInsuranceProviderCollectionFactory->create();
        $data = [];

        foreach ($collection as $model) {
            $data[] = [
                'id' => $model->getId(),
                'provider' => $model->getProvider()
            ];
        }

        return $data;
    }

    public function toOptionArray()
    {
        $rolesData = $this->getData();
        $options = [
            ['value' => null, 'label' => __('-- Select Health Insurance Provider --')],
        ];

        foreach ($rolesData as $role) {
            $options[] = [
                'value' => $role['id'],
                'label' => $role['provider']
            ];
        }

        return $options;
    }
}
