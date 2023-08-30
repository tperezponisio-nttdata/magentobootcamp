<?php

namespace NTTData\Employees\Controller\Adminhtml\Employees;

use NTTData\Employees\Model\EmployeesFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Registry;


class View extends Action
{
    protected $resultPageFactory;
    protected $employeesFactory;
    protected $_coreRegistry = null;


    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        EmployeesFactory $employeesFactory
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->resultPageFactory = $resultPageFactory;
        $this->employeesFactory = $employeesFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultPage = $this->resultPageFactory->create();
        $employeeId = $this->getRequest()->getParam('id');

        if ($employeeId) {            
            $employeeModel = $this->employeesFactory->create()->load($employeeId);

            if ($employeeModel->getId()) {                
                $employeeName = $employeeModel->getName();
                $employeeLastName = $employeeModel->getLastName();
                
                $pageTitle = __('%2 %3 (#%1)', $employeeId, $employeeName, $employeeLastName);
                $resultPage->getConfig()->getTitle()->prepend($pageTitle);
            }
        }

        $this->_coreRegistry->register('employees_view', $employeeModel);
        // $this->_coreRegistry->register('current_order', $order);

        $resultPage->getConfig()->getTitle()->set(__('View Employee'));
        return $resultPage;
    }
}
