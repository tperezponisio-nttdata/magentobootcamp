<?php

namespace NTTData\Employees\Controller\Adminhtml\Employees;

use NTTData\Employees\Model\EmployeesFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Delete extends Action
{
    protected $resultPageFactory;
    protected $EmployeesFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        EmployeesFactory $EmployeesFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->EmployeesFactory = $EmployeesFactory;
        parent::__construct($context);
    }

    // que me quede un solo delete, ver si recibo un solo id o un array
    public function execute()
    {
        $resultRedirectFactory = $this->resultRedirectFactory->create();
        try {
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model = $this->EmployeesFactory->create()->load($id);                
                $model->delete();
                $this->messageManager->addSuccessMessage(__("Employee Deleted Successfully."));
            } else {
                $this->messageManager->addErrorMessage(__("Something went wrong, Please try again."));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e, __("We can't delete record, Please try again."));
        }
        return $resultRedirectFactory->setPath('*/*/index');
    }
}
