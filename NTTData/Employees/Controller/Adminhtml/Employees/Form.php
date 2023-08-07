<?php

namespace NTTData\Employees\Controller\Adminhtml\Employees;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;

class Form extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        // aca no entiendo como funciona
        // entiendo que este controller manda los datos del empleado en el resultPage?
        // entonces puedo preghuntar si esta cargado el id para mandar o no datos al form

        // $id = $this->getRequest()->getParam('id');
        // $employee = $this->_objectManager->create('NTTData\Employees\Model\Employees')->load($id);

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->set(__('Employees Add/Edit Form'));
        return $resultPage;
    }
}
