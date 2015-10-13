<?php

namespace BlueAcorn\Repository\Model\Resource;
use Magento\Framework\Model\Resource\Db\AbstractDb;

class Example extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('ba_repository_example', 'example_id');
    }
}