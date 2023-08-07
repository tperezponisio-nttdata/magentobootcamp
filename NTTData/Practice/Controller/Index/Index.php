<?php
namespace NTTData\Practice\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		parent::__construct($context);
	}

	public function execute()
	{
		// echo "Hello World";
		return $this->_pageFactory->create();
	}
}