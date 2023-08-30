<?php

namespace NTTData\Employees\Block\Adminhtml\Employees\Tab;

use Magento\Backend\Block\Template\Context;
use NTTData\Employees\Model\EmployeesFactory;
use NTTData\Employees\Model\HealthInsuranceProviderFactory;
use NTTData\Employees\Model\HealthInsurancePlanFactory;
use NTTData\Employees\Model\RolesFactory;
use NTTData\Employees\Model\RolesTypeFactory;
use \Magento\Framework\View\Element\Template;
use \Magento\Backend\Block\Widget\Tab\TabInterface;

class WorkInfo extends Template implements TabInterface
{
    protected $employeesFactory;
    protected $healthInsuranceProviderFactory;
    protected $healthInsurancePlanFactory;
    protected $rolesFactory;
    protected $rolesTypeFactory;

    public function __construct(
        Context $context,
        EmployeesFactory $employeesFactory,
        HealthInsuranceProviderFactory $healthInsuranceProviderFactory,
        HealthInsurancePlanFactory $healthInsurancePlanFactory,
        RolesFactory $rolesFactory,
        RolesTypeFactory $rolesTypeFactory,
        array $data = []
    ) {
        $this->employeesFactory = $employeesFactory;
        $this->healthInsuranceProviderFactory = $healthInsuranceProviderFactory;
        $this->healthInsurancePlanFactory = $healthInsurancePlanFactory;
        $this->rolesFactory = $rolesFactory;
        $this->rolesTypeFactory = $rolesTypeFactory;
        parent::__construct($context, $data);
    }

    public function getEmployeeData()
    {
        $employeeId = $this->getRequest()->getParam('id');
        if ($employeeId) {
            $employee = $this->employeesFactory->create()->load($employeeId);
            return $employee;
        }
        return null;
    }

    public function getEmployeeHealthInsuranceProvider()
    {
        $employee = $this->getEmployeeData();
        if ($employee) {
            $idHealthProvider = $employee->getIdHealthInsuranceProvider();
            $employeeHealthInsuranceProvider = $this->healthInsuranceProviderFactory->create()->load($idHealthProvider);
            return $employeeHealthInsuranceProvider;
        }
        return null;
    }

    public function getEmployeeHealthInsurancePlan()
    {
        $employee = $this->getEmployeeData();
        if ($employee) {
            $idHealthPlan = $employee->getIdHealthInsurancePlan();
            $employeeHealthInsurancePlan = $this->healthInsurancePlanFactory->create()->load($idHealthPlan);
            return $employeeHealthInsurancePlan;
        }
        return null;
    }

    public function getEmployeeRole()
    {
        $employee = $this->getEmployeeData();
        if ($employee) {
            $idRole = $employee->getIdRole();
            $employeeRole = $this->rolesFactory->create()->load($idRole);
            return $employeeRole;
        }
        return null;
    }

    public function getEmployeeRoleType()
    {
        $employee = $this->getEmployeeData();
        if ($employee) {
            $idRoleType = $employee->getIdRoleType();
            $employeeRoleType = $this->rolesTypeFactory->create()->load($idRoleType);
            return $employeeRoleType;
        }
        return null;
    }

    /**
     * ######################## TAB settings #################################
     */

    /**
     * {@inheritdoc}
     */
    public function getTabLabel()
    {
        return __('Work Information');
    }

    /**
     * {@inheritdoc}
     */
    public function getTabTitle()
    {
        return __('Work Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }
}
