<?php

namespace BlueAcorn\Training\Model\Resource;

use Magento\Framework\Model\Resource\Db\AbstractDb;

class Test extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('blueacorn_training_entity', 'entity_id');
    }
}