<?php

namespace NTTData\Practice\Block\Time;

class Hour extends \Magento\Framework\View\Element\Template
{
    private \NTTData\Practice\Helper\Data $helper;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \NTTData\Practice\Helper\Data $helper
      )
    {
        parent::__construct($context);
        $this->helper = $helper;
    }

    public function getTimeToTranslate(){
        return $this->helper->getStringTranslate();
    }

}
