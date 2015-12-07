<?php
/**
 * @package     Training4\VendorList
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\VendorList\Model\Resource\Vendor;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Training4\VendorList\Model\Vendor', 'Training4\VendorList\Model\Resource\Vendor');
    }

    /**
     * Add product filter to collection
     *
     * @param $productId
     * @return $this
     */
    public function addProductFilter($productId)
    {
        $this->getSelect()->join(
            ['link_table' => $this->getTable('training4_vendor2product')],
            'link_table.vendor_id = main_table.vendor_id',
            []
        )->where('link_table.product_id = ?', $productId);

        // Add vendor IDs filter
        return $this;
    }
}
