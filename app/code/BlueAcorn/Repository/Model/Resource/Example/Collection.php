<?php

namespace BlueAcorn\Repository\Model\Resource\Example;
use Magento\Framework\Model\Resource\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('BlueAcorn\Repository\Model\Example', 'BlueAcorn\Repository\Model\Resource\Example');
    }
}