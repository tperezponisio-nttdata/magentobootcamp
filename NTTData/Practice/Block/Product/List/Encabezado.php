<?php

namespace NTTData\Practice\Block\Product\List;

class Encabezado extends \NTTData\Practice\Block\Product\Productlist
{
    public function __construct(
		\Magento\Backend\Block\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \NTTData\Practice\Helper\Data $helper)
	{
		parent::__construct($context, $productCollectionFactory, $helper);
	}
}
