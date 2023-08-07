<?php

namespace NTTData\Employees\Model;

use NTTData\Employees\Model\ResourceModel\Roles as RolesResourceModel;
use Magento\Framework\Model\AbstractModel;

class Roles extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(RolesResourceModel::class);
    }

    //  ----------  Estos metodos no van más porque en RoleOptions directamente traigo la data de la collection  ----------  //

    // public function getId()
    // {
    //     return $this->getData('id');
    // }

    // public function getDescription()
    // {
    //     return $this->getData('description');
    // }
}
