<?php
/**
 * @package     Training4\VendorList
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\VendorList\Block\Vendor;

use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class VendorList extends Template
{
    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * Initialize block with context and registry access
     *
     * @param ObjectManagerInterface $objectManager
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        ObjectManagerInterface $objectManager,
        Context $context,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        parent::__construct($context, $data);
    }

    /**
     * Get vendors filtered and sorted by user input or defaults
     *
     * @return \Training4\VendorList\Model\Resource\Vendor\Collection|array
     */
    public function getVendors()
    {
        /** @var $vendors \Training4\VendorList\Model\Resource\Vendor\Collection */
        $vendors = $this->_objectManager->create('\Training4\VendorList\Model\Vendor')
            ->getCollection()
            ->addFieldToSelect('*');

        /** @var $toolbar \Training4\VendorList\Block\Vendor\VendorList\Toolbar */
        $toolbar = $this->getChildBlock('vendor.list.toolbar');

        $vendors->setOrder($toolbar->getSortMode(), $toolbar->getSortDir());
        if ($search = $toolbar->getFilterLike()) {
            $vendors->addFieldToFilter('name', ['like' => '%' . $search . '%']);
        }

        return $vendors;
    }

    /**
     * Get URL for vendor given vendor_id
     *
     * @param string $id
     * @return string
     */
    public function getVendorUrl($id = '')
    {
        return $this->getUrl('*/*/view', ['id' => $id]);
    }

    /**
     * Get child toolbar block html
     *
     * @return string
     */
    public function getToolbarHtml()
    {
        return $this->getChildHtml('vendor.list.toolbar');
    }
}
