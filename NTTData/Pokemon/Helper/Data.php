<?php

namespace NTTData\Pokemon\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    protected $scopeConfig;

    const API_REQUEST_URL = 'pokemon/params/api_url';
    const API_REQUEST_ENDPOINT = 'pokemon/params/api_endpoint';
    const API_REQUEST_LIMIT = 'pokemon/params/api_limit';

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->scopeConfig = $scopeConfig;
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

    public function getEndpoint()
    {
        return $this->getConfig(self::API_REQUEST_ENDPOINT) . '/?limit=' . $this->getLimit();
    }

    private function getLimit()
    {
        return $this->getConfig(self::API_REQUEST_LIMIT);
    }
}
