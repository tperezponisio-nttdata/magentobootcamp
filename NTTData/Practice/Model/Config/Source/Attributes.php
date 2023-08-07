<?php

namespace NTTData\Practice\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Attributes implements ArrayInterface
{
    protected \NTTData\Practice\Helper\Data $helper;
    protected \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeCollectionFactory;

    public function __construct(
        \NTTData\Practice\Helper\Data $helper,
        \Magento\Catalog\Model\ResourceModel\Product\Attribute\CollectionFactory $attributeCollectionFactory,
    ) {
        $this->helper = $helper;
        $this->attributeCollectionFactory = $attributeCollectionFactory;
    }

    public function getAttributeCollectionItems(): array
    {
        return $this->attributeCollectionFactory->create()->getItems();
    }

    public function toOptionArray(): array
    {
        $options = [];
        foreach ($this->getAttributeCollectionItems() as $attribute) {            
            $options[] = ['value' => $attribute->getName(), 'label' => __($attribute->getFrontendLabel())];
        }
        return $options;
    }
}
