<?php

namespace NTTData\Practice\Block\Product;

class Productlist extends \Magento\Framework\View\Element\Template
{
   /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;
    protected \NTTData\Practice\Helper\Data $helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \NTTData\Practice\Helper\Data $helper
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
        parent::__construct($context);
        $this->helper = $helper;            // con este helper me traigo la data de Model/Config/Source
    }

    public function getCollection()
    {
        $enabled = $this->helper->isEnabled();
        if (!$enabled){
            return null;
        }

        $limit = intval($this->helper->getLimit());
        $orderField = $this->helper->getOrderField();
        $orderDirection = $this->helper->getOrderDirection();

        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->setOrder($orderField, $orderDirection);
        $collection->setPageSize($limit);

        return $collection;
    }
}

