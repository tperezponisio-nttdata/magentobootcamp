<?php

namespace NTTData\Employees\Controller\Adminhtml\Employees;

use NTTData\Employees\Model\ResourceModel\Employees\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $employeesFactory;
    protected $filter;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        Registry $registry,
        Filter $filter,
        CollectionFactory $employeesFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->employeesFactory = $employeesFactory;
        $this->filter = $filter;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->employeesFactory->create();
        $selected = $this->getRequest()->getParam('selected');
        $excluded = $this->getRequest()->getParam('excluded');
        // echo 'selected: ' . '<br>';
        // var_dump($selected);
        // echo '<br>' . 'excluded: ' . '<br>';
        // var_dump($excluded);
        // die();

        if (!empty($excluded) && $excluded == "false") {
            // 'Select All' option was selected
            foreach ($collection as $employee) {
                $employee->delete();
            }
            $this->messageManager->addSuccessMessage(__('All employees have been deleted.'));
        } else {
            // Specific items were selected
            if (!empty($selected)) {
                $collection->addFieldToFilter('id', ['in' => $selected]);
                $count = 0;
                foreach ($collection as $employee) {
                    $employee->delete();
                    $count++;
                }
                $this->messageManager->addSuccessMessage(__('A total of %1 employee(s) have been deleted.', $count));
            } else {
                $this->messageManager->addErrorMessage(__('No employees have been selected.'));
            }
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');

        // $collection = $this->filter->getCollection($this->employeesFactory->create());

        // $count = 0;
        // foreach ($collection as $employee) {
        //     $employee->delete();
        //     $count++;
        // }

        // $this->messageManager->addSuccess(__('A total of %1 employee(s) have been deleted.', $count));
        // $resultRedirect = $this->resultRedirectFactory->create();
        // return $resultRedirect->setPath('*/*/index');
    }
}
