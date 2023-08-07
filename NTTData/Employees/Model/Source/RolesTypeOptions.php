<?php

namespace NTTData\Employees\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use NTTData\Employees\Model\ResourceModel\RolesType\CollectionFactory as RolesTypeCollectionFactory;

class RolesTypeOptions implements OptionSourceInterface
{
    protected $rolesTypeCollectionFactory;

    public function __construct(RolesTypeCollectionFactory $rolesTypeCollectionFactory)
    {
        $this->rolesTypeCollectionFactory = $rolesTypeCollectionFactory;
    }

    public function getData()
    {
        $collection = $this->rolesTypeCollectionFactory->create();
        $data = [];

        foreach ($collection as $model) {
            $data[] = [
                'id' => $model->getId(),
                'description' => $model->getDescription()
            ];
            // $data[] = [
            //     'id' => $model->getData('id'),
            //     'description' => $model->getData('description')
            // ];
        }

        return $data;
    }

    public function toOptionArray()
    {
        $rolesData = $this->getData();
        $options = [
            ['value' => null, 'label' => __('-- Select Role Type --')],
        ];
        
        foreach ($rolesData as $role) {
            $options[] = [
                'value' => $role['id'],
                'label' => $role['description']
            ];
        }

        return $options;
    }
}
