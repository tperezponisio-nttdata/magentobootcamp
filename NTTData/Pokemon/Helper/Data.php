<?php

namespace NTTData\Pokemon\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\StoreManagerInterface;

class Data extends AbstractHelper
{
    protected $scopeConfig;
    protected $storeManager;

    const API_REQUEST_URL = 'pokemon/params/api_url';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
    }

    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }

    public function getUrl()
    {
        return $this->getConfig(self::API_REQUEST_URL);
    }

    public function storeViewChecker(): bool
    {
        $storeViewCode = $this->storeManager->getStore()->getCode();
        if ($storeViewCode != 'pokemons_store_view') {
            return false;
        }
        return true;
    }
    
}
