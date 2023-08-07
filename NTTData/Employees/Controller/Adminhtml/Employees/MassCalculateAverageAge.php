<?php

namespace NTTData\Employees\Controller\Adminhtml\Employees;

use NTTData\Employees\Model\ResourceModel\Employees\CollectionFactory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Magento\Ui\Component\MassAction\Filter;

class MassCalculateAverageAge extends Action
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

        $totalAge = 0;
        $averageAge = 0;
        $count = 0;


        if (!empty($excluded) && $excluded == "false") {
            // 'Select All' option was selected
            foreach ($collection as $employee) {
                $totalAge += $this->getAge($employee)->y;
                $count++;
            }
        } else {
            // Specific items were selected
            if (!empty($selected)) {
                $collection->addFieldToFilter('id', ['in' => $selected]);
                foreach ($collection as $employee) {
                    $totalAge += $this->getAge($employee)->y;
                    $count++;
                }
            } else {
                $this->messageManager->addErrorMessage(__('No employees have been selected.'));
            }
        }

        $averageAge = $totalAge / $count;

        $this->messageManager->addSuccessMessage(__('Average age of selected emploees is: %1', round($averageAge, 2)));
        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index');


        // $selectedIds = $this->getRequest()->getParam('selected');
        // var_dump($selectedIds); 
        // die();

        // // si en algun momento se selecccionaron todos los empleados, el filtro devuelve vacio
        // $collection = $this->filter->getCollection($this->employeesFactory->create());

        // $totalAge = 0;
        // $averageAge = 0;
        // $count = $collection->getSize();

        // foreach ($collection as $employee) {            
        //     $totalAge += $this->getAge($employee)->y;            
        // }

        // if ($count == 0){
        //     $averageAge = 0;
        // } else {
        //     $averageAge = $totalAge / $count;
        // }

        // $this->messageManager->addSuccessMessage(__('Average age of selected emploees is: %1', round($averageAge, 2)));
        // $resultRedirect = $this->resultRedirectFactory->create();
        // return $resultRedirect->setPath('*/*/index');
    }

    private function getAge($employee)
    {
        $birthDate = new \DateTime($employee->getDateOfBirth());
        $now = new \DateTime();
        return $now->diff($birthDate);
    }
}
