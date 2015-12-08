<?php
/**
 * @package     Training4\VendorList
 * @version     0.1.0
 * @author      Sam Tay @ Blue Acorn, Inc. <code@blueacorn.com>
 * @copyright   Copyright © 2015 Blue Acorn, Inc.
 */
namespace Training4\VendorList\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Training4\VendorList\Api\Data\VendorInterface;

class Vendor extends AbstractExtensibleModel implements VendorInterface
{
    protected function _construct()
    {
        $this->_init('\Training4\VendorList\Model\Resource\Vendor');
    }

    /**
     * Set an extension attributes object.
     *
     * @param \Training4\VendorList\Api\Data\VendorExtensionInterface $extensionAttributes
     * @return $this
     */
    public function setExtensionAttributes(
        \Training4\VendorList\Api\Data\VendorExtensionInterface $extensionAttributes
    ) {
        return $this->_setExtensionAttributes($extensionAttributes);
    }

    /**
     * Retrieve existing extension attributes object or create a new one.
     *
     * @return \Training4\VendorList\Api\Data\VendorExtensionInterface|null
     */
    public function getExtensionAttributes()
    {
        return $this->_getExtensionAttributes();
    }

    /**
     * Retrieve vendor identifier
     *
     * @return int
     */
    public function getVendorId()
    {
        return $this->getData(VendorInterface::VENDOR_ID);
    }

    /**
     * Set vendor identifier
     *
     * @param int $vendorId
     * @return $this
     */
    public function setVendorId($vendorId)
    {
        return $this->setData(VendorInterface::VENDOR_ID, $vendorId);
    }

    /**
     * Retrieve vendor name
     *
     * @return string
     */
    public function getVendorName()
    {
        return $this->getData(VendorInterface::VENDOR_NAME);
    }

    /**
     * Set vendor name
     *
     * @param string $vendorName
     * @return $this
     */
    public function setVendorName($vendorName)
    {
        return $this->setData(VendorInterface::VENDOR_NAME);
    }

    /**
     * Get associated products
     *
     * @return \Magento\Catalog\Api\Data\ProductInterface[]|null
     */
    public function getProducts()
    {
        return $this->getExtensionAttributes()
            ? $this->getExtensionAttributes()->getProducts()
            : null;
    }
}
