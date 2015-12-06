<?php
/**
 * @package     Training4\Vendor
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\Vendor\Model\Resource\Vendor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Training4\Vendor\Model\Vendor', 'Training4\Vendor\Model\Resource\Vendor');
    }

    /**
     * Add product filter to collection
     *
     * @param $productId
     * @return $this
     */
    public function addProductFilter($productId)
    {
        // Get vendor IDs from link table
        $connection = $this->getConnection();
        $select = $connection->select()
            ->from($this->getTable('training4_vendor2product'), 'vendor_id')
            ->where('product_id = ?', $productId);
        $vendorIds = array_map('reset', $connection->fetchAll($select));

        // Add vendor IDs filter
        return $this->addFieldToFilter('vendor_id', ['in' => $vendorIds]);
    }
}
