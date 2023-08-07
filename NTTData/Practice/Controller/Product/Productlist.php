<?php
namespace NTTData\Practice\Controller\Product;

class Productlist extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;
	private \NTTData\Practice\Helper\Data $helper;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\NTTData\Practice\Helper\Data $helper)
	{
		parent::__construct($context);
		$this->helper = $helper;
		$this->_pageFactory = $pageFactory;
	}

	public function execute()
	{
		$variable = $this->_pageFactory->create();
		$variable->getConfig()->getTitle()->set(__($this->helper->getStringTranslate()));

		return $variable;
	}
}
