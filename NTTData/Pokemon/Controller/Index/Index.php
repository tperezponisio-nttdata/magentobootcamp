<?php
namespace NTTData\Pokemon\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $_pageFactory;

    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $variable = $this->_pageFactory->create();
		$variable->getConfig()->getTitle()->set(__('Pokemon API'));
		return $variable;
    }
}