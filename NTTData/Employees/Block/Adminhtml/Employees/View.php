<?php

namespace NTTData\Employees\Block\Adminhtml\Employees;

class View extends \Magento\Backend\Block\Widget\Form\Container
{
    protected $employeesFactory;
    protected $_blockGroup = 'NTTData_Employees';
    protected $_coreRegistry;

    public function __construct(
        \Magento\Backend\Block\Widget\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    protected function _construct()
    {
        $this->_controller = 'adminhtml_employees';
        $this->_mode = 'view';

        parent::_construct();

        // $this->removeButton('delete');
        $this->removeButton('reset');
        $this->removeButton('save');
        $this->setId('employees_view');

        // Add the Edit button
        $this->addButton(
            'edit_employee',
            [
                'label' => __('Edit'),
                'class' => 'edit',
                'onclick' => 'setLocation(\'' . $this->getEditUrl() . '\')'
            ],
            10 // Priority value for the Edit button
        );
    }

    public function getEmployeeId()
    {
        return $this->getRequest()->getParam('id');
    }

    public function getUrl($params = '', $params2 = [])
    {
        $params2['id'] = $this->getEmployeeId();
        return parent::getUrl($params, $params2);
    }

    public function getEditUrl()
    {
        return $this->getUrl('nttdata_employees/employees/form');
    }
}
