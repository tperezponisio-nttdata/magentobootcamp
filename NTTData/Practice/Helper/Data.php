<?php

namespace NTTData\Practice\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $scopeConfig;

    const IS_ENABLED = 'practice/params/enabled';
    const LIMIT = 'practice/params/limit';
    const ORDER_FIELD = 'practice/params/order_field';
    const ORDER_DIRECTION = 'practice/params/order_direction';      
    

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,        
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig       
    ) {
        parent::__construct($context);        
        $this->scopeConfig = $scopeConfig;   
    }

    public function getStringTranslate()
    {
        return __("Now it is %1, I am learning translations", $this->getCurrentTime());
    }

    public function getCurrentTime()
    {
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        $horaActual = date('H:i:s');
        return $horaActual;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function isEnabled()
    {
        return $this->getConfig(self::IS_ENABLED);
    }

    public function getLimit()
    {
        return $this->getConfig(self::LIMIT);
    }

    public function getOrderField()
    {
        return $this->getConfig(self::ORDER_FIELD);
    }

    public function getOrderDirection()
    {
        return $this->getConfig(self::ORDER_DIRECTION);
    }
    
}
