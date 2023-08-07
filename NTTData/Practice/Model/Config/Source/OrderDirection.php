<?php
namespace NTTData\Practice\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class OrderDirection implements ArrayInterface
{
    public function toOptionArray(): array
    {
        return [
            ['value' => 'ASC', 'label' => __('ASC')],
            ['value' => 'DESC', 'label' => __('DESC')]
        ];
    }
}
