<?php

namespace NTTData\Employees\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use NTTData\Employees\Model\ResourceModel\Roles\CollectionFactory as RolesCollectionFactory;

class RolesOptions implements OptionSourceInterface
{
    protected $rolesCollectionFactory;

    public function __construct(RolesCollectionFactory $rolesCollectionFactory)
    {
        $this->rolesCollectionFactory = $rolesCollectionFactory;
    }

    public function getData()
    {
        $collection = $this->rolesCollectionFactory->create();
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
            ['value' => null, 'label' => __('-- Select Role --')],
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
