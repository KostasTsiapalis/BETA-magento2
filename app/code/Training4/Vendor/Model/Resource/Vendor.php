<?php
/**
 * @package     Training4\Vendor
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\Vendor\Model\Resource;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Vendor extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('training4_vendor', 'vendor_id');
    }
}
