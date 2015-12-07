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
     * Get vendors for the current product in registry
     *
     * @return \Training4\VendorList\Model\Resource\Vendor\Collection|array
     */
    public function getVendors()
    {
        /** @var \Training4\VendorList\Model\Resource\Vendor\Collection $vendorCollection */
        return $this->_objectManager->create('\Training4\VendorList\Model\Vendor')
            ->getCollection()
            ->addFieldToSelect('name');
    }
}
