<?php

namespace BlueAcorn\Training\Model;

use Magento\Framework\Model\AbstractModel;

class Test extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('\BlueAcorn\Training\Model\Resource\Test');
    }
}