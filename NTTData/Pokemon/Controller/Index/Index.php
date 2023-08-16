<?php
namespace NTTData\Pokemon\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use NTTData\Pokemon\Helper\Data;

class Index extends Action
{
    protected $_pageFactory;
    protected Data $helper;

    public function __construct(
        PageFactory $pageFactory,
        Data $helper,
        Context $context,
        )
    {
        $this->_pageFactory = $pageFactory;
        $this->helper = $helper;
        parent::__construct($context);
    }

    public function execute()
    {
        // si el store no es el de pokemon me manda al index y no puedo acceder a la pagina de la api
        if (!$this->helper->storeViewChecker()) {
            return $this->_redirect('/');
        }
        $variable = $this->_pageFactory->create();
		$variable->getConfig()->getTitle()->set(__('Pokemon API'));
		return $variable;
    }
}